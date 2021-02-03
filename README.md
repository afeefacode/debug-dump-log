# afeefa/debug-dump-log

Dump one or more variables to the screen or into a log file.

## Description

This is a convenience wrapper around PHP's `print_r()` function with the ability to:

* inspect multiple variables at once
* dump the output right into a log file
* provide calling context
* show less verbose output
* format output depending on the output channel (html, cli, log)

The package provides two global functions `debug_dump()` and `debug_log()` that can be called from elsewhere within a PHP project without explicit import. Yet, a log file must be [configured](#Configuration) in order to use `debug_log()`.

## Example

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

$string = 'This is a text string';

class Animal
{
    public $name = 'camel';
    protected $version = '2 humps';
    private $hidden = 'do not feed';
}

$object = (object) [
    'key' => 'value',
    'foos' => [
        'bar1',
        'bar2'
    ]
];

debug_dump($string, $object, new Animal());
// debug_log($string, $object, new Animal());
```

**HTML output** `debug_dump()` and `print_r()`

![output](https://raw.githubusercontent.com/afeefacode/debug-dump-log/main/docs/source/_static/html.gif "output")

**Log example**

![output](https://raw.githubusercontent.com/afeefacode/debug-dump-log/main/docs/source/_static/cli.gif "output")

## Installation

```bash
composer require afeefa/debug-dump-log
```

## Configuration

`debug_log()` needs to know a `debug.log` file location. The file must be already there and writable.

### Default file location

By default, the function looks for the log file at `[PROJECT_ROOT]/.afeefa/debug/debug.log`, where `PROJECT_ROOT` is either:

* Web app:

  The function assumes the web app is served from a `project/public` directory and sets `PROJECT_ROOT` to the parent of the document root:
  ```javascript
  $PROJECT_ROOT = $_SERVER['DOCUMENT_ROOT'] . "/..";
  ```

* Cli app:

  The function assumes you are running the cli right from the project root.
  ```javascript
  $PROJECT_ROOT = getcwd();
  ```

Create the `debug.log` file like this:

```bash
cd project
mkdir -p .afeefa/debug
touch .afeefa/debug/debug.log
```

**Log info helper**

You may check the location where `debug_log()` expects to find the log file by calling the `debug_log_info()` helper, also in this package.

```php
debug_log_info();

-->

Array
  [sapi] => cli
  [env] => []
      [AFEEFA_DEBUG_LOG_DIR] => not set
  [tested] => debug-dump-log/example/.afeefa/debug/debug.log
  [found] => 1
  [writable] => 1
  [file] => debug-dump-log/example/.afeefa/debug/debug.log

```

### Custom file location

You may specify a custom location by setting the `AFEEFA_DEBUG_LOG_DIR` env variable. An absolute path is encouraged, otherwise the path is considered to be relative to the document root (web app) respective to the current working directory (cli app).

* from PHP:
  ```php
  putenv('AFEEFA_DEBUG_LOG_DIR=/home/debug.log');
  ```

* from Cli:
  ```php
  touch debug.log
  export AFEEFA_DEBUG_LOG_DIR=. && php debug_log.php
  ```

* Setting the variable at server level is of course possible, too.
