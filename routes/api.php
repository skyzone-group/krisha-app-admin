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
use App\Http\Controllers\Mobile\NotificationController;
use App\Http\Controllers\Mobile\FavoriteController;
use App\Http\Controllers\Mobile\SpecialTagController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/



# Localization route groups
Route::middleware("localization")->group(function () {

    # Public Routes
    Route::post('/mobile/v1/user/sign/check-phone',[AuthController::class,'checkPhone']);
    Route::post('/mobile/v1/user/sign/register',[AuthController::class,'register']);
    Route::post('/mobile/v1/user/sign/login',[AuthController::class,'login']);
    Route::post('/mobile/v1/user/sign/reset-password-request',[AuthController::class,'resetPasswordRequest']);
    Route::post('/mobile/v1/user/sign/reset-password-confirm',[AuthController::class,'register']);
    Route::post('/mobile/v1/params/list',[ConstantsController::class,'list']);
    Route::post('/mobile/v1/region/search',[ConstantsController::class,'search']);

    Route::post('/mobile/v1/keys/list',[KeyController::class,'list']);

    # File
    Route::post('/mobile/v1/file/upload',[FileController::class,'upload']);

    # SpecialTags
    Route::post('/mobile/v1/special-tags/list',[SpecialTagController::class,'list']);


    Route::group(['middleware' => 'api-auth'],function (){
        Route::post('/mobile/v1/user/sign/set-password',[AuthController::class,'setPassword']);
        Route::post('/mobile/v1/user/sign/logout',[AuthController::class,'logout']);
        Route::post('/mobile/v1/user/check',[ApiAuthController::class,'me']);


        # Estates
        Route::post('/mobile/v1/estate/list',[EstateController::class,'list']);
        Route::post('/mobile/v1/estate/create',[EstateController::class,'create']);
        Route::post('/mobile/v1/estate/update',[EstateController::class,'update']);
        Route::post('/mobile/v1/estate/delete',[EstateController::class,'delete']);
        Route::post('/mobile/v1/estate/view',[EstateController::class,'view']);


        # Notification
        Route::post('/mobile/v1/notification/list',[NotificationController::class,'list']);

        # Favorite (estates)
        Route::post('/mobile/v1/favorite/list',[FavoriteController::class,'list']);
        Route::post('/mobile/v1/favorite/create',[FavoriteController::class,'create']);
        Route::post('/mobile/v1/favorite/update',[FavoriteController::class,'update']);
        Route::post('/mobile/v1/favorite/delete',[FavoriteController::class,'delete']);

        #Stories
        Route::post('/mobile/v1/story/category/list',[StoryCategoryController::class,'list']);
        Route::post('/mobile/v1/story/item/list',[StoryItemController::class,'list']);
        Route::post('/mobile/v1/story/item/view',[StoryItemController::class,'view']);


//        Route::post('/mobile/v1/favorite/update',[FavoriteController::class,'update']);
//        Route::post('/mobile/v1/favorite/delete',[FavoriteController::class,'delete']);
    });
});

Route::group(['middleware' => 'ajax.check'],function (){
    Route::post('/api-user/toggle-status/{user_id}',[ApiUserController::class,'toggleUserActivation']);
    Route::post('/api-token/toggle-status/{token_id}',[ApiUserController::class,'toggleTokenActivation']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
