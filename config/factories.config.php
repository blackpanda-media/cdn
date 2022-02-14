<?php

declare(strict_types=1);

return [
    BPM\OwnCdn\Adapter\FileAdapter::class => BPM\OwnCdn\Adapter\FileAdapterFactory::class,

    BPM\OwnCdn\Configuration\CacheConfiguration::class => BPM\OwnCdn\Configuration\CacheConfigurationFactory::class,
    BPM\OwnCdn\Configuration\SystemConfiguration::class => BPM\OwnCdn\Configuration\SystemConfigurationFactory::class,

    BPM\OwnCdn\Handler\FileRetrieveHandler::class => BPM\OwnCdn\Handler\FileRetrieveHandlerFactory::class,

    BPM\OwnCdn\Validator\RequestValidator::class => BPM\OwnCdn\Validator\RequestValidatorFactory::class,

    GuzzleHttp\Client::class => BPM\OwnCdn\Factory\GuzzleClientFactory::class,
];
