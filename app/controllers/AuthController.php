<?php

class AuthController
{
    public function login_view()
    {
        return view('auth.login');
    }

    public function login()
    {
        $data = request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (!Auth::attempt($data['email'], $data['password'])) {
            Session::flash('error', "Invalid Credential");
            Session::flash('email', "Invalid Credential");
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
