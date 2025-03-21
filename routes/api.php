<?php

use App\Enums\PermissionEnum;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\VehiclesTypeController;
use App\Http\Controllers\WebAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/forget-password', [PasswordResetController::class, 'forgetPassword'])->middleware('guest');
Route::get('/reset-password', [PasswordResetController::class, 'resetPasswordPage'])->middleware('guest');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->middleware('guest');

Route::get('/counters', [CounterController::class, 'index']);
Route::get('/profiles', [WebAuthController::class, 'userProfile']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/loginnn', [WebAuthController::class, 'userProfile']);
    Route::post('/loginn', [WebAuthController::class, 'login']);
    Route::post('/register', [MemberController::class, 'store']);
});

Route::middleware('jwt')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/profile', [AuthController::class, 'userProfile']);
    Route::post('/change-password/{id}', [AuthController::class, 'changePassword']);

    Route::group(['prefix' => 'role'], function () {
        Route::get('/', [RoleController::class, 'index'])->permission(PermissionEnum::ROLE_INDEX->value);
        Route::post('/', [RoleController::class, 'store'])->permission(PermissionEnum::ROLE_STORE->value);
        Route::get('/{id}', [RoleController::class, 'show'])->permission(PermissionEnum::ROLE_SHOW->value);
        Route::post('/{id}', [RoleController::class, 'update'])->permission(PermissionEnum::ROLE_UPDATE->value);
        Route::delete('/{id}', [RoleController::class, 'destroy'])->permission(PermissionEnum::ROLE_DESTROY->value);
    });

    Route::group(['prefix' => 'permission'], function () {
        Route::get('/', [PermissionController::class, 'index'])->permission(PermissionEnum::PERMISSION_INDEX->value);
        Route::get('/{id}', [PermissionController::class, 'show'])->permission(PermissionEnum::PERMISSION_SHOW->value);

    });
    
    Route::group(['prefix' => 'user'], function () {
        Route::post('/assign-role', [UserController::class, 'assignRole'])->permission(PermissionEnum::USER_STORE->value);
        Route::post('/remove-role', [UserController::class, 'removeRole'])->permission(PermissionEnum::USER_UPDATE->value);
        Route::get('/', [UserController::class, 'index'])->permission(PermissionEnum::USER_INDEX->value);
        Route::post('/', [UserController::class, 'store'])->permission(PermissionEnum::USER_STORE->value);
        Route::get('/{id}', [UserController::class, 'show'])->permission(PermissionEnum::USER_SHOW->value);
        Route::post('/{id}', [UserController::class, 'update'])->permission(PermissionEnum::USER_UPDATE->value);
        Route::delete('/{id}', [UserController::class, 'destroy'])->permission(PermissionEnum::USER_DESTROY->value);
    });

    Route::group(['prefix' => 'owner'], function () {
        Route::get('/', [OwnerController::class, 'index'])->permission(PermissionEnum::OWNER_INDEX->value);
        Route::post('/', [OwnerController::class, 'store'])->permission(PermissionEnum::OWNER_STORE->value);
        Route::get('/{id}', [OwnerController::class, 'show'])->permission(PermissionEnum::OWNER_SHOW->value);
        Route::post('/{id}', [OwnerController::class, 'update'])->permission(PermissionEnum::OWNER_UPDATE->value);
        Route::delete('/{id}', [OwnerController::class, 'destroy'])->permission(PermissionEnum::OWNER_DESTROY->value);        
    });

    Route::group(['prefix' => 'corner'], function () {
        Route::get('/', [CornerController::class, 'index'])->permission(PermissionEnum::CORNER_INDEX->value);
        Route::post('/', [CornerController::class, 'store'])->permission(PermissionEnum::CORNER_STORE->value);
        Route::get('/{id}', [CornerController::class, 'show'])->permission(PermissionEnum::CORNER_SHOW->value);
        Route::post('/{id}', [CornerController::class, 'update'])->permission(PermissionEnum::CORNER_UPDATE->value);
        Route::delete('/{id}', [CornerController::class, 'destroy'])->permission(PermissionEnum::CORNER_DESTROY->value);        
    });

    Route::group(['prefix' => 'city'], function () {
        Route::get('/', [CityController::class, 'index'])->permission(PermissionEnum::CITY_INDEX->value);
        Route::post('/', [CityController::class, 'store'])->permission(PermissionEnum::CITY_STORE->value);
        Route::get('/{id}', [CityController::class, 'show'])->permission(PermissionEnum::CITY_SHOW->value);
        Route::post('/{id}', [CityController::class, 'update'])->permission(PermissionEnum::CITY_UPDATE->value);
        Route::delete('/{id}', [CityController::class, 'destroy'])->permission(PermissionEnum::CITY_DESTROY->value);        
    });

    Route::group(['prefix' => 'township'], function () {
        Route::get('/', [TownshipController::class, 'index'])->permission(PermissionEnum::TOWNSHIP_INDEX->value);
        Route::post('/', [TownshipController::class, 'store'])->permission(PermissionEnum::TOWNSHIP_STORE->value);
        Route::get('/{id}', [TownshipController::class, 'show'])->permission(PermissionEnum::TOWNSHIP_SHOW->value);
        Route::post('/{id}', [TownshipController::class, 'update'])->permission(PermissionEnum::TOWNSHIP_UPDATE->value);
        Route::delete('/{id}', [TownshipController::class, 'destroy'])->permission(PermissionEnum::TOWNSHIP_DESTROY->value);        
    });

    Route::group(['prefix' => 'ward'], function () {
        Route::get('/', [WardController::class, 'index'])->permission(PermissionEnum::WARD_INDEX->value);
        Route::post('/', [WardController::class, 'store'])->permission(PermissionEnum::WARD_STORE->value);
        Route::get('/{id}', [WardController::class, 'show'])->permission(PermissionEnum::WARD_SHOW->value);
        Route::post('/{id}', [WardController::class, 'update'])->permission(PermissionEnum::WARD_UPDATE->value);
        Route::delete('/{id}', [WardController::class, 'destroy'])->permission(PermissionEnum::WARD_DESTROY->value);        
    });

    Route::group(['prefix' => 'street'], function () {
        Route::get('/', [StreetController::class, 'index'])->permission(PermissionEnum::STREET_INDEX->value);
        Route::post('/', [StreetController::class, 'store'])->permission(PermissionEnum::STREET_STORE->value);
        Route::get('/{id}', [StreetController::class, 'show'])->permission(PermissionEnum::STREET_SHOW->value);
        Route::post('/{id}', [StreetController::class, 'update'])->permission(PermissionEnum::STREET_UPDATE->value);
        Route::delete('/{id}', [StreetController::class, 'destroy'])->permission(PermissionEnum::STREET_DESTROY->value);        
    });

    Route::group(['prefix' => 'wifi'], function () {
        Route::get('/', [WifiController::class, 'index'])->permission(PermissionEnum::WIFI_INDEX->value);
        Route::post('/', [WifiController::class, 'store'])->permission(PermissionEnum::WIFI_STORE->value);
        Route::get('/{id}', [WifiController::class, 'show'])->permission(PermissionEnum::WIFI_SHOW->value);
        Route::post('/{id}', [WifiController::class, 'update'])->permission(PermissionEnum::WIFI_UPDATE->value);
        Route::delete('/{id}', [WifiController::class, 'destroy'])->permission(PermissionEnum::WIFI_DESTROY->value);        
    });

    Route::group(['prefix' => 'land'], function () {
        Route::get('/', [LandController::class, 'index'])->permission(PermissionEnum::LAND_INDEX->value);
        Route::post('/', [LandController::class, 'store'])->permission(PermissionEnum::LAND_STORE->value);
        Route::get('/{id}', [LandController::class, 'show'])->permission(PermissionEnum::LAND_SHOW->value);
        Route::post('/{id}', [LandController::class, 'update'])->permission(PermissionEnum::LAND_UPDATE->value);
        Route::delete('/{id}', [LandController::class, 'destroy'])->permission(PermissionEnum::LAND_DESTROY->value);        
    });

    Route::group(['prefix' => 'renter'], function () {
        Route::get('/', [RenterController::class, 'index'])->permission(PermissionEnum::RENTER_INDEX->value);
        Route::post('/', [RenterController::class, 'store'])->permission(PermissionEnum::RENTER_STORE->value);
        Route::get('/{id}', [RenterController::class, 'show'])->permission(PermissionEnum::RENTER_SHOW->value);
        Route::post('/{id}', [RenterController::class, 'update'])->permission(PermissionEnum::RENTER_UPDATE->value);
        Route::delete('/{id}', [RenterController::class, 'destroy'])->permission(PermissionEnum::RENTER_DESTROY->value);        
    });

    Route::group(['prefix' => 'ownerdata'], function () {
        Route::get('/', [OwnerDataController::class, 'index'])->permission(PermissionEnum::OWNER_DATA_INDEX->value);
        Route::post('/', [OwnerDataController::class, 'store'])->permission(PermissionEnum::OWNER_DATA_STORE->value);
        Route::get('/{id}', [OwnerDataController::class, 'show'])->permission(PermissionEnum::OWNER_DATA_SHOW->value);
        Route::post('/{id}', [OwnerDataController::class, 'update'])->permission(PermissionEnum::OWNER_DATA_UPDATE->value);
        Route::delete('/{id}', [OwnerDataController::class, 'destroy'])->permission(PermissionEnum::OWNER_DATA_DESTROY->value);        
    });

});

// Route::get('/image/{path}', [ItemController::class, 'getImage'])->where('path', '.*');
