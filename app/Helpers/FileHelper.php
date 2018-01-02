<?php
namespace Mutant\Http\App\Helpers;

class FileHelper
{
    /**
     * Creates a directory
     * Awesome discussion here on various ways to create a directory in php:
     * https://stackoverflow.com/questions/2303372/create-a-folder-if-it-doesnt-already-exist
     * (I didn't like the accepted answer because it doesnt allow creating a file and directory with the same name.
     *    as well as didn't allow setting permissions)
     * @param $path
     * @param int $mode
     * @return bool
     */
    function createDirectory($path, $mode = 0777)
    {
        return is_dir($path) || mkdir($path, $mode, true);
    }
}