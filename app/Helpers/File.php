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

    public function lock()
    {
        //TBI
    }

    public function unlock()
    {
        //TBI
    }

    public function getMimeType()
    {
        return FH::getMimeType($this->path);
    }

    public function getExtension()
    {
        return FH::getExtension($this->path);
    }

    public function write(string $text)
    {
        return FH::writeToFile($this->handle, $text);
    }

    public function close()
    {

    }

    public function append(string $text)
    {
        return FH::appendToFile($this->handle, $text);
    }
}