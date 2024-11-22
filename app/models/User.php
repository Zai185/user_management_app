<?php

class User extends Model
{


    protected $table = 'admin_users';

    public static function hasPermission($feature, $permission)
    {
        $user_role_id = Auth::user()['role_id'];
        $permission = Permission::join('features', 'feature_id', 'id')
            ->select('permissions.id')
            ->where('features.name', $feature)
            ->where('permissions.name', $permission)
            ->first();
        $allowed_permission = RolePermission::where('permission_id', $permission['id'])
            ->where('role_id', $user_role_id)
            ->first();
        return $allowed_permission;
    }
}
