<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Blade\ApiUserController;
use App\Http\Controllers\Mobile\Auth\LoginController;
use App\Http\Controllers\Mobile\ConstantsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


# Public Routes
Route::post('/mobile/v1/user/sign/check-phone',[LoginController::class,'checkPhone']);
Route::post('/mobile/v1/user/sign/register',[LoginController::class,'register']);
Route::post('/mobile/v1/user/sign/login',[LoginController::class,'login']);
Route::post('/mobile/v1/user/sign/reset-password-request',[LoginController::class,'resetPasswordRequest']);
Route::post('/mobile/v1/user/sign/reset-password-confirm',[LoginController::class,'register']);
Route::post('/mobile/v1/params/list',[ConstantsController::class,'list']);


Route::group(['middleware' => 'api-auth'],function (){
    Route::post('/mobile/v1/user/sign/set-password',[LoginController::class,'setPassword']);
    Route::post('/mobile/v1/user/sign/logout',[LoginController::class,'logout']);
    Route::post('/mobile/v1/user/check',[ApiAuthController::class,'me']);

//    Route::post('/tokens',[ApiAuthController::class,'getAllTokens']);
//    Route::post('/logout',[ApiAuthController::class,'logout']);
});

Route::group(['middleware' => 'ajax.check'],function (){
    Route::post('/api-user/toggle-status/{user_id}',[ApiUserController::class,'toggleUserActivation']);
    Route::post('/api-token/toggle-status/{token_id}',[ApiUserController::class,'toggleTokenActivation']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
