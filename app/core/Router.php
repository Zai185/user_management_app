<?php

use function PHPSTORM_META\type;

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
        $slot = null;
        $uri = parse_url(trim(request()->uri, '/'), PHP_URL_PATH);
        $method = request()->method;

        if (array_key_exists($uri,  $this->routes[$method])) {
            extract($this->routes[$method][$uri]);

            if (isset($middlewares)) $this->middlewareCheck($middlewares);

            $controller = new $controller();
            [$filename, $data] = $controller->$func();
            extract($data ?? []);
            $slot = view_path($filename);
        } else {
            $slot = view_path('status/404');
        }
        require view_path('layouts/appLayout');
    }

    public function middlewareCheck($middlewares)
    {
        switch (gettype($middlewares)) {
            case "string":
                $middlewares = new $middlewares();
                $middlewares->run();
                break;
            case "Array":
                foreach ($middlewares as $middleware) {
                    $middleware = new $middleware();
                    $middleware->run();
                }
                break;
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
