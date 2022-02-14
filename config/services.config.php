<?php

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;

return [
    'config' => Yaml::parseFile(ROOT_DIR . '/config.yaml'),
];
