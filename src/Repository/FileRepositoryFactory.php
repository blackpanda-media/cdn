<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Repository;

use BlackBonjour\ServiceManager\FactoryInterface;
use BPM\OwnCdn\Adapter\SQLiteAdapter;
use BPM\OwnCdn\Configuration\SystemConfiguration;
use Psr\Container\ContainerInterface;

class FileRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $service, array $options = []): FileRepository
    {
        return new FileRepository($container->get(SQLiteAdapter::class), $container->get(SystemConfiguration::class));
    }
}
