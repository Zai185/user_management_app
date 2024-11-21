<?php

class Auth
{

    public static function check()
    {
        // check if user_id exist in session
        $s_user_id = Session::getProps('user_id');
        if ($s_user_id && isset($_COOKIE['php_hash_token'])) {
            $session = Session::where('user_id', $s_user_id)->first();
            return $session && $session['id'] === $_COOKIE['php_hash_token'];
        }
        return false;
    }

    public static function checkToken()
    {
        $prev_session_id = $_COOKIE['php_hash_token'];
        if ($session = Session::find($prev_session_id)) {
            $user = User::find($session['user_id']);
            Session::setProps('user_id', $user['id']);
            Session::setProps('email', $user['email']);
        }
    }

    public static function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user) return false;
        if (password_verify($password, $user['password'])) {
            Session::setProps('user_id', $user['id']);
            Session::setProps('email', $user['email']);
            Session::delete($user['id'], 'user_id');
            print_r(Session::getId());
            $session = Session::create([
                'id' => Session::getId(),
                'user_id' => $user['id']
            ]);

            setcookie('php_hash_token',  Session::getId(), time() + 60 * 60 * 24 * 7, "/");


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
        Session::create([
            'id' => Session::getId(),
            'user_id' => $user['id']
        ]);
        Session::setProps('user_id', $user['id']);
        Session::setProps('email', $user['email']);
    }

    public static function user()
    {
        return Auth::check()
            ? User::find(Session::getProps('email'), 'email')
            : false;
    }

    public static function logout()
    {
        $user = Auth::user();
        Session::delete($user['id'], 'user_id');
    }
}
