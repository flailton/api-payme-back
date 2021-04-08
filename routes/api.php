<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\Api;

Route::post('auth/login', [Api\AuthController::class, 'login']);
Route::get('user_types', [Api\UserTypeController::class, 'index']);

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::apiResource('users', Api\UserController::class);
    Route::post('auth/logout', [Api\AuthController::class, 'logout']);
    Route::post('transference', [Api\TransferenceController::class, 'transaction']);
});




