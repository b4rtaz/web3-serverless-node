<?php

namespace App;

use App\Core\ConfigurationProvider;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class CorsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ConfigurationProvider $configurationProvider)
    {    
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

        $allowedOrigins = $this->configurationProvider->get('app', 'allowedOrigins');
        $referer = $_SERVER['HTTP_REFERER'];
        if (!empty($referer) && in_array($referer, $allowedOrigins))
        {
            $response = $response
                ->withHeader('Access-Control-Allow-Origin', $referer)
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                ->withHeader('Access-Control-Allow-Headers', $requestHeaders ?: '*');
        }

        return $response;
    }
}
