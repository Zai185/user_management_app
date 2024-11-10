<?php
require '../../bootstrap.php';
require_permission($_SESSION['email'], 'roles', 'create');

if (!isset($_POST['role'])) {
    session_flash('role', 'role is required');
    redirect('features/roles/');
}
require_item('role_permission', "features/roles/");

$role_name = htmlspecialchars($_POST['role']);
$role_permissions = $_POST['role_permission'];


try {

    $pdo->beginTransaction();
    $role_name = trim(strtolower($role_name));

    $sql_check = "SELECT * FROM roles WHERE name=:name";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(":name", $role_name);
    $stmt_check->execute();
    if ($stmt_check->fetch(PDO::FETCH_ASSOC)) {
        session_flash("role_name", "Role name already exists!");
        redirect('features/roles/create.php');
    }


    $sql = "INSERT INTO roles (name) VALUES (:name)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $role_name);
    $stmt->execute();
    $last_role_id = $pdo->lastInsertId();

    foreach ($role_permissions as $permission) {
        $sql_rp = "INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)";
        $stmt_rp = $pdo->prepare($sql_rp);
        $stmt_rp->bindParam(':role_id', $last_role_id);
        $stmt_rp->bindParam(':permission_id',  $permission);
        $status = $stmt_rp->execute();
    }
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    session_flash('error', "Creating Role Failed");
}
$pdo = null;
redirect('features/roles/');

