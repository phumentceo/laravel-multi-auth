<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::prefix('backend')->group(function(){

    Route::group(['middleware' => 'guest'],function(){
        Route::get('/',[AuthController::class, 'showLogin'])->name('auth.login.show');
        Route::post('/login',[AuthController::class,'authenticate'])->name('auth.login.process');
        Route::get('/register',[AuthController::class,'showRegister'])->name('auth.register.show');
        Route::post('/register',[AuthController::class,'register'])->name('auth.register.process');
    });

    Route::group(['middleware' => 'auth'],function(){
        Route::get('/dashborad',[DashboardController::class,'index'])->name('dashboard.index');
        Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');
    });

    
});





