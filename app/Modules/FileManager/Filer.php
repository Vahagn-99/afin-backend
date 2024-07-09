<?php

namespace App\Modules\FileManager;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * @method static FileManagerInterface apply(UploadedFile $file, string $directory, bool $usOriginalName = false, string $prefix = '', string $access = 'public')
 * @method static string path()
 * @method static string url()
 * @method static string name()
 */
class Filer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'filer';
    }
}