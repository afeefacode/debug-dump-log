<?php

use Wujunze\Colors;

// put in a useless default argument in order to allow the
// ide to cursor into the function brackets
function dump($arguments)
{
    if (php_sapi_name() === 'cli') {
        echo "\n";
    } else {
        echo '<pre>';
    }

    $args = func_get_args();

    $bt = debug_backtrace();
    $caller = array_shift($bt);
    $file = $caller['file'];

    $fileInfo = $file . ':' . $caller['line'] . '#' . $caller['function'];
    if (php_sapi_name() === 'cli') {
        $colors = new Colors();
        $fileInfo = $colors->getColoredString($fileInfo, 'light_gray');
    } else {
        $fileInfo = '<span style="color:#AAAAAA;">' . $fileInfo . '</span>';
    }
    echo $fileInfo . "\n";

    foreach ($args as $arg) {
        $dump = print_r($arg, true);
        $dump = preg_replace('/[ ]{4}/', '  ', $dump);
        $dump = preg_replace("/\n\s*\(/", '', $dump);
        $dump = preg_replace("/\)\n/", '', $dump);
        $dump = preg_replace('/ => Array/', ' => []', $dump);
        $dump = preg_replace("/.*\*RECURSION\*.*\n/", '', $dump);
        $dump = preg_replace("/^\s+$/m", '', $dump);
        $dump = preg_replace("/\n+/", "\n", $dump);
        $dump = preg_replace("/:.+:private\]/", '-]', $dump);
        $dump = preg_replace("/:protected\]/", '÷]', $dump);
        $dump = preg_replace("/(=> [^\s]+) Object/", '$1', $dump);

        echo $dump . ' ';
    }

    if (php_sapi_name() === 'cli') {
        echo "\n";
    } else {
        echo '</pre>';
    }
}
