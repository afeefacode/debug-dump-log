# afeefa/debug-dump-log

Dump one or more variables to the screen or into a log file.

## Description

This is a convenience wrapper around PHP's `print_r()` function with the ability to:

* inspect multiple variables at once
* dump the output right into a log file
* provide calling context
* show less verbose output
* format output depending on the output channel (html, cli, log)

The package provides two global functions `debug_dump()` and `debug_log()` that can be called from elsewhere within a PHP project without explicit import. Yet, a log file must be configured in order to use `debug_log()`.

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

## Documentation

https://afeefa-debug-dump-log.readthedocs.io/


### Why this library?

It is not always possible or appropriate to configure a huge debugging or logging framework overhead around a small or short time project. This library is made for the everyday life, just plug in and use, work on the project, not on the configuration.
