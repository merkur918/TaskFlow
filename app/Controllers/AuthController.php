<?php

class AuthController extends Controller
{
    private function renderLogin(array $data = []): void
    {
        $defaults = [
            'errores' => []
        ];

        $this->render('auth/login', array_merge($defaults, $data));
    }

    private function renderRegister(array $data = []): void
    {
        $defaults = [
            'errores' => []
        ];

        $this->render('auth/register', array_merge($defaults, $data));
    }

    public function index(): void
    {
        $this->renderLogin();
    }

    public function register(): void
    {
        $this->renderRegister();
    }

   public function authenticate(): void
{
    $errores = [];

    $username = recoge('username');
    $email    = recoge('email');
    $password = recoge('password');

    if ($username === '' || $email === '' || $password === '') {
        $errores['general'] = 'Todos los campos son obligatorios';
        $this->renderLogin(compact('errores'));
        return;
    }

    $userModel = new User();

    $user = $userModel->findByUsername($username);

    if (!$user || $user['email'] !== $email) {
        $errores['general'] = 'Credenciales incorrectas';
        $this->renderLogin(compact('errores'));
        return;
    }

    if (!password_verify($password, $user['password'])) {
        $errores['general'] = 'Credenciales incorrectas';
        $this->renderLogin(compact('errores'));
        return;
    }

    $this->session->login($user['id']);
   
}

    public function createUser(): void
    {
        $errores = [];

        $username = recoge('username');
        $email = recoge('email');
        $password = recoge('password');

        cTexto($username, 'username', $errores, 20, 3);
        cEmail($email, 'email', $errores);
        cPassword($password, 'password', $errores);

        $userModel = new User();

        if ($userModel->findByUsername($username)) {
            $errores['username'] = 'El usuario ya existe';
        }

        if ($userModel->findByEmail($email)) {
            $errores['email'] = 'El email ya está registrado';
        }

        if (!empty($errores)) {
            $this->renderRegister(compact('errores'));
            return;
        }

        $userModel->create($username, $email, $password);

        $this->redirect('/login');
    }

    public function logout(): void
    {
        $this->session->logout();
    }
}