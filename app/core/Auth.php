<?php

class Auth
{

    public static function check()
    {
        // check if user_id exist in session
        $s_user_id = Session::getProps('user_id');
        if ($s_user_id && isset($_COOKIE['php_hash_token'])) {

            $session = Session::where('user_id', $s_user_id)->first();
            if ($session && $session['id'] === $_COOKIE['php_hash_token']) {
                return true;
            }
        }
        return false;
    }

    public static function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (password_verify($password, $user['password'])) {
            Session::setProps('user_id', $user['id']);
            Session::setProps('email', $user['email']);
            $session = Session::find(Session::getId());
            return true;
        }

        return false;
    }

    public static function loginUsingId($user_id)
    {
        if (Session::find($user_id, 'user_id')) {
            Session::delete($user_id, 'user_id');
        }
        $user = User::find($user_id);
        Session::setProps('user_id', $user['id']);
        Session::setProps('email', $user['email']);
    }

    public static function user()
    {
        return Auth::check()
            ? User::find(Session::getProps('email'), 'email')
            : false;
    }
}
