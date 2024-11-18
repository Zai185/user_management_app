<?php


Route::get('/', PageController::class, 'welcome' );
Route::get('/users', UserController::class, 'index');
Route::get('/users/create', UserController::class, 'create');
Route::get('/users/edit', UserController::class, 'edit');
Route::post('/users', "users/store.php");
Route::post('/users/{user}/update', "users/update.php");
Route::get('/auth/login', AuthController::class, 'login_view');