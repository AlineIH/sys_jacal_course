<?php

use Database\Connection;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__.'/settings/database.php';
Connection::initCnn();

$container = new Container;

$settings = require __DIR__. '/settings/setting.php';
$settings($container);

AppFactory::setContainer($container);
$app = AppFactory::create();

$middleware = require __DIR__.'/settings/middleware.php';
$app->addErrorMiddleware(true,true,true);

$app->setBasePath("/services");

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Welcome to Jacal Course");
    return $response;
});

# Services

$app->get('/userRead', function (Request $request, Response $response, $args) {
    $request = Connection::query("SELECT * FROM SYS_USER ");

    $response->getBody()->write(json_encode($request));
    return $response;
});
# .Services
$app->run();

