<?php

use App\Core\ConfigurationProvider;
use DI\Bridge\Slim\Bridge;

define('APP_PATH', __DIR__);

require APP_PATH . '/../vendor/autoload.php';

$app = Bridge::create();
$configurationProvider = $app->getContainer()->get(ConfigurationProvider::class);
$debug = $configurationProvider->get('app', 'debug');

$app->setBasePath($configurationProvider->get('app', 'basePath'));

require APP_PATH . '/routes.php';

$app->addErrorMiddleware($debug, false, false);
$app->run();
