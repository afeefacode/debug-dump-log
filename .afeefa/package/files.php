<?php

use Afeefa\Component\Package\Files\Files;
use Webmozart\PathUtil\Path;

$packageManagerRoot = Path::join(__DIR__, '..', '..');
$projectPackageFolder = Path::join(getcwd(), '.afeefa', 'debug');

return [
    Files::file()
        ->path(Path::join($projectPackageFolder, 'debug.log'))
];
