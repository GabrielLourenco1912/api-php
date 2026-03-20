<?php

namespace App\Services;

use App\Core\Exceptions\HttpException;
use App\Core\JWT;
use App\Core\Request;
use App\Core\Session;
use App\DAOs\DAOsImpl\UsersDAOImpl;
use App\Models\Users;

class AuthService {
    private Session $session;
    private UsersDAOImpl $userAuth;
    private JWT $jwt;
    private Request $request;
    private ?Users $user = null;
    public function __construct(Request $request, Session $session, UsersDAOImpl $userAuth, JWT $jwt)
    {
        $this->session = $session;
        $this->userAuth = $userAuth;
        $this->jwt = $jwt;
        $this->request = $request;
    }
    public function login(string $email, string $senha): bool
    {
        $user = $this->userAuth->findByEmail($email);
        if (!$user) {
            return false;
        }
        if (!password_verify($senha, $user->getSenha())) {
            return false;
        }
        $this->session->set("currentUserId", $user->getId());
        return true;
    }
    public function logout(): void
    {
        $this->session->destroy();
    }
    public function isLogged(): bool
    {
        $logged = $this->session->get("currentUserId");
        return isset($logged);
    }
    public function authUser(): Users
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $currentUserId = $this->session->get('currentUserId');

        if (is_null($currentUserId)) {
            $token = $this->request->getBearerToken();

            if ($token !== null) {
                try {
                    $payload = $this->jwt->decode($token);
                    $currentUserId = $payload['uid'] ?? null;
                } catch (\Exception $e) {
                    throw new HttpException("Token inválido: " . $e->getMessage(), 401);
                }
            }
        }

        if (is_null($currentUserId)) {
            throw new HttpException("Não há sessão logada!", 401);
        }

        $user = $this->userAuth->findById($currentUserId);

        if (!$user) {
            throw new HttpException("Usuário não encontrado: ID $currentUserId", 401);
        }

        return $user;
    }
    public function saveAdminUser(): void
    {
        $adminEmail = $_ENV["ADMIN_EMAIL"];;
        if($this->userAuth->findByEmail($adminEmail)) return;

        $this->userAuth->save(new Users(null, "admin", $adminEmail, "admin", password_hash($_ENV["ADMIN_PASSWORD"], PASSWORD_DEFAULT)));
    }
    public function loginApi(string $email, string $senha): string
    {
        $user = $this->userAuth->findByEmail($email);
        if (!$user) {
            return false;
        }
        if (!password_verify($senha, $user->getSenha())) {
            return false;
        }

        $payload = [
            'iss' => 'lourencogabriel.dev',
            'aud' => 'lourencogabriel.dev',
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + (60 * 60),

            'uid'  => $user->getId(),
            'role' => $user->getRole()
        ];

        return $this->jwt->encode($payload);
    }
}