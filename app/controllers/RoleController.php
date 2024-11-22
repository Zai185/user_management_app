<?php

class RoleController
{
    public function index()
    {
        return view(
            'roles.index',
            [
                'roles' => Role::all()
            ]
        );
    }

    public function create()
    {

        $permissions = Permission::join('features', 'feature_id', 'id', 'inner')
            ->select('features.name as feature_name', 'permissions.id', 'permissions.name')
            ->get();

        $feature_permissions = [];
        foreach ($permissions as $p) {
            $feature_permissions[$p['feature_name']][] = $p;
        }
        return view(
            'roles.create',
            [
                'feature_permissions' => $feature_permissions
            ]
        );
    }

    public function store()
    {

        $data = request()->validate([
            'role' => 'required',
            'permissions' => 'required'
        ]);
        $role = Role::create([
            'name' => $data['role']
        ]);

        foreach ($data['permissions'] as $permission) {
            RolePermission::create([
                'role_id' => $role['id'],
                'permission_id' => $permission
            ]);
        }
        redirect('/roles');
    }

    public function edit()
    {

        $role_id = request()->data['id'];
        $role = Role::find($role_id);
        if(!$role){
          redirect('/roles');
          Session::flash('error', 'Role not found');
          return;
        }
        $role_permissions = RolePermission::where('role_id', $role_id)->get();
        $allowed_permissions = array_map(function ($r) {
            return $r['permission_id'];
        }, $role_permissions);
        $permissions = Permission::join('features', 'feature_id', 'id', 'inner')
            ->select('features.name as feature_name', 'permissions.id', 'permissions.name')
            ->get();

        $feature_permissions = [];
        foreach ($permissions as $p) {
            $feature_permissions[$p['feature_name']][] = $p;
        }
        return view(
            'roles.edit',
            [
                'role' => $role,
                'allowed_permissions' => $allowed_permissions,
                'feature_permissions' => $feature_permissions
            ]
        );
    }

    public function update()
    {

        $data = request()->validate([
            'role_id' => 'required',
            'role' => 'required',
            'permissions' => 'required'
        ]);
        $role_id = $data['role_id'];
        $role = Role::find($role_id);
        $role['name'] = $data['role'];
        Role::update($role);

        foreach ($data['permissions'] as $permission) {
            RolePermission::delete($role_id, 'role_id');
        }
        foreach ($data['permissions'] as $permission) {
            RolePermission::create([
                'role_id' => $role['id'],
                'permission_id' => $permission
            ]);
        }

        redirect("/roles");
    }

    public function delete()
    {
        $role_id = request()->data['id'];

        Role::delete($role_id);
        RolePermission::delete($role_id, 'role_id');

        redirect('/roles');
    }
}
