<?php
function redirect(string $path)
{
    header("Location: /" . BASE_DIR . '/' . $path);
    exit;
}

function require_login()
{
    if (!isset($_SESSION['email']) && !isset($_SESSION['uid'])) {
        if (!verify_session_token($_SESSION['uid'])) {
            redirect(path: 'auth/login.php');
        }
    }
}

function must_be_guest()
{

    if (isset($_SESSION['email']) && isset($_SESSION['uid'])) {
        if (verify_session_token($_SESSION['uid'])) {
            redirect('index.php');
        }
    }
}

function auth_login($email, $password)
{
    $pdo = db();

    $sql = "SELECT * FROM admin_users WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user && password_verify($password, $user['password'])
        ? true
        : false;
}

function require_permission($email, $feature, $permission, $redirect_url = null)
{
    $pdo = db();
    $sql = "SELECT * FROM admin_users 
    JOIN role_permissions ON role_permissions.role_id = admin_users.role_id
    JOIN permissions ON permissions.id = role_permissions.permission_id
    JOIN features ON permissions.feature_id = features.id
    WHERE email=:email AND permissions.name=:permission AND features.name=:feature
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':feature', $feature);
    $stmt->bindParam(':permission', $permission);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result && $redirect_url) {
        redirect($redirect_url);
    }
    return $result;
}

function set_session_token($uid, $session_id)
{
    $pdo = db();
    $sql = "INSERT INTO `sessions`( `user_id`, `access_token`) VALUES (:user_id, :access_token)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $uid);
    $stmt->bindParam(':access_token', $session_id);
    $stmt->execute();
}

function verify_session_token($uid): bool
{
    $pdo = db();
    $sql = "SELECT access_token FROM `sessions` WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $uid);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) != null;
}

function delete_session_token($uid)
{
    $pdo = db();
    $sql = 'DELETE FROM `sessions` WHERE user_id=:user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $uid);
    $stmt->execute();
}

function require_item(string $key, string $redirect_url = null, string $message = null,)
{
    if (!isset($_POST[$key])) {
        if (!$message) {
            $message = ucfirst(str_replace('_', ' ', subject: $key)) . " is required";
        }
        session_flash($key, $message);
        if ($redirect_url) {
            redirect($redirect_url);
        }
    }
}

function session_flash(string $key, string $value)
{
    $_SESSION['FLASH'][$key] = $value;
}

function session_flash_remove()
{
    unset($_SESSION['FLASH']);
}
