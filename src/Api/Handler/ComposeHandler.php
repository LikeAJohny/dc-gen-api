<?php

declare(strict_types=1);

namespace Api\Handler;

use DcGen\Application\GenerateComposeFile\GenerateComposeFileCommand;
use DcGen\Application\GenerateComposeFile\GenerateComposeFileHandler;
use DcGen\Domain\ComposeService\Service\BackendService;
use DcGen\Domain\ComposeService\Service\DatabaseService;
use DcGen\Domain\ComposeService\Service\FrontendService;
use Infrastructure\Fs\FsAppInstaller;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Yaml\Yaml;

use function fwrite;
use function json_decode;

class ComposeHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents(), false);
        $generate = new GenerateComposeFileCommand(
            $data->appName,
            $data->appPath,
            $data->database,
            $data->backend,
            $data->frontend
        );
        $handler = new GenerateComposeFileHandler(
            new DatabaseService(),
            new BackendService(),
            new FrontendService(),
            new FsAppInstaller(),
        );
        $compose = $handler->exec($generate);

        $composeYaml = Yaml::dump(
            $compose->toArray(),
            6,
            2,
            Yaml::DUMP_NULL_AS_TILDE,
        );
//        $composeYaml = str_replace('\'', '', $composeYaml);

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $composeYaml);

        return new Response($stream, 200, ['Content-Type' => 'text/yaml']);
    }
}
