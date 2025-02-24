<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use \App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->post('image', [UserController::class, 'createImage']);
Route::middleware('auth:sanctum')->get('image/all', [UserController::class, 'userImages']);


Route::post('/login',[AuthController::class, 'login']);
