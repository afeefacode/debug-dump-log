<?php

use Afeefa\Component\Package\PackageManager;
use Afeefa\Component\Package\Package\Package;
use Webmozart\PathUtil\Path;

return (new PackageManager())
    ->packages([
        Package::composer()
            ->path(Path::join(__DIR__, '..', '..'))
    ]);
