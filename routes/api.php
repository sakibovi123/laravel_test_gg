<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('signup', 'App\Http\Controllers\AuthController@signup');
    Route::put("edit-user/{id}/", 'App\Http\Controllers\AuthController@editUser');
    Route::delete('delete-user/{id}/', 'App\Http\Controllers\AuthController@delete');
    Route::post("add-permission", 'App\Http\Controllers\AuthController@addPermission');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        // Route::get('user', 'AuthController@user');
    });
    Route::get('/home', 'HomeController@index')->name('home');
});
