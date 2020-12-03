<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NisnController;
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

Route::group(['namespace' => 'Api' ,'prefix' => 'V1'], function () {
    // LOGIN
    Route::group(['prefix' => 'login'], function() {
        Route::post('/', [UserController::class, 'login'])->name('api-login');
    });
    // Reguster User
    Route::group(['prefix' => 'register'], function(){
        Route::post('/', [UserController::class , 'register'])->name('api-register');
    });
    // User
    Route::group(['prefix' => 'user'], function(){
        Route::get('/', [UserController::class, 'index'])->name('api-user')->middleware('jwt.verify');
        Route::get('/Authenticated', [UserController::class, 'getAuthenticated'])->middleware('jwt.verify');
    });

    // STUDENTS
    Route::group(['prefix' => 'students'], function() {
        Route::get('/Authenticated', [NisnController::class, 'index'])->name('api-students')->middleware('jwt.verify');
        Route::post('/Authenticated/store', [NisnController::class, 'store'])->name('api-store')->middleware('jwt.verify');
    });
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
