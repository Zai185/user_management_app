<?php

function users_all()
{
    $pdo = db();
    $sql = "SELECT * FROM admin_users WHERE NOT id =1 ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function user_get($column, $value)
{
    $pdo = db();
    $sql = "SELECT * FROM admin_users WHERE $column=:$column";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":$column", $value);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function user_features()
{
    $pdo = db();

    $sql = "SELECT features.name, GROUP_CONCAT(permissions.name) AS permissions
FROM admin_users
JOIN role_permissions ON  role_permissions.role_id = admin_users.role_id
JOIN permissions ON permissions.id =role_permissions.permission_id
JOIN features ON permissions.feature_id = features.id 
WHERE email=:email
GROUP BY features.name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $_SESSION['email']);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
