<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Configuration;

use BlackBonjour\ServiceManager\FactoryInterface;
use Psr\Container\ContainerInterface;

class SystemConfigurationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $service, array $options = []): SystemConfiguration
    {
        $baseConfig = $container->get('config');

        return new SystemConfiguration(
            $baseConfig['mode'],
            $container->get(CacheConfiguration::class),
            $baseConfig['whiteList'] ?? [],
            $baseConfig['blackList'] ?? [],
            $baseConfig['debug'],
        );
    }
}
