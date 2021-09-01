<?php

use App\Http\Controllers\Api\UsersController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function($routes) {
    Route::post("/login", [UsersController::class, 'login']);
    Route::post("/register", [UsersController::class, 'register']);
    Route::post('/me', [UsersController::class, 'userProfile']);  
    Route::post("/logout", [UsersController::class, 'logout']);
    Route::post('/reset_password', [UsersController::class, 'resetPassword']);
});

