<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Configuration;

use BlackBonjour\ServiceManager\FactoryInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

class CacheConfigurationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $service, array $options = []): CacheConfiguration
    {
        $cacheConfig = Yaml::parse($container->get('config'))['cache'];

        return new CacheConfiguration($cacheConfig['enabled'], $cacheConfig['ttl']);
    }
}
