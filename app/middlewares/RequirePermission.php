<?php

class RequirePermission
{

    public function run($feature, $permission)
    {
        if (!User::hasPermission($feature, $permission)) {
            Session::getProps('prev_url')
                ? back()
                : redirect('/');
        }
    }
}
