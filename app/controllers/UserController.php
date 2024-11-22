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
        $data = request()->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'address' => 'required',
            'role_id' => 'required',
            'phone' => 'required',
            'gender' => 'required'
        ]);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['is_active'] ??= false;
        User::create($data);
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
        $data = request()->validate([
            'id' => 'required',
            'name' => 'required',
            'username' => 'required',
            'address' => 'required',
            'role_id' => 'required',
            'phone' => 'required',
            'gender' => 'required',
        ]);

        if (request()->data['password']) {
            $data['password'] = password_hash(request()->data['password'], PASSWORD_DEFAULT);
        }

        $data['is_active'] = isset($data['is_active']) ?? false;

        User::update($data);

        redirect("/users");
    }

    public function delete()
    {
        $user_id = request()->data['id'];

        User::delete($user_id);
        redirect('/users');
    }
}
