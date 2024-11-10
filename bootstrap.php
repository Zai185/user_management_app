<?php

define('ROOT_DIR',__DIR__);
define('BASE_DIR',basename(__DIR__));
require 'database.php';
require 'helper.php';
require 'func/roles/index.php';
require 'func/users/index.php';

session_start();