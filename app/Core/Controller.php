<?php

class Controller
{
    protected SessionManager $session;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    protected function render(string $view, array $data = []): void
    {
        extract($data);

        $session = $this->session;

        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        require __DIR__ . '/../views/layouts/main.php';
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}