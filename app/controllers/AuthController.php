<?php

class AuthController
{
    public function login_view()
    {
        return view('auth.login');
    }

    public function login()
    {
        $data = request()->data;
        if (!Auth::attempt($data['email'], $data['password'])) {
            dd("Not here");
        };

        Session::regenrate();

        redirect('/');
    }
}
