<?php

namespace Afeefa\Component\Debug;

use Afeefa\Component\Package\Actions\Install as PackageInstall;
use Afeefa\Component\Package\Files\Files;
use Webmozart\PathUtil\Path;

class Install extends PackageInstall
{
    protected $configFolderName = 'debug';

    protected function install(): void
    {
        $this->createFiles([
            Files::file()
                ->path(Path::join($this->projectConfigPath, 'debug.log')),

            Files::file()
                ->path(Path::join($this->projectConfigPath, '.gitignore'))
                ->content(<<<EOT
*
!.gitignore

EOT
                )
        ]);
    }
}

return Install::class;
