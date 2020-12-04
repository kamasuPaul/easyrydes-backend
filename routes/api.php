<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
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

//users endpoint
Route::group(['prefix' => 'users'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']); //refresh user token
    Route::post('/me', [AuthController::class, 'me']); //get user using a token
    Route::post('/forgot_password', [AuthController::class, 'forgot_password']); //request email for reseting password
    Route::post('/reset_password/{token}', [AuthController::class, 'reset_password']); //reset password
    Route::post('/', [AuthController::class, 'register']); //create a new user

    Route::group(['middleware' => 'auth:api'], function ($router) {
        Route::get('/', [UserController::class, 'index']); //get all users
        Route::get('/{user_id}/cars', [CarController::class, 'get_user_cars']); //get cars listed by a user
        Route::get('/{user_id}', [UserController::class, 'show']); //get a user with id
        Route::patch('/{user_id}', [UserController::class, 'update']); //update a users details
        Route::delete('/{user_id}', [UserController::class, 'destroy']); //delete a user
    });
});

/**
 * Prefix cars
 * Requires an access token obtained on login
 */
Route::group(['prefix' => 'cars', 'middeware' => 'auth:api'], function ($router) {
    Route::get('/', [CarController::class, 'index']); //get all cars/search for cars
    Route::get('/{car_id}', [CarController::class, 'get_details']); //get details for a specific car
    Route::patch('/{car_id', [CarController::class, 'update']); //update a cars details
    Route::post('/', [CarController::class, 'create_new_car']); //add a new car
    Route::delete('/{car_id}', [CarController::class, 'delete']); //delete an existing car
});
