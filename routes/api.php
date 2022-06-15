<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RealStateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

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

Route::prefix('v1')->group(function(){
    Route::name('real_states.')->group(function(){
        Route::resource('real-states', 'App\Http\Controllers\RealStateController');
    });

    Route::name('users.')->group(function(){
        Route::resource('users', 'App\Http\Controllers\UserController');
    });

    Route::name('categories.')->group(function(){
        Route::get('categories/{id}/real-states', [CategoryController::class, 'realState']);
        Route::resource('categories', 'App\Http\Controllers\CategoryController');
    });
});
