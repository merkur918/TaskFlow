<?php

class AuthController extends Controller
{
    public function index(): void
    {
        $this->render('auth/login');
    }

}