<?php

namespace App\Middlewares;

use App\Core\Exceptions\ApiException;
use App\Core\JWT;
use App\Core\Request;

class AuthMiddlewareJWT
{
    private Request $request;
    private JWT $jwt;

    public function __construct(Request $request, JWT $jwt)
    {
        $this->request = $request;
        $this->jwt = $jwt;
    }

    public function handle(): void
    {
        $token = $this->request->getBearerToken();
        if (!$token) {
            throw new ApiException('Unauthorized', 401);
        }
        try {
            $this->jwt->decode($token);
        } catch (\Exception $e) {
            throw new ApiException('Invalid token: ' . $e->getMessage(), 401);
        }
    }
}