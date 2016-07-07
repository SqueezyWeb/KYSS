<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

/*
|-------------------------------------------------------------------------
|	Permission Routes
|-------------------------------------------------------------------------
*/
Route::get('permission/role/{role}/edit', 'PermissionController@editRole')->name('permission.roles.edit');
Route::post('permission/role/{role}', 'PermissionController@updateRole')->name('permission.roles.update');
Route::resource('permission', 'PermissionController');

/*
|-------------------------------------------------------------------------
|	Role Routes
|-------------------------------------------------------------------------
*/
Route::get('role/permissions/{role}/edit', 'RoleController@editRolePermissions')->name('role.permissions.edit');
Route::post('role/permissions/{role}', 'RoleController@updateRolePermissions')->name('role.permissions.update');
Route::get('role/users/{role}/edit', 'RoleController@editRoleUsers')->name('role.users.edit');
Route::post('role/users/{role}', 'RoleController@updateRoleUsers')->name('role.users.update');
Route::resource('role', 'RoleController');

/*
|-------------------------------------------------------------------------
|	User Routes
|-------------------------------------------------------------------------
*/
Route::get('user/{user}/roles/edit', 'UserController@editUserRoles')->name('user.roles.edit');
Route::post('user/{user}/roles', 'UserController@updateUserRoles')->name('user.roles.update');
Route::resource('user', 'UserController');
