<?php

require 'app/bootstrap.php';
$pdo = DBConnection::run(config('database'));

$tables = ['sessions', 'role_permissions', 'permissions', 'features', 'roles', 'admin_users',];
foreach ($tables as $table) {
    $pdo->exec("DROP TABLE IF EXISTS $table");
}
echo "finish dropping all tables";
