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
        $result = $authService->login($data['email'] ?? null, $data['password'] ?? null);

        if (!$result) {
            $response->redirect('/auth/login', ['message' => 'Credenciais inválidas']);
            return;
        }

        $response->redirect('/');
    }
    public function logout(Request $request, Response $response, AuthService $authService): void
    {
        $authService->logout();
        $response->redirect('/');
    }

    public function loginApi(Request $request, Response $response, AuthService $authService): void
    {
        $authService->saveAdminUser();
        $data = $request->getBody();

        $token = $authService->loginApi($data['email'] ?? null, $data['password'] ?? null);

        if (!$token) {
            $response->json(['message' => 'Invalid credentials'], 401)->send();
            return;
        }

        $response->json([
            'message' => 'Login successful',
            'token' => $token
        ])->send();
    }

    public function authUser(Response $response, AuthService $authService): void
    {
        $user = $authService->authUser();

        $response->json([
            'user_id' => $user->getId()
        ])->send();
    }
}