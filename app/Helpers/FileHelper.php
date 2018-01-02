<?php
namespace Mutant\File\App\Helpers;

use Mimey\MimeTypes;

class FileHelper
{
    /**
     * Creates a directory
     * Awesome discussion here on various ways to create a directory in php:
     * https://stackoverflow.com/questions/2303372/create-a-folder-if-it-doesnt-already-exist
     * (I didn't like the accepted answer because it doesnt allow creating a file and directory with the same name.
     *    as well as didn't allow setting permissions. I feel like this one is more elegant.)
     * @param $path
     * @param int $mode
     * @return bool
     */
    public static function createDirectory(string $path, string $mode = "0777")
    {
        return self::directoryExists($path) || mkdir($path, $mode, true);
    }

    public static function directoryExists(string $path)
    {
        return is_dir($path);
    }


    public static function fileExists(string $path)
    {
        if (file_exists($path)) {
            return true;
        }

        return false;
    }

    public static function createFile(string $path, string $perms = "w")
    {
        return fopen($path, $perms);
    }

    /**
     * Opens a file or creates a new file if the file doesnt exist.
     * (Note: I am aware that fopen does this same function but I feel like this DSL is more readable)
     * @param string $path
     * @return mixed
     */
    public static function createOrOpenFile(string $path)
    {
        if (!self::fileExists($path)) {
            return self::createFile($path);
        } else {
            return self::openFile($path);
        }
    }


    public static function openFile(string $path, string $perms = "w")
    {
        if (self::fileExists($path)) {
            return fopen($path, $perms);
        }
        return false;
    }

    public static function closeFile($handle)
    {
        return fclose($handle);
    }

    public static function writeFile($handle)
    {

    }

    public static function appendFile($handle)
    {

    }

    public static function getMimeType(string $filename)
    {
        $mimes = new MimeTypes;

        $extension = self::getExtension($filename);

        if (!$extension) {
            return null;
        }

        return $mimes->getMimeType($extension);
    }

    public static function getExtension(string $filename)
    {
        $temp = trim($filename, "."); //trim any dots from beginning or end
        $temp = explode(".", $temp);
        if (sizeof($temp) > 1) {
            return end($temp);
        }
        return null;
    }

    public static function deleteFile(string $path)
    {
        return unlink($path);
    }
}