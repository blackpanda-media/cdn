<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Configuration;

use BlackBonjour\ServiceManager\FactoryInterface;
use DateInterval;
use Psr\Container\ContainerInterface;

class CacheConfigurationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $service, array $options = []): CacheConfiguration
    {
        $cacheConfig = $container->get('config')['cache'];

        return new CacheConfiguration($cacheConfig['enabled'], new DateInterval($cacheConfig['ttl']));
    }
}
