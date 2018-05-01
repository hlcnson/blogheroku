<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Middleware tên auth có code tại /config/auth.php 
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Tạo một api route group cùng áp dụng middleware auth:api.
// Các route này đều có tiền tố là /api
Route::middleware('auth:api')->group(function() {
    // Tạo một route theo phương thức GET
    // Route này được xử lý bởi action tên apiCheckUnique của PostController. Có thể tách các api action
    // ra và tạo một controller, chẳng hạn PostAPIController, cho chúng tùy theo ý riêng.
    // Route được đặt tên là api.posts.unique
    Route::get('/posts/unique', 'PostController@apiCheckUnique')->name('api.posts.unique');
});

