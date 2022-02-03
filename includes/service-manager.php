<?php

declare(strict_types=1);

use BlackBonjour\ServiceManager\ServiceManager;

return new ServiceManager(
    require CONFIG_DIR . '/services.config.php',
    require CONFIG_DIR . '/factories.config.php',
    require CONFIG_DIR . '/abstract-factories.config.php',
);
