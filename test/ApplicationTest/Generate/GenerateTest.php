<?php

declare(strict_types=1);

namespace ApplicationTest\Generate;

use Application\Generate\GenerateCommand;
use Application\Generate\GenerateHandler;
use Domain\Compose\Compose;
use Domain\Service\Service\BackendService;
use Domain\Service\Service\DatabaseService;
use Domain\Service\Service\FrontendService;
use Infrastructure\Fs\FsAppInstaller;
use PHPUnit\Framework\TestCase;

class GenerateTest extends TestCase
{
    public function testGeneratesCorrectComposeSetup(): void
    {
        $command = new GenerateCommand(
            'test',
            'test',
            'postgres',
            'mezzio',
            'react',
        );
        $handler = new GenerateHandler(
            new DatabaseService(),
            new BackendService(),
            new FrontendService(),
            new FsAppInstaller()
        );

        $compose = $handler->exec($command);

        $this->assertInstanceOf(Compose::class, $compose);
    }
}
