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
        $today = new DateTime(); // Current time
        $today = $today->format('Y-m-d H:i:s');
        if ($session = Session::find($prev_session_id)) {
            if (date($session['expired_at'])  < date($today)) {
                Session::delete($session['id']);
                Session::clearProps();
            } else {
                $user = User::find($session['user_id']);
                Session::setProps('user_id', $user['id']);
                Session::setProps('email', $user['email']);
            }
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
            $date = new DateTime();
            $date = $date->modify('+3 days')
                ->format('Y-m-d H:i:s');
            $session = Session::create([
                'id' => Session::getId(),
                'user_id' => $user['id'],
                'expired_at' => $date
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
        $date = new DateTime();
        $date = $date->modify('+3 days')
            ->format('Y-m-d H:i:s');
        Session::create([
            'id' => Session::getId(),
            'user_id' => $user['id'],
            'expired_at' => $date
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
