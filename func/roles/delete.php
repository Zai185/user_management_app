<?php
require '../../bootstrap.php';

require_permission($_SESSION['email'], 'users', 'delete', 'features/users/index.php');
require_item('id', 'features/users/index.php');
$role_id = $_POST['id'];
try {

    $sql_user = "UPDATE `admin_users` SET role_id=0
        WHERE role_id=:role_id";
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->bindParam(":role_id", $role_id);
    $stmt_user->execute();
    
    $sql_role_permission = "DELETE FROM role_permissions 
        WHERE role_id=:role_id";
    $stmt_role_permission = $pdo->prepare($sql_role_permission);
    $stmt_role_permission->bindParam(":role_id", $role_id);
    $stmt_role_permission->execute();
    
    $sql_role = "DELETE FROM roles WHERE id=:role_id";
    $stmt_role = $pdo->prepare($sql_role);
    $stmt_role->bindParam(":role_id", $role_id);
    $stmt_role->execute();


    session_flash('success', "Deleting User Failed");
} catch (Exception $e) {
    session_flash('error', "Deleting User Failed");
}
redirect('features/users/index.php');
