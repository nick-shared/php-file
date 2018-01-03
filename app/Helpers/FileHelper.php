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
        if (is_dir($path) && is_readable($path)) {
            return true;
        }

        return false;
    }


    public static function fileExists(string $path)
    {
        if (is_file($path) && is_readable($path)) {
            return true;
        }

        return false;
    }

    public static function lockFile($handle)
    {
        if (is_resource ($handle)) {
            return flock($handle, LOCK_EX);
        }
        return false;
    }

    public static function unlockFile($handle)
    {
        if (is_resource ($handle)) {
            return flock($handle, LOCK_UN);
        }
        return false;
    }

    public static function createFile(string $path, string $flags = "a+")
    {
        return fopen($path, $flags);
    }

    /**
     * Opens a file or creates a new file if the file doesnt exist.
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


    public static function openFile(string $path, string $flags = "a+")
    {
        if (self::fileExists($path)) {
            return fopen($path, $flags);
        }
        return false;
    }

    public static function closeFile($handle)
    {
        if (is_resource ($handle)) {
            return fclose($handle);
        }
        return false;
    }

    public static function writeToFile($handle, string $text)
    {
        if (is_resource ($handle)) {
            return fwrite($handle, $text);
        }
        return false;
    }

    public static function appendToFile($handle, string $text, string $newline_characters="\n")
    {
        if (is_resource ($handle)) {
            fwrite($handle, $newline_characters);
            return fwrite($handle, $text);
        }
        return false;
    }

    /**
     * Note: Theres a built in PHP way
     * $info = new finfo(FILEINFO_MIME_TYPE);
     * echo $info->file('myImage.jpg');
     * https://www.inanimatt.com/php-files.html
     *
     * However, it doesn't return null on failure it returns: inode/x-empty
     * Need to make sure this is the same return on every OS because windows doesnt use inodes.
     * Basically, this needs more testing
     *
     * @param string $filename
     * @return null|string
     */
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
        if (self::fileExists($path)) {
            return unlink($path);
        }
        return false;
    }
}