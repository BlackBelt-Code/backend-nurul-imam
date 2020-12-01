<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UiController;

Route::group(['prefix' => '/'], function(){
    Route::get('/', [UiController::class, 'index']);    
});