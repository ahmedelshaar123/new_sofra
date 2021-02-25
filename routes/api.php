<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MainController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function (){
    Route::get('cities', [MainController::class, 'cities']);
    Route::get('regions', [MainController::class, 'regions']);
    Route::get('settings', [MainController::class, 'settings']);
    Route::get('static-pages', [MainController::class, 'staticPages']);
    Route::Post('create-contact', [MainController::class, 'createContact']);
    Route::Post('register-token', [AuthController::class, 'registerToken']);
    Route::Post('remove-token', [AuthController::class, 'removeToken']);
});
