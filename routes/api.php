<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Blade\ApiUserController;
use App\Http\Controllers\Mobile\Auth\AuthController;
use App\Http\Controllers\Mobile\ConstantsController;
use App\Http\Controllers\Mobile\KeyController;
use App\Http\Controllers\Mobile\StoryCategoryController;
use App\Http\Controllers\Mobile\StoryItemController;
use App\Http\Controllers\Mobile\FileController;
use App\Http\Controllers\Mobile\EstateController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


# Public Routes
Route::post('/mobile/v1/user/sign/check-phone',[AuthController::class,'checkPhone']);
Route::post('/mobile/v1/user/sign/register',[AuthController::class,'register']);
Route::post('/mobile/v1/user/sign/login',[AuthController::class,'login']);
Route::post('/mobile/v1/user/sign/reset-password-request',[AuthController::class,'resetPasswordRequest']);
Route::post('/mobile/v1/user/sign/reset-password-confirm',[AuthController::class,'register']);
Route::post('/mobile/v1/params/list',[ConstantsController::class,'list']);

Route::post('/mobile/v1/keys/list',[KeyController::class,'list']);

#Stories
Route::post('/mobile/v1/story/category/list',[StoryCategoryController::class,'list']);
Route::post('/mobile/v1/story/item/list',[StoryItemController::class,'list']);
Route::post('/mobile/v1/story/item/view',[StoryItemController::class,'view']);

# File
Route::post('/mobile/v1/file/upload',[FileController::class,'upload']);


Route::group(['middleware' => 'api-auth'],function (){
    Route::post('/mobile/v1/user/sign/set-password',[AuthController::class,'setPassword']);
    Route::post('/mobile/v1/user/sign/logout',[AuthController::class,'logout']);
    Route::post('/mobile/v1/user/check',[ApiAuthController::class,'me']);


    # Estates
    Route::post('/mobile/v1/estate/create',[EstateController::class,'create']);



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
