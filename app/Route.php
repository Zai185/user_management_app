<?php

class Route
{
    public static $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static $data = [];


    static function get($uri, $filename, $data = [])
    {
        $uri = trim($uri, '/');
        self::$routes['GET'][$uri] =  $filename;
        self::$data[$uri] = $data;
    }

    static function post($uri, $filename)
    {
        $uri = trim($uri, '/');
        self::$routes['POST'][$uri] =  $filename;
    }
}
