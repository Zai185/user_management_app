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
            $slot = "view/" . $this->routes[$method][$uri] . ".php";
            require 'view/layouts/appLayout.php';
        } else {
            $uri = parse_url(trim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);
            dd(404, $uri);
        }
    }

    // private function paraRouteExists($uri)
    // {
    //     $method = $_SERVER['REQUEST_METHOD'];
    //     $routes = $this->routes[$method];
    //     foreach ($routes as $_uri => $route) {
    //         if (str_contains($_uri, "{")) {
                
    //             preg_match("/\{([^\/]+)\}/", $_uri, $model);
    //             $changed =  "/" . preg_replace("/\/\{[^\/]+\}\//", "\/([^\/]+)\/", $_uri) . "/";
    //             preg_match($changed, $uri, $id);

    //             return [
    //                 'model' => $model[1],
    //                 'id' => $id[1]
    //             ];
    //         }
    //     }
    //     return false;
    // }
}
