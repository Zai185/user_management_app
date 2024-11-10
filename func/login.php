<?php
require '../bootstrap.php';

require_item('email', 'auth/login.php');
require_item('password', 'auth/login.php');

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$user = user_get('email', $email);
if ($user) {
    if (auth_login($email, $password)) {

        $_SESSION['email'] = $email;
        $_SESSION['uid'] = $user['id'];
        set_session_token($user['id'], session_id());
    }else{
        $hello = password_hash($password, PASSWORD_DEFAULT);
        session_flash('email', "The credential is incorrect");
    }
} else {
    session_flash('email', "The email doesn't exist");
}
redirect('auth/login.php');
