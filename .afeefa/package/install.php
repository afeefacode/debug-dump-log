<?php

use Afeefa\Component\Package\Files\Files;
use Afeefa\Component\Package\Installer;
use Webmozart\PathUtil\Path;

$debugFolder = Path::join(getcwd(), '.afeefa', 'debug');

return (new Installer())
    ->files([
        Files::file()
            ->path(Path::join($debugFolder, 'debug.log')),

        Files::file()
            ->path(Path::join($debugFolder, '.gitignore'))
            ->content(<<<EOT
*
!.gitignore

EOT
            )
    ]);
