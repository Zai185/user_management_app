<?php

class User extends Model
{


    protected $table = 'admin_users';

    public function hasPermission($feature, $permission) {
        $user_role_id = Auth::user();
        $permission = Permission::where('name', $permission)->get();

        dd($permission);

    }
}
