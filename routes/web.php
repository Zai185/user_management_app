<?php



Route::get('/', UserController::class, 'index');
// Route::get('/users', "users/index.php");
// Route::get('/users/{user}/edit', "users/edit.php");
Route::post('/users', "users/store.php");
Route::post('/users/{user}/update', "users/update.php");
