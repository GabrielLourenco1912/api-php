<?php

namespace config\routes;

use App\Controllers\AuthController;

/** @var \App\Core\Router $router */

$router->post('/auth/login', [AuthController::class, 'loginApi']);

$router->group(['middleware' => 'auth:api'], function($r) {
    $r->get('/auth/user', [AuthController::class, 'authUser']);
});