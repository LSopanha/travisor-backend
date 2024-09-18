<?php

/*
|--------------------------------------------------------------------------
| API Routes FOR CLIENT
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\v1\Client\AuthController;
use App\Http\Controllers\Api\v1\Client\MessageController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api-client', 'prefix' => 'auth/v1'], function ($router) {
   Route::post('logout', [AuthController::class, 'logout']);
   Route::post('token-refresh', [AuthController::class, 'tokenRefresh']);
   Route::post('user-information', [AuthController::class, 'userInformation']);
   // Route::apiResource('/messages', MessageController::class);
});

Route::post('/login', [AuthController::class, 'loginAuthentication']);
Route::post('messages', [MessageController::class, 'store']);