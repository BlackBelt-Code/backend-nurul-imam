<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NisnController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\StudentController;
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
        
        Route::get('/{id}', [UserController::class,'show'])->name('api-user-show');
        
        Route::get('/Authenticated', [UserController::class, 'getAuthenticated'])->name('api-users');
    });

    // STUDENTS ALL
    Route::group(['prefix' => 'students'], function() {
       
        // STUDENT
        Route::get('/Authenticated', [StudentController::class, 'index'])->name('api-students');
        Route::post('/Authenticated/store', [StudentController::class, 'StudentStore'])->name('api-students-store');
        
            // NISN
            Route::group(['prefix' => 'nisn'], function() {
                Route::get('/Authenticated', [NisnController::class, 'index'])->name('api-students-nisn');
                Route::post('/Authenticated/store', [NisnController::class, 'store'])->name('api-students-nisn-store');
            });

            // Parents
            Route::group(['prefix' => 'parents', 'middleware' => 'jwt.verify'], function(){
                Route::get('/Authenticated', [ParentController::class , 'index'])->name('api-students-parents');
                Route::post('/Authenticated/store', [ParentController::class , 'store'])->name('api-students-parents-store');
            });

    });
    
});

