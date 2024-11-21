<?php

class AuthMiddleware
{

    public function run()
    {

        if (!Auth::check()) {
            header("location: /auth/login");
            exit;
        }
    }
}
