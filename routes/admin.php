<?php

/*
|--------------------------------------------------------------------------
| API Routes FOR ADMIN
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Admin\AuthController;

Route::group(['middleware' => 'auth:api', 'prefix' => 'auth/v1'], function ($router) {
   Route::post('logout', [AuthController::class, 'logout']);
   Route::post('token-refresh', [AuthController::class, 'tokenRefresh']);
   Route::post('user-information', [AuthController::class, 'userInformation']);
});

Route::post('/login', [AuthController::class, 'loginAuthentication']);