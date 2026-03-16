<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;

class AuthController
{
    public function index(Response $response, Flash $flash): void
    {
        $message = $flash->get('message');
        $response->view('auth/index', compact('message'))->send();
    }
    public function login(Request $request, Response $response, AuthService $authService): void
    {
        $data = $request->getBody();
        $authService->saveAdminUser();

        if ($authService->login($data['email'], $data['password'])) {
            $response->redirect('/bd/schemaBuilder');
        } else {
            $response->redirect('/auth/login', ['message' => 'Credenciais inválidas']);
        }
    }
    public function logout(Request $request, Response $response, AuthService $authService): void
    {
        $authService->logout();
        $response->redirect('/');
    }
}