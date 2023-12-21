<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blade\UserController;
use App\Http\Controllers\Blade\RoleController;
use App\Http\Controllers\Blade\PermissionController;
use App\Http\Controllers\Blade\HomeController;
use App\Http\Controllers\Blade\ApiUserController;
use App\Http\Controllers\Blade\RegionController;
use App\Http\Controllers\Blade\DistrictController;
use App\Http\Controllers\Blade\QuarterController;
use App\Http\Controllers\Blade\ItemController;
/*
|--------------------------------------------------------------------------
| Blade (front-end) Routes
|--------------------------------------------------------------------------
|
| Here is we write all routes which are related to web pages
| like UserManagement interfaces, Diagrams and others
|
*/

// Default laravel auth routes
Auth::routes();


// Welcome page
Route::get('/', function (){
    return redirect()->route('home');
})->name('welcome');

// Web pages
Route::group(['middleware' => 'auth'],function (){

    # there should be graphics, diagrams about total conditions
    Route::get('/home', [HomeController::class,'index'])->name('home');

    # Users
    Route::get('/users',[UserController::class,'index'])->name('userIndex');
    Route::get('/user/add',[UserController::class,'add'])->name('userAdd');
    Route::post('/user/create',[UserController::class,'create'])->name('userCreate');
    Route::get('/user/{id}/edit',[UserController::class,'edit'])->name('userEdit');
    Route::post('/user/update/{id}',[UserController::class,'update'])->name('userUpdate');
    Route::delete('/user/delete/{id}',[UserController::class,'destroy'])->name('userDestroy');
    Route::get('/user/theme-set/{id}',[UserController::class,'setTheme'])->name('userSetTheme');

    # Permissions
    Route::get('/permissions',[PermissionController::class,'index'])->name('permissionIndex');
    Route::get('/permission/add',[PermissionController::class,'add'])->name('permissionAdd');
    Route::post('/permission/create',[PermissionController::class,'create'])->name('permissionCreate');
    Route::get('/permission/{id}/edit',[PermissionController::class,'edit'])->name('permissionEdit');
    Route::post('/permission/update/{id}',[PermissionController::class,'update'])->name('permissionUpdate');
    Route::delete('/permission/delete/{id}',[PermissionController::class,'destroy'])->name('permissionDestroy');

    # Roles
    Route::get('/roles',[RoleController::class,'index'])->name('roleIndex');
    Route::get('/role/add',[RoleController::class,'add'])->name('roleAdd');
    Route::post('/role/create',[RoleController::class,'create'])->name('roleCreate');
    Route::get('/role/{role_id}/edit',[RoleController::class,'edit'])->name('roleEdit');
    Route::post('/role/update/{role_id}',[RoleController::class,'update'])->name('roleUpdate');
    Route::delete('/role/delete/{id}',[RoleController::class,'destroy'])->name('roleDestroy');

    # ApiUsers
    Route::get('/api-users',[ApiUserController::class,'index'])->name('api-userIndex');
    Route::get('/api-user/add',[ApiUserController::class,'add'])->name('api-userAdd');
    Route::post('/api-user/create',[ApiUserController::class,'create'])->name('api-userCreate');
    Route::get('/api-user/show/{id}',[ApiUserController::class,'show'])->name('api-userShow');
    Route::get('/api-user/{id}/edit',[ApiUserController::class,'edit'])->name('api-userEdit');
    Route::post('/api-user/update/{id}',[ApiUserController::class,'update'])->name('api-userUpdate');
    Route::delete('/api-user/delete/{id}',[ApiUserController::class,'destroy'])->name('api-userDestroy');
    Route::delete('/api-user-token/delete/{id}',[ApiUserController::class,'destroyToken'])->name('api-tokenDestroy');


    # Regions
    Route::get('/admin/regions',[RegionController::class,'index'])->name('regionIndex');
    Route::get('/admin/region/add',[RegionController::class,'add'])->name('regionAdd');
    Route::post('/admin/region/create',[RegionController::class,'create'])->name('regionCreate');
    Route::get('/admin/region/{region_id}/edit',[RegionController::class,'edit'])->name('regionEdit');
    Route::post('/admin/region/update/{region_id}',[RegionController::class,'update'])->name('regionUpdate');
    Route::delete('/admin/region/delete/{id}',[RegionController::class,'destroy'])->name('regionDestroy');

    # District
    Route::get('/admin/districts',[DistrictController::class,'index'])->name('districtIndex');
    Route::get('/admin/district/add',[DistrictController::class,'add'])->name('districtAdd');
    Route::post('/admin/district/create',[DistrictController::class,'create'])->name('districtCreate');
    Route::get('/admin/district/{district_id}/edit',[DistrictController::class,'edit'])->name('districtEdit');
    Route::post('/admin/district/update/{district_id}',[DistrictController::class,'update'])->name('districtUpdate');
    Route::delete('/admin/district/delete/{id}',[DistrictController::class,'destroy'])->name('districtDestroy');

    # Quarter
    Route::get('/admin/quarters',[QuarterController::class,'index'])->name('quarterIndex');
    Route::get('/admin/quarter/add',[QuarterController::class,'add'])->name('quarterAdd');
    Route::post('/admin/quarter/create',[QuarterController::class,'create'])->name('quarterCreate');
    Route::get('/admin/quarter/{quarter_id}/edit',[QuarterController::class,'edit'])->name('quarterEdit');
    Route::post('/admin/quarter/update/{quarter_id}',[QuarterController::class,'update'])->name('quarterUpdate');
    Route::delete('/admin/quarter/delete/{id}',[QuarterController::class,'destroy'])->name('quarterDestroy');

    # Item
    Route::get('/admin/items',[ItemController::class,'index'])->name('itemIndex');
    Route::get('/admin/item/add',[ItemController::class,'add'])->name('itemAdd');
    Route::post('/admin/item/create',[ItemController::class,'create'])->name('itemCreate');
    Route::get('/admin/item/{item_id}/edit',[ItemController::class,'edit'])->name('itemEdit');
    Route::post('/admin/item/update/{item_id}',[ItemController::class,'update'])->name('itemUpdate');
    Route::delete('/admin/item/delete/{id}',[ItemController::class,'destroy'])->name('itemDestroy');
});

// Change language session condition
Route::get('/language/{lang}',function ($lang){
    $lang = strtolower($lang);
    if ($lang == 'ru' || $lang == 'uz')
    {
        session([
            'locale' => $lang
        ]);
    }
    return redirect()->back();
});

/*
|--------------------------------------------------------------------------
| This is the end of Blade (front-end) Routes
|-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\
*/
