<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController
{
    public function get(Request $request, Response $response)
    {
        $response
            ->getBody()
            ->write('<code>Web3 Serverless Node</code>');
        return $response;
    }
}
