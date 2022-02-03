<?php

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;

return [
    'config' => Yaml::parse((ROOT_DIR . '/config.yaml')),
];
