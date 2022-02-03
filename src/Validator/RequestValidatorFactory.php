<?php

declare(strict_types=1);

namespace BPM\OwnCdn\Validator;

use BlackBonjour\ServiceManager\FactoryInterface;
use Psr\Container\ContainerInterface;

class RequestValidatorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $service, array $options = []): RequestValidator
    {
        return new RequestValidator();
    }
}
