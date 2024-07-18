<?php

namespace App\Modules\FilterManager\Console\Command;

use App\Modules\FilterManager\Compare\Comparable;
use App\Modules\FilterManager\Compare\HasComparing;
use App\Modules\FilterManager\Filter\FilterInterface;
use App\Modules\FilterManager\Search\HasSearchingViaScout;
use App\Modules\FilterManager\Search\Searchable;
use App\Modules\FilterManager\Sort\HasSorting;
use App\Modules\FilterManager\Sort\Sortable;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeFilterCommand extends Command
{
    protected $signature = 'make:filter {name : The name of the filter class}
                                        {--model= : The name of the model class where should be used this filter}
                                        {--s : Include sortable interface and trait}
                                        {--c : Include comparable interface and trait}
                                        {--r : Include searchable interface and trait}';

    protected $description = 'Create a new filter class';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $name = $this->argument('name');
        $model = $this->option('model');
        $isSortable = $this->option('s');
        $isComparable = $this->option('c');
        $isSearchable = $this->option('r');

        $stub = File::get(__DIR__ . '/make_filter.stub');

        $interfaces = [];
        $traits = [];
        $uses = [
            Builder::class,
        ];

        if ($isSortable) {
            $interfaces[] = 'Sortable';
            $traits[] = 'HasSorting';
            $uses[] = Sortable::class;
            $uses[] = HasSorting::class;
        }

        if ($isComparable) {
            $interfaces[] = 'Comparable';
            $traits[] = 'HasComparing';
            $uses[] = Comparable::class;
            $uses[] = HasComparing::class;
        }

        if ($isSearchable) {
            $interfaces[] = 'Searchable';
            $traits[] = 'HasSearchingViaScout';
            $uses[] = Searchable::class;
            $uses[] = HasSearchingViaScout::class;
        }


        $interfaceString = 'implements ' . implode(', ', empty($interfaces) ? ['\\' . FilterInterface::class] : $interfaces);
        $traitString = empty($traits) ? '' : 'use ' . implode(', ', $traits) . ';';
        $usesString = '';
        foreach ($uses as $use) {
            $usesString .= "use $use;" . "\r\n";
        }

        $filterContent = str_replace(
            ['{{ uses }}', '{{ class }}', '{{ interfaces }}', '{{ traits }}'],
            [$usesString, $name, $interfaceString, $traitString],
            $stub
        );

        $path = app_path('Filters');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $fullPath = "$path/$name.php";

        if (File::exists($fullPath)) {
            $this->error("Filter with $name name has already been created.");
            return;
        }

        File::put($fullPath, $filterContent);

        if ($model) {
            $this->updateModel($model, $name);
        }

        $this->info("Filter $name created successfully.");
    }

    protected function updateModel(string $model, string $filter): void
    {
        $modelPath = app_path("Models/$model.php");

        if (!File::exists($modelPath)) {
            $this->error("Model $model does not exist.");
            return;
        }

        $modelContent = File::get($modelPath);
        $updated = false;

        // Extract the filter namespace dynamically
        $filterNamespace = "App\\Filters\\$filter";

        // Add the filter use statement if not already present
        if (!Str::contains($modelContent, "use $filterNamespace;")) {
            $modelContent = preg_replace(
                '/(use\s+Illuminate\\\Database\\\Eloquent\\\Model;)/',
                "$1\nuse $filterNamespace;",
                $modelContent
            );

            $updated = true;
        }

        // Add HasFilter trait if not already present
        if (!Str::contains($modelContent, 'use HasFilter;')) {
            // Add the HasFilter use statement
            $modelContent = preg_replace(
                '/(use\s+Illuminate\\\Database\\\Eloquent\\\Model;)/',
                "$1\nuse App\\Modules\\FilterManager\\Filter\\HasFilter;",
                $modelContent
            );

            // Add the HasFilter trait usage within the class if not already present
            if (!Str::contains($modelContent, 'use HasFilter')) {
                $modelContent = preg_replace(
                    '/(use\s+HasFactory;)/',
                    "$1\n    use HasFilter;",
                    $modelContent
                );
            }

            $updated = true;
        }

        // Set the $filter property after all traits
        if (!Str::contains($modelContent, 'protected string $filter')) {
            $modelContent = preg_replace(
                '/(class\s+\w+\s+extends\s+Model\s*\{)/',
                "$1\n\n    public string \$filter = $filter::class;",
                $modelContent
            );

            $updated = true;
        } else {
            // Ensure $filter property is after the traits
            $modelContent = preg_replace_callback(
                '/(use\s+[^\n]+\;\s*)+(public\s+string\s+\$filter\s*=\s*[^\n]+;)/',
                function ($matches) use ($filter) {
                    return str_replace($matches[2], "", $matches[0]) . "    public string \$filter = $filter::class;";
                },
                $modelContent
            );
        }

        if ($updated) {
            File::put($modelPath, $modelContent);
            $this->info("Model $model updated successfully.");
        } else {
            $this->info("Model $model already contains the required changes.");
        }
    }
}
