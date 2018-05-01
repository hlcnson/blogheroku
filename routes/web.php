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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Tạo một route group với prefix là manage.
// Bảo vệ các route trong group bằng middleware. Chỉ những user với các role được
// chỉ định mới có thể truy cập vào route trong group này. Middleware được sử dụng
// là của package Laratrust (được đăng ký trong kernel.php)
Route::prefix('manage')->middleware('role:superadministrator|administrator|editor|author|contributor')->group(function(){
    Route::get('/', 'ManageController@index');
    // Tạo route /manage/dashboard với tên là manage.dashboard, action tương
    // ứng là dashboard() thuộc về controller ManageController
    Route::get('/dashboard', 'ManageController@dashboard')->name('manage.dashboard');
    // Sử dụng tính năng Resource routing của Laravel, tự động gán các CRUD route cho các action của controller.
    // Route này là một tập hợp các route ứng với chức năng CRUD của controller.
    Route::resource('/users', 'UserController');
    // Tạo các route CRUD, ngoại trừ manage/permissions.destroy
    Route::resource('/permissions', 'PermissionController', ['except' => 'destroy']);
    // Tạo các route CRUD, ngoại trừ manage/roles.destroy
    Route::resource('/roles', 'RoleController', ['except' => 'destroy']);
    // Tạo các route CRUD
    Route::resource('/posts', 'PostController');
});

Route::get('/home', 'HomeController@index')->name('home');
