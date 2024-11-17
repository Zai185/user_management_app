<?php

define('ROOT_DIR', __DIR__);
define('BASE_DIR', basename(__DIR__));
require 'Router.php';
require 'helper.php';
require 'DBConnection.php';
require 'QueryBuilder.php';
require 'Route.php';
require 'routes/web.php';

$query = new QueryBuilder(DBConnection::run(require 'config/database.php'));
$router = new Router(Route::$routes, Route::$data);
$router->direct();



session_start();
