<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::controller(HomeController::class)->group(function(){
        Route::get("/",'index')->name("home");
        Route::post("/task/create","create");
        Route::put("/task/{id}/edit","edit");
        Route::patch("/task/{id}/status","update");
        Route::delete("/task/{id}/delete","destroy");
    });
});

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'index')->name('login')->middleware('guest');
    Route::post('/login', 'authenticate')->middleware('guest');
    Route::get('/logout','logout')->name("logout")->middleware(["auth","auth.session"]);
});


Route::controller(SignupController::class)->group(function(){
    Route::get('/signup', 'index')->name('signup')->middleware('guest');
    Route::post('/signup','store')->middleware('guest');
});

// Route::get('/test', function () {
//     return new \App\Mail\UserCreated($user = Auth::user());
// });
