<?php

declare(strict_types=1);

define('ROOT_DIR', dirname(__DIR__));
const CONFIG_DIR = ROOT_DIR . '/config';
const LOG_DIR = ROOT_DIR . '/log';
const CACHE_DIR = ROOT_DIR . '/cache';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log', sprintf('%s/%s-error.log', LOG_DIR, date('Y-m-d')));

require ROOT_DIR . '/vendor/autoload.php';
