<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NisnController;
use App\Http\Controllers\Api\ParentController;
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
    Route::group(['prefix' => 'user', 'middleware' => 'jwt.verify'], function(){
        Route::get('/', [UserController::class, 'index'])->name('api-user');
        Route::get('/Authenticated', [UserController::class, 'getAuthenticated'])->name('api-users');
    });

    // STUDENTS
    Route::group(['prefix' => 'students', 'middleware' => 'jwt.verify'], function() {
        Route::get('/Authenticated', [NisnController::class, 'index'])->name('api-students');
        Route::post('/Authenticated/store', [NisnController::class, 'store'])->name('api-students-store');
    });

    // Parents
    Route::group(['prefix' => 'parents', 'middleware' => 'jwt.verify'], function(){
        Route::get('/Authenticated', [ParentController::class , 'index'])->name('api-parents');
        Route::post('/Authenticated/store', [ParentController::class , 'store'])->name('api-parents-store');
    });
});

