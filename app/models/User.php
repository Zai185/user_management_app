<?php

class User extends Model
{


    protected $table = 'admin_users';

    public static function hasPermission($feature, $permission)
    {
        $user_role_id = Auth::user();
        $permission = Permission::join('features', 'feature_id', 'id')
            ->select('features.name as feature_name', 'permissions.name as permission_name')
            ->where('features.name', $feature)
            ->where('permissions.name', $permission)
            ->get();
        return count($permission) > 0;
    }
}
