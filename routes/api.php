<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::group(['prefix' => 'users','middleware' => 'api',], function ($router) {
    Route::post('/', [AuthController::class,'register']); //create a new user
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/refresh', [AuthController::class,'refresh']); //refresh user token
    
    Route::get('/', [UserController::class,'index']); //get all users
    Route::get('/{user_id}', [AuthController::class,'show']); //get a user with id
    Route::patch('/{user_id}',[UserController::class,'update']); //update a users details
    Route::delete('/{user_id}',[UserController::class,'destroy']); //delete a user



});
