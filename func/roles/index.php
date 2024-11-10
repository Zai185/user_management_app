<?php

function features_permissions()
{
    $pdo = db();
    $sql = "SELECT features.name AS feature_name, permissions.id, permissions.name
FROM permissions permissions
INNER JOIN features ON permissions.feature_id = features.id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function roles_all()
{
    $pdo = db();

    $sql = "SELECT * FROM roles
    WHERE id > 2";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function role_permissions_get($role_id)
{
    $pdo = db();

    $sql = "SELECT roles.name, GROUP_CONCAT(permission_id) AS permissions FROM roles 
    JOIN role_permissions ON roles.id = role_permissions.role_id
    WHERE roles.id=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id",  $role_id);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$result[0]['name']) return false;
    $result[0]['permissions'] = explode(',', $result[0]['permissions']);
    return $result[0];
}
