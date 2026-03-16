<?php

namespace config\routes;

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\BDController;

/** @var \App\Core\Router $router */

$router->group(['middleware' => 'guest'], function($r) {;
    $r->get('/auth/login', [AuthController::class, 'index']);
    $r->post('/auth/login', [AuthController::class, 'login']);
});

$router->get('/', [HomeController::class, 'index']);

$router->get('/docs', [HomeController::class, 'docs']);

$router->group(['middleware' => 'admin'], function($r) {
    $r->delete('/auth/logout', [AuthController::class, 'logout']);

    $r->get('/bd/schemaBuilder', [BDController::class, 'schemaBuilder']);

    $r->get('/bd/schemaCreate', [BDController::class, 'schemaCreate']);

    $r->get('/bd/schemaView', [BDController::class, 'schemaView']);

    $r->post('/bd/schemaBuilder', [BDController::class, 'schemaBuilderGenerate']);

    $r->get('/bd/schemaCreate/success', [BDController::class, 'schemaCreateSuccess']);

    $r->delete('/bd/schemaDelete', [BDController::class, 'schemaDelete']);
});