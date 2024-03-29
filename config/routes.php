<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

return static function (
    Application $app,
    MiddlewareFactory $factory,
    ContainerInterface $container
): void {
    $app->get('/api/ping', Api\Handler\PingHandler::class, 'api.ping');
    $app->get('/api/compose', Api\Handler\ComposeHandler::class, 'api.compose');
};
