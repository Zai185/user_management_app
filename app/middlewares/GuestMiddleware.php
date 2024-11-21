<?php

class GuestMiddleware
{

    public function run()
    {

        if (Auth::check()) {
            header("location: /");
            exit;
        }
    }
}
