<?php


class UserController
{

    public function index()
    {
        $query = new QueryBuilder(DBConnection::run(require 'config/database.php'));
        $users = $query->all('admin_users');

        return view(
            'users.index',
            [
                'users' => $users
            ]
        );
    }

    public function create()
    {
        return ['users/create.php'];
    }
}
