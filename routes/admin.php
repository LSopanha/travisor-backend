<?php

/*
|--------------------------------------------------------------------------
| API Routes FOR ADMIN
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\v1\Admin\AdminController;
use App\Http\Controllers\Api\v1\Admin\ClientController;
use App\Http\Controllers\Api\v1\Admin\ContinentController;
use App\Http\Controllers\Api\v1\Admin\CountryController;
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
   Route::apiResource('/clients', ClientController::class);
   Route::put('clients/{id}/deactivate', [ClientController::class, 'deactivateClient']);
   Route::put('clients/{id}/activate', [ClientController::class, 'activateClient']);
   Route::apiResource('/continents', ContinentController::class);
   Route::put('continents/{id}/deactivate', [ContinentController::class, 'deactivateContinent']);
   Route::put('continents/{id}/activate', [ContinentController::class, 'activateContinent']);
   Route::apiResource('/countries', CountryController::class);
   Route::put('countries/{id}/deactivate', [CountryController::class, 'deactivateCountry']);
   Route::put('countries/{id}/activate', [CountryController::class, 'activateCountry']);
});

Route::post('/login', [AuthController::class, 'loginAuthentication']);