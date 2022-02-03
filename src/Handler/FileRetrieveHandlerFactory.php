<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Handler;

use BlackBonjour\ServiceManager\FactoryInterface;
use BPM\OwnCdn\Adapter\FileAdapter;
use BPM\OwnCdn\Configuration\SystemConfiguration;
use BPM\OwnCdn\Repository\FileRepository;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;

class FileRetrieveHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $service, array $options = []): FileRetrieveHandler
    {
        return new FileRetrieveHandler(
            $container->get(SystemConfiguration::class),
            $container->get(Client::class),
            $container->get(FileRepository::class),
            $container->get(FileAdapter::class),
        );
    }
}
