<?php

/*
|--------------------------------------------------------------------------
| API Routes FOR ADMIN
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\v1\Admin\AdminController;
use App\Http\Controllers\Api\v1\Admin\RoleController;
use App\Http\Controllers\Api\v1\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api', 'prefix' => 'auth/v1'], function ($router) {
   Route::post('logout', [AuthController::class, 'logout']);
   Route::post('token-refresh', [AuthController::class, 'tokenRefresh']);
   Route::post('user-information', [AuthController::class, 'userInformation']);
   Route::apiResource('/admins', AdminController::class);
   Route::put('admins/{id}/deactivate', [AdminController::class, 'deactivateAdmin']);
   Route::put('admins/{id}/activate', [AdminController::class, 'activateAdmin']);
   Route::apiResource('/roles', RoleController::class);
});

Route::post('/login', [AuthController::class, 'loginAuthentication']);