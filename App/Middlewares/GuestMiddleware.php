<?php

namespace App\Middlewares;

use App\Core\Session;

class GuestMiddleware {
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function handle(): void
    {
        $currentUserId = $this->session->get('currentUserId');
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }

        if (isset($currentUserId))
        {
            $this->redirect('/');
        }
    }

    private function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}