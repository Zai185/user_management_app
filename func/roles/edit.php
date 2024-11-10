<?php
require '../../bootstrap.php';
require_permission($_SESSION['email'], 'roles', 'edit');
if (!isset($_POST['role']) || !isset($_POST['role_id'])) {
    session_flash('role', 'Role and role ID are required');
    redirect('features/roles/');
}
require_item('role_permission', "features/roles/edit.php?id=$role_id");
$role_name = htmlspecialchars($_POST['role']);
$role_id = $_POST['role_id'];
$role_permissions = $_POST['role_permission'];

try {
    $pdo->beginTransaction();

    $role_name = trim(strtolower($role_name));

    $sql_check = "SELECT * FROM roles WHERE name=:name";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(":name", $role_name);
    $stmt_check->execute();
    $role = $stmt_check->fetch(PDO::FETCH_ASSOC);
    if ($role && $role['id'] != $role_id) {
        session_flash("role_name", "Role name already exists!");
        redirect("features/roles/edit.php?id=$role_id");
    }

    $sql = "UPDATE roles SET name = :name WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $role_name);
    $stmt->bindParam(':id', $role_id);
    $stmt->execute();

    $sql_delete = "DELETE FROM role_permissions WHERE role_id = :role_id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(':role_id', $role_id);
    $stmt_delete->execute();

    foreach ($role_permissions as $permission) {
        $sql_rp = "INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)";
        $stmt_rp = $pdo->prepare($sql_rp);
        $stmt_rp->bindParam(':role_id', $role_id);
        $stmt_rp->bindParam(':permission_id', $permission);
        $stmt_rp->execute();
    }

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    session_flash('error', "Role can not be updated");
}
redirect('features/roles/');
