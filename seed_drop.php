<?php

require 'database.php';
$pdo = db();
$tables = ['sessions', 'role_permissions', 'permissions', 'features', 'roles', 'admin_users',];
foreach ($tables as $table) {
    $pdo->exec("DROP TABLE IF EXISTS $table");
}
