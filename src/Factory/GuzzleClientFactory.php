<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Factory;

use BlackBonjour\ServiceManager\FactoryInterface;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;

class GuzzleClientFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $service, array $options = []): Client
    {
        return new Client();
    }
}
