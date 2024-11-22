<?php
require "app/bootstrap.php";

Session::start();
Auth::checkToken();
$router = new Router(Route::$routes, Route::$data);
$router->direct();
Session::clearFlash();
Session::setProps('prev_url', $_SERVER['REQUEST_URI']);
