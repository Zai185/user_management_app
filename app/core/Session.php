<?php

class Session extends Model
{

    static private $id;

    public static function getId()
    {
        return static::$id;
    }
    public static function setId($id)
    {
        static::$id = $id;
    }
    private static function resetId()
    {

        static::setId(session_id());
    }

    public static function start()
    {
        session_start();
        static::resetId();
    }

    public static function destroy()
    {
        unset($_SESSION);
        unset(static::$id);
        session_destroy();
    }

    public static function regenrate()
    {

        Session::delete(session_id());
        session_regenerate_id();
        static::resetId();
        $date = new DateTime();
        $date->modify('+3 days');
        $date = $date->format('Y-m-d H:i:s');
        Session::create([
            'id' => session_id(),
            'user_id' => Session::getProps('user_id'),
            'expired_at' => $date
        ]);
        setcookie('php_hash_token', static::$id, time() +60*60*24*7, "/");
    }

    public static function getProps($key)
    {
        return $_SESSION[$key] ?? null;
    }
    public static function setProps($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}
