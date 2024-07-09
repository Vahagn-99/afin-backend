<?php

namespace App\Modules\JsonManager;

use Carbon\Carbon;
use Carbon\Translator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class JsonTransactionManager implements ArrayableTransactionManagerInterface
{
    private ?string $file;
    private string $path;

    public function __construct(private readonly Filesystem $filesystem)
    {
    }

    /**
     * @throws FileNotFoundException
     */
    public function get(string $path): static
    {
        $this->getJsonFileByGivenPath($path);
        return $this;
    }

    public function toArray(): array
    {
        return json_decode($this->file, true);
    }

    public function save(array $transactions, string $date): string
    {
        $data = json_encode($transactions, JSON_PRETTY_PRINT);
        $this->pathByDate($date);
        $this->filesystem->put($this->path, $data);

        return $this->path();
    }

    private function pathByDate(string $date): void
    {
        $date = Carbon::parse($date);
        $monthName = $date->setLocalTranslator(Translator::get('ru'))->monthName;
        $this->path = $date->year . '_' . $monthName . '_transactions.json';
    }

    /**
     * @throws FileNotFoundException
     */
    private function getJsonFileByGivenPath(?string $path = null): void
    {
        $path = $path ?? $this->path;
        if (!$this->filesystem->exists($path)) throw new FileNotFoundException;

        $this->file = $this->filesystem->get($path);
    }

    public function all(): array
    {
        $jsonFiles = Arr::where($this->filesystem->allFiles(), fn($file) => Str::endsWith($file, '.json'));
        return Arr::map($jsonFiles, fn($file) => Str::replaceLast('.json', '', $file));
    }

    public function name(): string
    {
        return File::name($this->path);
    }

    public function path(): string
    {
        return $this->path;
    }
}