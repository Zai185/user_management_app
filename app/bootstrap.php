<?php
require 'vendor/autoload.php';
require 'helper.php';
require 'routes/web.php';

Session::start();
Auth::checkToken();
print_r($_SESSION);
$router = new Router(Route::$routes, Route::$data);
$router->direct();
Session::clearFlash();
