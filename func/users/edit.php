<?php

require '../../bootstrap.php';
require_permission($_SESSION['email'], 'users', 'edit');

$fields_to_check = ['name', 'username', 'phone', 'address', 'email', 'gender', 'role_id'];

foreach ($fields_to_check as $f) {
    require_item($f, 'users.php');
}
$id = htmlspecialchars($_POST['id']);
$name = htmlspecialchars($_POST['name']);
$username = htmlspecialchars($_POST['username']);
$phone = htmlspecialchars($_POST['phone']);
$address = htmlspecialchars($_POST['address']);
$email = htmlspecialchars($_POST['email']);
$gender = $_POST['gender'];
$role_id = $_POST['role_id'];
$is_active = $_POST['is_active'] == "on";
$user_exists = user_get('email', $email);
if ($user_exists && $user_exists['id'] != $id) {
    session_flash('email', value: "Email already exist");
    redirect("features/users/edit.php?id=$id");
}

$password_sql = '';
$password;
if (isset($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $password_sql = 'password=:password';
}

try {
    $sql = "UPDATE admin_users 
        SET 
            name = :name,
            username = :username,
            phone = :phone,
            address = :address,
            email = :email,
            gender = :gender,
            $password_sql,
            role_id = :role_id,
            is_active = :is_active
        WHERE 
            id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':role_id', $role_id);
    $stmt->bindParam(':is_active', $is_active);
    $stmt->bindParam(':id', $id);
    if ($password) {
        $stmt->bindParam(':password', $password);
    }

    $stmt->execute();
} catch (PDOException $e) {
    session_flash('error', "User Update Failed");
}
redirect('features/users/index.php');
