<?php
require 'vendor/autoload.php';
require 'helper.php';
require 'routes/web.php';

Session::start();
$router = new Router(Route::$routes, Route::$data);
$router->direct();
