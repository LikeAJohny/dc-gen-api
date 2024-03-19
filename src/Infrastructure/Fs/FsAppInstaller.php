<?php

declare(strict_types=1);

namespace Infrastructure\Fs;

use DcGen\Domain\Config\AppConfig;
use DcGen\Domain\Install\AppInstaller;

use function exec;
use function getcwd;

class FsAppInstaller implements AppInstaller
{
    public function install(AppConfig $config): string
    {
        $this->backend($config);

        return '';
    }

    private function backend(AppConfig $config): void
    {
        $outPath = getcwd() . '/data/' . $config->appName . '/backend';

        exec(
            'composer create-project --no-interaction mezzio/mezzio-skeleton ' . $outPath
        );
    }
}
