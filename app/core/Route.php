<?php

class Route
{
    public static $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static $data = [
        'GET' => [],
        'POST' => []
    ];
    public $uri;
    public $r_method;
    public function __construct($uri, $r_method){
        $this->uri = $uri;
        $this->r_method = $r_method;
    }   

    static function get($uri, $controller, $method)
    {

        $uri = trim($uri, '/');
        self::$routes['GET'][$uri]['controller'] =  $controller;
        self::$routes['GET'][$uri]['func'] =  $method;
        return new static($uri, 'GET');
    }


    static function post($uri, $controller, $method)
    {
        $uri = trim($uri, '/');
        self::$routes['POST'][$uri]['controller'] =  $controller;
        self::$routes['POST'][$uri]['func'] =  $method;
        return new static($uri, 'POST');
    }

    function middleware($middleware) {
        
        
        // self::$routes[$this->r_method][$this->uri]['middlewares'] = ['name' => $middleware, 'data' => $data];
    }
}
