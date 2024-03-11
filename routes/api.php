<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;

Route::post('login',[UserController::class, 'loginUser']);
Route::post('verify_otp',[UserController::class, 'VerifyOtp']);

Route::middleware('auth:sanctum')->group(function(){

    Route::get('my_profile',[UserController::class, 'myprofile']);
    Route::get('my_family',[UserController::class, 'myfamily']);
    Route::get('logout',[UserController::class, 'logoutuser']);

});

