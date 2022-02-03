<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Adapter;

use BlackBonjour\ServiceManager\FactoryInterface;
use Psr\Container\ContainerInterface;

class SQLiteAdapterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $service, array $options = []): SQLiteAdapter
    {
        return new SQLiteAdapter();
    }
}
