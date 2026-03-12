<?php

namespace config\routes;

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\BDController;

/** @var \App\Core\Router $router */

$router->group(['middleware' => 'guest'], function($r) {;
    $r->get('/auth/register', [AuthController::class, 'register']);
    $r->get('/auth/login', [AuthController::class, 'login']);
});

$router->delete('/bd/schemaDelete', [BDController::class, 'schemaDelete']);

$router->get('/', [HomeController::class, 'index']);

$router->get('/docs', [HomeController::class, 'docs']);

$router->get('/bd/schemaBuilder', [BDController::class, 'schemaBuilder']);

$router->get('/bd/schemaCreate', [BDController::class, 'schemaCreate']);

$router->get('/bd/schemaView', [BDController::class, 'schemaView']);

$router->post('/bd/schemaBuilder', [BDController::class, 'schemaBuilderGenerate']);

$router->get('/bd/schemaCreate/success', [BDController::class, 'schemaCreateSuccess']);

$router->group(['middleware' => 'auth'], function($r) {
    $r->get('/dashboard', [HomeController::class, 'dashboard']);
});