<?php

declare(strict_types=1);

namespace Api;

use Api\Handler\ComposeHandler;
use Api\Handler\PingHandler;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'invokables' => [
                PingHandler::class => PingHandler::class,
                ComposeHandler::class => ComposeHandler::class,
            ],
            'factories'  => [],
        ];
    }
}
