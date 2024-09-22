<?php

/*
|--------------------------------------------------------------------------
| API Routes FOR CLIENT
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\v1\Client\DestinationController;
use App\Http\Controllers\Api\v1\Client\ContinentController;
use App\Http\Controllers\Api\v1\Client\CountryController;
use App\Http\Controllers\Api\v1\Client\BlogController;
use App\Http\Controllers\Api\v1\Client\ClientController;
use App\Http\Controllers\Api\v1\Client\AuthController;
use App\Http\Controllers\Api\v1\Client\MessageController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api-client', 'prefix' => 'auth/v1'], function ($router) {
   Route::post('logout', [AuthController::class, 'logout']);
   Route::post('token-refresh', [AuthController::class, 'tokenRefresh']);
   Route::post('user-information', [AuthController::class, 'userInformation']);
   Route::apiResource('/users', ClientController::class);
   Route::post('blogs', [BlogController::class, 'store']);
   Route::get('blogs/{id}', [BlogController::class, 'show']);
   Route::delete('blogs/{id}', [BlogController::class, 'destroy']);
});

Route::post('/login', [AuthController::class, 'loginAuthentication']);
Route::post('/register', [ClientController::class, 'selfRegister']);
Route::post('messages', [MessageController::class, 'store']);
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);
Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/{id}', [DestinationController::class, 'show']);
Route::get('/destinations-list/{id}', [DestinationController::class, 'destinationsByCountry']);
Route::get('/continents', [ContinentController::class, 'index']);
Route::get('/continents/{id}', [ContinentController::class, 'show']);\Route::get('/continents', [ContinentController::class, 'index']);
Route::get('/continents/{id}', [ContinentController::class, 'show']);
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{id}', [CountryController::class, 'show']);
Route::get('/countries/{id}/list', [CountryController::class, 'getCountriesByContinent']);

