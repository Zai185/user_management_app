<?php

require '../../bootstrap.php';
require_permission($_SESSION['email'], 'users', 'create');
$fields_to_check = ['name', 'username', 'phone', 'address', 'email', 'password', 'gender', 'role_id'];

foreach ($fields_to_check as $f) {
    require_item($f, 'users.php');
}

$name = htmlspecialchars($_POST['name']);
$username = htmlspecialchars($_POST['username']);
$phone = htmlspecialchars($_POST['phone']);
$address = htmlspecialchars($_POST['address']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$gender = $_POST['gender'];
$role_id = $_POST['role_id'];
$is_active = $_POST['is_active'];

if (user_get('email', $email)) {
    session_flash('email', "Email already exists");
    redirect('users.php');
}

try {
    // SQL query to insert user data
    $sql = "INSERT INTO admin_users (name, username, phone, address, email, password, gender, role_id, is_active)
            VALUES (:name, :username, :phone, :address, :email, :password, :gender, :role_id, :is_active)";

    $stmt = $pdo->prepare($sql);
    $password = password_hash($password,PASSWORD_DEFAULT);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password',$password);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
    $stmt->bindParam(':is_active', $is_active, PDO::PARAM_BOOL);

    $stmt->execute();

    redirect('features/users/index.php');
} catch (PDOException $e) {
    session_flash('error', 'User Creation Failed');
}
redirect('features/users/index.php');
