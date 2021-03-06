<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

#Routes
Route::group(['middleware' => ['auth']], function () {

    Route::get('/', function () {
        return view('home');
    });

    # Users
    Route::get('users', 'UserController@index')->name('users.index')->middleware('can:users.index');
    Route::get('users/create', 'UserController@create')->name('users.create')->middleware('can:users.create');
    Route::post('users/store', 'UserController@store')->name('users.store')->middleware('can:users.store');
    # Route::get('users/{user}', 'UserController@show')->name('users.show')->middleware('can:users.show');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit')->middleware('can:users.edit');
    Route::patch('users/{user}', 'UserController@update')->name('users.update')->middleware('can:users.update');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy')->middleware('can:users.destroy');

    # Update user password
    Route::patch('password/{user}', 'UpdatePasswordController@update')->name('password')->middleware('can:users.update');

    # Roles
    Route::get('roles', 'RoleController@index')->name('roles.index')->middleware('can:roles.index');
    Route::get('roles/create', 'RoleController@create')->name('roles.create')->middleware('can:roles.create');
    Route::post('roles/store', 'RoleController@store')->name('roles.store')->middleware('can:roles.store');
    # Route::get('roles/{role}', 'RoleController@show')->name('roles.show')->middleware('can:roles.show');
    Route::get('roles/{role}/edit', 'RoleController@edit')->name('roles.edit')->middleware('can:roles.edit');
    Route::patch('roles/{role}', 'RoleController@update')->name('roles.update')->middleware('can:roles.update');
    Route::delete('roles/{role}', 'RoleController@destroy')->name('roles.destroy')->middleware('can:roles.destroy');


    # Permissions
    Route::get('permissions', 'PermissionController@index')->name('permissions.index')->middleware('can:permissions.index');
    Route::get('permissions/create', 'PermissionController@create')->name('permissions.create')->middleware('can:permissions.create');
    Route::post('permissions/store', 'PermissionController@store')->name('permissions.store')->middleware('can:permissions.store');
    # Route::get('permissions/{permission}', 'PermissionController@show')->name('permissions.show')->middleware('can:permissions.show');
    Route::get('permissions/{permission}/edit', 'PermissionController@edit')->name('permissions.edit')->middleware('can:permissions.edit');
    Route::patch('permissions/{permission}', 'PermissionController@update')->name('permissions.update')->middleware('can:permissions.update');
    Route::delete('permissions/{permission}', 'PermissionController@destroy')->name('permissions.destroy')->middleware('can:permissions.destroy');

});
