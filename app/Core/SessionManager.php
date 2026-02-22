<?php

class SessionManager
{
    private int $timeout;

    public function __construct(int $timeout = 900)
    {
        session_start();
        $this->timeout = $timeout;

        $this->checkInactivity();
    }

    // ------------------------
    // LOGIN
    // ------------------------
    public function login(int $userId): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
        $_SESSION['last_activity'] = time();
    }

    // ------------------------
    // LOGOUT
    // ------------------------
    public function logout(): void
    {
        session_unset();
        session_destroy();

        header("Location: /login");
        exit;
    }

    // ------------------------
    // COMPROBAR LOGIN
    // ------------------------
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            header("Location: /login");
            exit;
        }
    }

    // ------------------------
    // TIMEOUT POR INACTIVIDAD
    // ------------------------
    private function checkInactivity(): void
    {
        if (isset($_SESSION['last_activity'])) {

            if ((time() - $_SESSION['last_activity']) > $this->timeout) {
                $this->logout();
            }
        }

        $_SESSION['last_activity'] = time();
    }
}