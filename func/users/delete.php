<?php
require '../../bootstrap.php';

require_permission($_SESSION['email'], 'users', 'delete', 'features/users/index.php');
require_item('id', 'features/users/index.php');
$id = $_POST['id'];
try {

    $sql = "DELETE FROM `admin_users` WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    session_flash('success', "Deleting User Failed");
} catch (Exception $e) {
    session_flash('error', "Deleting User Failed");
}
redirect('features/users/index.php');
