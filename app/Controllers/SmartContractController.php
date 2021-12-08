<?php

namespace App\Controllers;

use App\Ethereum\SmartContractCachedCaller;
use App\Core\ConfigurationProvider;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SmartContractController
{
    public function __construct(
        private SmartContractCachedCaller $smartContractCaller,
        private ConfigurationProvider $configurationProvider)
    {
    }

    public function callMethod(Request $request, Response $response, string $contractName, string $methodName)
    {
        $rawParameters = $request->getQueryParams();

        $result = $this->smartContractCaller->callMethod($contractName, $methodName, $rawParameters);

        $response
            ->getBody()
            ->write(json_encode($result));

        $allowedOrigins = $this->configurationProvider->get('http', 'allowedOrigins');
        $httpOrigin = $_SERVER['HTTP_ORIGIN'];
        if (in_array($httpOrigin, $allowedOrigins))
        {
            $response = $response->withHeader('Access-Control-Allow-Origin', $httpOrigin);
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Pragma', 'no-cache')
            ->withHeader('Expires', '0')
            ->withHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
}
