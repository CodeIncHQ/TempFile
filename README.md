# Temp file 

[`TempFile`](src/TempFile.php) is a simple PHP class to manage temporary files. The temporary file is created using [`tempnam()`](http://php.net/manual/function.tempnam.php). It self-destructs when the class is destructed. By default the file is created in the system temp directory obtained using [`sys_get_temp_dir()`](http://php.net/manual/function.sys-get-temp-dir.php).

## Usage

```php
<?php
use CodeInc\TempFile\TempFile;

// you can optionally specify a prefix and the parent directory to the constructor
$tempFile = new TempFile('my_temp_file_', '/tmp'); // creates the temp file
$tempFile->getPath(); // returns the temp file's path
(string)$tempFile; // equals to getPath(), returns the temp file's path
$tempFile->getSize(); // returns the temp file's size
$tempFile->getContents(); // returns the temp file's content
$tempFile->putContents(''); // set the temp file's content 
unset($tempFile); // deletes the temp file
```

You can also create a non self-destructive temp file:
```php
<?php
use CodeInc\TempFile\TempFile;

$tempFile = new TempFile(null, null, false);
$tempFilePath = $tempFile->getPath();
unset($tempFile); 

// will return TRUE, the temp file is NOT deleted by the class destructor
file_exists($tempFilePath); 
```


## Installation

This library is available through [Packagist](https://packagist.org/packages/codeinc/temp-file) and can be installed using [Composer](https://getcomposer.org/): 

```bash
composer require codeinc/temp-file
```

## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).