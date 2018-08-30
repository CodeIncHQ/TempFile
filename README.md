# Temp file 

`TempFile` is a simple PHP class to manage temporary files. The temporary file is created using [`tempnam()`](http://php.net/manual/function.tempnam.php). It self-destructs when the class is destructed. By default the file is created in the system temp directory obtained using [`sys_get_temp_dir()`](http://php.net/manual/function.sys-get-temp-dir.php).


## Installation

This library is available through [Packagist](https://packagist.org/packages/codeinc/temp-file) and can be installed using [Composer](https://getcomposer.org/): 

```bash
composer require codeinc/temp-file
```

## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).