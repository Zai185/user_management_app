<?php

class RequirePermission extends Middleware
{

    public function run($feautre, $permission) {

        User::hasPermission($feautre, $permission);
    }
}
