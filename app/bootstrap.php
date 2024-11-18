<?php

use App\Controllers\UserController;

define('ROOT_DIR', __DIR__);
define('BASE_DIR', basename(__DIR__));
require 'Router.php';
require 'helper.php';
require 'DBConnection.php';
require 'QueryBuilder.php';
require 'Route.php';
require 'models/Model.php';
require 'models/User.php';

User::all('admin_users');


$query = new QueryBuilder(DBConnection::run(require 'config/database.php'));
require 'controllers/UserController.php';
require 'routes/web.php';

$router = new Router(Route::$routes, Route::$data);





$router->direct();
session_start();
