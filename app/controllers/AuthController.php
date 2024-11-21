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
        require_data('email');
        require_data('password');

        if (!Auth::attempt($data['email'], $data['password'])) {
            redirect('/auth/login');
        };

        redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        Session::destroy();
        redirect('/auth/login');
    }
}
