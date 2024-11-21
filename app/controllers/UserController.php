<?php


class UserController
{

    public function index()
    {
        $users = User::all();

        return view(
            'users.index',
            [

                'users' => $users
            ]
        );
    }

    public function create()
    {
        $roles = Role::all();
        return view(
            'users.create',
            [
                'roles' => $roles
            ]
        );
    }

    public function store()
    {
        $data = request()->data;
        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'address' => $data['address'],
            'role_id' => $data['role_id'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'is_active' => $data['is_active'] ?? false
        ]);
        redirect('/users');
    }

    public function edit()
    {

        $user_id = request()->data['id'];
        $user = User::find($user_id);
        $roles = Role::all();
        return view(
            'users.edit',

            [
                'user' => $user,
                'roles' => $roles
            ]
        );
    }

    public function update()
    {
        $data = request()->data;
        $user = User::find($data['id']);

        User::update([
            'id' => $data['id'],
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'address' => $data['address'],
            'role_id' => $data['role_id'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'is_active' => $data['is_active'] ?? false
        ]);

        redirect("/users");
    }

    public function delete()
    {
        $user_id = request()->data['id'];

        User::delete($user_id);
        redirect('/users');
    }
}
