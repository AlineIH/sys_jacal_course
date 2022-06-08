<?php

namespace Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Database\Connection;

class ValidateAccess
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();

        $path = $request->getUri()->getPath();

        Connection::initCnn();

//        if ($path == '/services/' || $path == '/services/login') {
            $content = (string)$handler->handle($request)->getBody();
            $response->getBody()->write($content);
//        } else {
//            $token = isset($_COOKIE['token']) ? $_COOKIE['token'] : '';

//            if (ValidateToken::verifyAuthentication($token)) {
//                $content = (string)$handler->handle($request)->getBody();
//                $response->getBody()->write($content);
//            } else {
//                $response->getBody()->write(json_encode([
//                    'status' => '300',
//                    'message' => 'Access denied'
//                ]));
//            }
//        }

        Connection::closeCnn();

        return $response;
    }
}