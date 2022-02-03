<?php

declare(strict_types=1);

use BPM\OwnCdn\Handler\FileRetrieveHandler;
use Slim\App;

/** @var App $app */

$app->get('/{hash}', FileRetrieveHandler::class);
