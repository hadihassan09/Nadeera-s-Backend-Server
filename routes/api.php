<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Http;

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

Route::middleware('auth:sanctum')->get('image', function (Request $request){
    $image_url = 'https://docs.imagga.com/static/images/docs/sample/japan-605234_1280.jpg';
    $api_credentials = array(
        'key' => 'acc_9a38cfea4645d9e',
        'secret' => 'b54a0a9f0591f2bdeed95dc25a6b4e3c'
    );

    $response = Http::withBasicAuth($api_credentials['key'],$api_credentials['secret'])
        ->get('https://api.imagga.com/v2/categories/personal_photos?image_url='.$image_url);
    return $response;
});


Route::post('/login',[AuthController::class, 'login']);
