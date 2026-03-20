<?php

use App\Core\Exceptions\ApiException;
use App\Core\Router;
use App\Core\Response;
use App\Core\Exceptions\HttpException;
use App\Core\Session;

require __DIR__ . '/../vendor/autoload.php';

$session = new Session();

$session->setCookieParams()->timeOut(1800)->start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$router = new Router();

$router->setPrefix('/api');

require __DIR__ . '/../config/routes/api.php';

$router->setPrefix('');

require __DIR__ . '/../config/routes/web.php';

var_dump($_SERVER['REQUEST_URI']);
die;

try {
    $router->dispatch();
} catch (ApiException $e) {
    $response = new Response(new \App\Core\Flash());
    $code = (int) $e->getStatusCode() ?: 500;
    $response->setStatusCode($code)
        ->json(['error' => $e->getMessage()], $code)
        ->send();
} catch (HttpException $e) {
    $response = new Response(new \App\Core\Flash());
    $code = $e->getStatusCode();
    $response->setStatusCode($code)
        ->view('errors/error', ['code' => $code, 'message' => $e->getMessage()])
        ->send();
} catch (\Throwable $e) {
    $response = new Response(new \App\Core\Flash());
    $code = (int) $e->getCode() ?: 500;
    $response->setStatusCode($code)
        ->view('errors/error', ['code' => $code, 'message' => $e->getMessage()])
        ->send();
}