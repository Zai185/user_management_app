<?php

class Router
{
    protected $routes;
    protected $data;

    public function __construct($routes, $data)
    {
        $this->routes = $routes;
        $this->data = $data;
    }
    public function direct()
    {
        $uri = parse_url(trim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($uri,  $this->routes[$method])) {
            extract($this->data[$uri] ?? []);
            require "view/" . $this->routes[$method][$uri] . ".php";
        } else {
            $uri = parse_url(trim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);
            dd(404, $uri,);
        }
    }
}
