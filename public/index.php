<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;

require __DIR__ . '/../includes/bootstrap.php';

$app = AppFactory::create(null, require ROOT_DIR . '/includes/service-manager.php');

require __DIR__ . '/../includes/routes.php';

$app->addRoutingMiddleware();
$app->addErrorMiddleware(false, true, true);

$app->run();
