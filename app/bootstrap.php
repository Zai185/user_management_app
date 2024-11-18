<?php


define('ROOT_DIR', __DIR__);
define('BASE_DIR', basename(__DIR__));
require 'helper.php';
require 'vendor/autoload.php';
require 'routes/web.php';


$router = new Router(Route::$routes, Route::$data);
$router->direct();
session_start();
