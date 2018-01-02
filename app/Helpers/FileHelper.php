<?php
namespace Mutant\Http\App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Mutant\String\App\Helpers\StringHelper;

class FileHelper
{
    /**
     * Creates a directory
     * Awesome discussion here on various ways to create a directory in php:
     * https://stackoverflow.com/questions/2303372/create-a-folder-if-it-doesnt-already-exist
     * @param $path
     * @param int $mode
     * @return bool
     */
    function makedirs($path, $mode = 0777)
    {
        return is_dir($path) || mkdir($path, $mode, true);
    }
}