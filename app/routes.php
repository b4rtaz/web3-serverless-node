<?php

use App\Controllers\HomeController;
use App\Controllers\SmartContractController;
use Slim\App;

/* @var $app App */
$app->get('', [HomeController::class, 'get']);
$app->get('contracts/{contractName}/{methodName}', [SmartContractController::class, 'callMethod']);

$app->options('{routes:.+}', function ($request, $response) {
    return $response; // CORS
});
