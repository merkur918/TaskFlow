<?php

class AuthController extends Controller
{
    public function renderLogin(): void
    {
        $this->render('auth/login');
    }
    public function renderRegister(): void
    {
        $this->render('auth/register');
    }
}