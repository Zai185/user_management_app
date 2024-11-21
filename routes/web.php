<?php


Route::get('/', PageController::class, 'welcome')->middleware('auth');

Route::get('/users', UserController::class, 'index')->middleware('auth');
Route::get('/users/create', UserController::class, 'create')->middleware('auth');
Route::post('/users/store', UserController::class, 'store')->middleware('auth');
Route::post('/users/update', UserController::class, 'update')->middleware('auth');
Route::get('/users/edit', UserController::class, 'edit')->middleware('auth');
Route::post('/users/delete', UserController::class, 'delete')->middleware('auth');



Route::get('/auth/login', AuthController::class, 'login_view')->middleware('guest');
Route::post('/auth/login', AuthController::class, 'login')->middleware('guest');
Route::post('/auth/logout', AuthController::class, 'logout')->middleware('auth');

Route::get('/roles', RoleController::class, 'index')->middleware('auth', 'require_permission:roles,view');
Route::get('/roles/create', RoleController::class, 'create')->middleware('auth', 'require_permission:roles,create');
Route::post('/roles/store', RoleController::class, 'store')->middleware('auth', 'require_permission:roles,create');
Route::get('/roles/edit', RoleController::class, 'edit')->middleware('auth', 'require_permission:roles,edit');
Route::post('/roles/update', RoleController::class, 'update')->middleware('auth', 'require_permission:roles,edit');
Route::post('/roles/delete', RoleController::class, 'delete')->middleware('auth', 'require_permission:roles,delete');
