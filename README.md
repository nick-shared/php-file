# file
Shared File helper functions


#### Installation

1. `composer require mutant/file`

### Note: Until I make actual docs all the documentation is in docblocks. 



#### General Notes

1. File Modes
```
r	Read only mode, with the file pointer at the start of the file.
r+	Read/Write mode, with the file pointer at the start of the file.
w	Write only mode. Truncates the existing file by overwriting it. If file doesn’t exist the fopen() function creates a new file.
w+	Read/Write mode. Truncates the existing file by overwriting it. If file doesn’t exist the fopen() function creates a new file.
a	Append mode, with the file pointer at the end of the file. If the file doesn’t exist, the fopen() function creates a new file.
a+	Read/Append mode, with the file pointer at the end of the file. If the file doesn’t exist, the fopen() function creates a new file.
x	Create and open for writing only. If the file exists already, it returns FALSE and generates an error. If file doesn’t exist, a new file is created.
x+	Create and open for reading and writing. If the file exists already, it returns FALSE and generates an error. If file doesn’t exist, a new file is created.
```

2. Raw php file functions
 * fopen() is used to open a file if it exists or it creates a file if it doesn’t exist.
    * if the fopen() function fails to create a file or open a file, it returns 0 (zero).
 * fclose() used to close an open file
    * fclose() function returns true on success and false on failure