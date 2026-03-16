<?php

namespace App\Middlewares;

use App\DAOs\DAOsImpl\UsersDAOImpl;
use App\Core\Exceptions\HttpException;
use App\Core\Session;

class AdminMiddleware
{
    private UsersDAOImpl $userDao;
    private Session $session;
    public function __construct(UsersDAOImpl $userDao, Session $session)
    {
        $this->userDao = $userDao;
        $this->session = $session;
    }

    public function handle(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $currentUser = $this->userDao->findById($this->session->get('currentUserId'));
         if (!$currentUser || $currentUser->getRole() !== 'admin') {
            $this->throw();
        }
    }
    private function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
    private function throw(): void
    {
        throw new HttpException("Página não encontrada!", 404);
    }
}