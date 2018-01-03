<?php
namespace Mutant\File\App\Helpers;

/**
 * Class File
 * @package Mutant\File\App\Helpers
 *
 * https://github.com/php/php-src/blob/master/ext/spl/internal/splfileobject.inc
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
            $current_location = $this->ftell();
            $this->goToEndOfFile();
        }
        $this->fwrite($this->newlinechar);
        $this->fwrite($text);
        $this->fseek($current_location);
    }

    /**
     * Appends to a file and leaves the cursor at the end of the file
     * @param string $text
     */
    public function appendAndStay(string $text)
    {
        if (!$this->eof()) {
            $this->goToEndOfFile();
        }
        $this->fwrite($this->newlinechar);
        $this->fwrite($text);
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
    public function getCurrentLineNumber()
    {
        return $this->key();
    }

    /**
     * Gets current line data and advances the cursor to next line
     * @return string
     */
    public function getCurrentLine(){
        return $this->fgets();
    }

    /**
     * Gets the character at the current cursor location
     * @return string
     */
    public function getCurrentCharacter()
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
    public function goToBeginningOfFile(){
        $this->rewind();
    }

    /**
     * Note: Theres some weirdness here.
     * fseek(0, SEEK_END) doesn't go to EOF like it theoretically seems like it should.
     * It goes to the second to last line.
     * There can be a line or two remaining for some reason I have yet to explore, so iterate through those.
     * http://php.net/manual/en/function.fseek.php
     */
    public function goToEndOfFile()
    {
        $this->fseek(0, SEEK_END);
        // Note: for some reason this doesnt go to the end of the file so have to finish the remaining line or two with loop

        while (!$this->eof()) {
            $this->fgets();
        }
    }
}