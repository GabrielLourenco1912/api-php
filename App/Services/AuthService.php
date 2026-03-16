<?php

namespace App\Services;

use App\Core\Exceptions\HttpException;
use App\Core\Session;
use App\DAOs\DAOsImpl\UsersDAOImpl;
use App\Models\Users;

class AuthService {
    private Session $session;
    private UsersDAOImpl $userAuth;
    public function __construct(Session $session, UsersDAOImpl $userAuth)
    {
        $this->session = $session;
        $this->userAuth = $userAuth;
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
    public function authUser (): Users
    {
        $currentUserId = $this->session->get('currentUserId');
        $currentUser = $this->userAuth->findById($currentUserId);
        if (is_null($currentUser)){
            throw new HttpException("Não há sessão logada!", 401);
        };
        return $currentUser;
    }
    public function saveAdminUser(): void
    {
        $adminEmail = $_ENV["ADMIN_EMAIL"];;
        if($this->userAuth->findByEmail($adminEmail)) return;

        $this->userAuth->save(new Users(null, "admin", $adminEmail, "admin", password_hash($_ENV["ADMIN_PASSWORD"], PASSWORD_DEFAULT)));
    }

}