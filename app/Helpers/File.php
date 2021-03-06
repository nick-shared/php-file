<?php
namespace Mutant\File\App\Helpers;

use Mutant\String\App\Helpers\StringHelper as StrHelper;

/**
 * Class File
 * @package Mutant\File\App\Helpers
 *
 * http://php.net/manual/en/class.splfileobject.php
 * https://github.com/php/php-src/blob/master/ext/spl/internal/splfileobject.inc
 *
 *
 * Note: The usage of $this->fseek throws off the line counting/tracking so don't use it, use seek instead.
 */
class File extends \SplFileObject
{
    public $newlinechar = "\n";


    public function __construct($file_name, $open_mode = 'a+', $use_include_path = false, $context = NULL)
    {
        parent::__construct($file_name, $open_mode, $use_include_path, $context);
    }

    /**
     * Appends to a file and returns the cursor to its previous position
     * @param string $text
     */
    public function appendAndReturn(string $text)
    {
        if (!$this->eof()) {
            $current_location = $this->getLineNumber();
            $this->goToEndOfFile();
        }
        $this->fwrite($this->newlinechar);
        $this->fwrite($text);
        $this->goToLine($current_location);
    }

    /**
     * Appends to a file and adances the cursor the end of the file
     * @param string $text
     */
    public function appendAndAdvance(string $text)
    {
        if (!$this->eof()) {
            $this->goToEndOfFile();
        }
        $this->fwrite($this->newlinechar);
        $this->fwrite($text);
        $this->seek(PHP_INT_MAX); // fwrite writes but doesn't advance the read cursor so this moves the cursor up
    }


    /**
     * Go to a specific line number(zero based)
     * @param int $line_no
     * @return int
     */
    public function goToLine(int $line_no)
    {
        return $this->seek($line_no);
    }

    /**
     * Returns the line number of the current cursor location(zero based)
     * @return string
     */
    public function getLineNumber()
    {
        return $this->key();
    }

    /**
     * Reads current line data and advances the cursor to next line
     * @return string
     */
    public function getLineDataAndAdvance()
    {
        $line_data = $this->fgets();
        $line_data = StrHelper::removeAll($this->newlinechar, $line_data);
        return $line_data;
    }


    /**
     * Reads the current line data and doesn't advance the cursor
     */
    public function getLineDataAndStay()
    {
        $line_data = $this->current();
        $line_data = StrHelper::removeAll($this->newlinechar, $line_data);
        return $line_data;
    }

    /**
     * Gets the max number of lines in a file.
     * (Note: the file is zero based)
     * Note may be performance intensive as has to traverse file twice:
     *  once to the end and once back to current position.
     * http://php.net/manual/en/splfileobject.seek.php#121666
     * @return int
     */
    public function getTotalLineNumbers()
    {
        $currentline = $this->getLineNumber();
        $this->goToEndOfFile();
        $max = $this->key();
        $this->seek($currentline);
        return $max;
    }

    /**
     * Gets the character at the current cursor location
     * @return string
     */
    public function getCharacter()
    {
        return $this->fgetc();
    }

    /**
     * Returns the mime type of the file
     * @return null
     */
    public function getMimeType()
    {
        if (!$extension = $this->getExtension()) {
            return null;
        }
        $mimes = new MimeTypes;
        return $mimes->getMimeType($extension);
    }

    /**
     * Goes to the beginning of a file
     */
    public function goToBeginningOfFile()
    {
        $this->rewind();
    }

    /**
     * http://php.net/manual/en/function.fseek.php
     */
    public function goToEndOfFile()
    {
        $this->seek(PHP_INT_MAX);
    }
}