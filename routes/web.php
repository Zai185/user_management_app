<?php


Route::get('/', PageController::class, 'welcome')->middleware(AuthMiddleware::class);
Route::get('/users', UserController::class, 'index');
Route::get('/users/create', UserController::class, 'create');
Route::post('/users/store', UserController::class, 'store');
Route::post('/users/update', UserController::class, 'update');
Route::get('/users/edit', UserController::class, 'edit');
Route::post('/users/delete', UserController::class, 'delete');
// Route::post('/users', "users/store.php");
// Route::post('/users/{user}/update', "users/update.php");

Route::get('/auth/login', AuthController::class, 'login_view')->middleware(GuestMiddleware::class);
Route::post('/auth/login', AuthController::class, 'login')->middleware(GuestMiddleware::class);

Route::get('/roles', RoleController::class, 'index')->middleware([AuthMiddleware::class, RequirePermission::class]);
Route::get('/roles/create', RoleController::class, 'create');
Route::post('/roles/store', RoleController::class, 'store');
Route::get('/roles/edit', RoleController::class, 'edit');
Route::post('/roles/update', RoleController::class, 'update');
Route::post('/roles/delete', RoleController::class, 'delete');
