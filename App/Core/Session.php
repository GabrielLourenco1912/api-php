<?php

namespace App\Core;
class Session {
    public function start()
    {
        session_start();
    }
    public function destroy()
    {
        session_destroy();
    }
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public function get($key)
    {
        return $_SESSION[$key];
    }
    public function timeOut(int $seconds): self
    {
        if (isset($_SESSION['last_activity']) &&
            time() - $_SESSION['last_activity'] > $seconds) {
            session_destroy();
        }
        $_SESSION['last_activity'] = time();
        return $this;
    }
    public function setCookieParams(): self
    {
        session_set_cookie_params([
            'httponly' => true,
            'secure' => $_ENV['SECURE_COOKIE'] ?? true,
            'samesite' => 'Lax'
        ]);
        return $this;
    }
}