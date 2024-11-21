<?php

return [
    'auth' => AuthMiddleware::class,
    'guest' => GuestMiddleware::class,
    'require_permission' => RequirePermission::class
];