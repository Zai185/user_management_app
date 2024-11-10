<?php
require 'database.php';

function have_records($table)
{
    $pdo = db();
    $sql_users = "SELECT * FROM $table";
    $stmt_users = $pdo->prepare($sql_users);
    $stmt_users->execute();
    return $stmt_users->fetchAll(PDO::FETCH_ASSOC);
}

try {

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `admin_users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `username` varchar(255) NOT NULL,
            `role_id` int(11) NOT NULL,
            `phone` varchar(32) NOT NULL,
            `email` varchar(128) NOT NULL,
            `address` text NOT NULL,
            `password` varchar(128) NOT NULL,
            `gender` tinyint(1) NOT NULL,
            `is_active` tinyint(1) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `features` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `permissions` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            `feature_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `roles` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `role_permissions` (
            `role_id` int(11) NOT NULL,
            `permission_id` int(11) NOT NULL,
            PRIMARY KEY (`role_id`, `permission_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `sessions` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `access_token` varchar(128) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    
    if (!have_records('admin_users')) {
        $password = password_hash('admin',PASSWORD_DEFAULT);
        $sql = "
INSERT INTO `admin_users` (`id`, `name`, `username`, `role_id`, `phone`, `email`, `address`, password, `gender`, `is_active`) 
VALUES 
    (1, 'admin', '@admin', 1, '+1234890', 'admin@gmail.com', 'Nant Thar Myaing St', '$password', 0, 1)";

        try {
            $pdo->exec($sql);
            echo "Seeding `admin_users` table completed successfully.<br>";
        } catch (PDOException $e) {
            echo "Error seeding `admin_users` table: " . $e->getMessage() . "<br>";
            exit;
        }
    }
    if (!have_records('features')) {
        $features = [
            ['id' => 1, 'name' => 'roles'],
            ['id' => 2, 'name' => 'products'],
            ['id' => 3, 'name' => 'users']
        ];

        foreach ($features as $feature) {
            try {

                $pdo->prepare("INSERT INTO `features` (`id`, `name`) VALUES (:id, :name)")
                    ->execute(['id' => $feature['id'], 'name' => $feature['name']]);
            } catch (PDOException $e) {
                echo "Error seeding `features` table: " . $e->getMessage() . "<br>";
                exit;
            }
        }
        echo "Seeding `features` table completed successfully.<br>";
    }

    if (!have_records('permissions')) {

        $permissions = [
            [9, 'create', 1],
            [10, 'view', 1],
            [11, 'edit', 1],
            [12, 'delete', 1],
            [13, 'create', 2],
            [14, 'view', 2],
            [15, 'edit', 2],
            [16, 'delete', 2],
            [17, 'create', 3],
            [18, 'view', 3],
            [19, 'edit', 3],
            [20, 'delete', 3]
        ];
        foreach ($permissions as $perm) {
            try {

                $pdo->prepare("INSERT INTO `permissions` (`id`, `name`, `feature_id`) VALUES (:id, :name, :feature_id)")
                    ->execute(['id' => $perm[0], 'name' => $perm[1], 'feature_id' => $perm[2]]);
            } catch (PDOException $e) {
                echo "Error seeding `permissions` table: " . $e->getMessage() . "<br>";
                exit;
            }
        }
        echo "Seeding `permissions` table completed successfully.<br>";
    }

    if (!have_records('roles')) {

        $roles = [
            'no permission',
            'admin'
        ];
        foreach ($roles as $role) {
            try {
                $pdo->prepare("INSERT INTO `roles` ( `name`) VALUES (:name)")
                    ->execute(['name' => $role]);
            } catch (PDOException $e) {
                echo "Error seeding `roles` table: " . $e->getMessage() . "<br>";
                exit;
            }
        }
        echo "Seeding `roles` table completed successfully.<br>";
    }

    if (!have_records('role_permissions')) {

        $rolePermissions = [
            [1, 9],
            [1, 10],
            [1, 11],
            [1, 12],
            [1, 13],
            [1, 14],
            [1, 15],
            [1, 16],
            [1, 17],
            [1, 18],
            [1, 19],
            [1, 20]
        ];
        foreach ($rolePermissions as $rp) {
            try {

                $pdo->prepare("INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES (:role_id, :permission_id)")
                    ->execute(['role_id' => $rp[0], 'permission_id' => $rp[1]]);
            } catch (PDOException $e) {
                echo "Error seeding `role_permissions` table: " . $e->getMessage() . "<br>";
                exit;
            }
        }
        echo "Seeding `role_permissions` table completed successfully.<br>";
    }


    echo "Database seeding complete.<br>";
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
