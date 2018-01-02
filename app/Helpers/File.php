<?php
namespace Mutant\File\App\Helpers;

use Mutant\File\App\Helpers\FileHelper as FH;

class File
{
    public $path;
    public $handle;

    public static function init(string $path)
    {
        $file = new self;
        $file->handle = FH::createOrOpenFile($path);
        $file->path = $path;
        return $file;
    }

    public function getMimeType()
    {
        return FH::getMimeType($this->path);
    }

    public function getExtension()
    {
        return FH::getExtension($this->path);
    }
}