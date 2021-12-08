<?php

use App\Core\ConfigurationProvider;
use App\CorsMiddleware;
use DI\Bridge\Slim\Bridge;

error_reporting(E_ERROR | E_PARSE);
define('APP_PATH', __DIR__);

require APP_PATH . '/../vendor/autoload.php';

$app = Bridge::create();
$configurationProvider = $app->getContainer()->get(ConfigurationProvider::class);
$debug = $configurationProvider->get('app', 'debug');

$app->setBasePath($configurationProvider->get('app', 'basePath'));

$app->add(CorsMiddleware::class);
$app->addRoutingMiddleware();

require APP_PATH . '/routes.php';

$app->addErrorMiddleware($debug, false, false);
$app->run();
