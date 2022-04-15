<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OfferController;
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
Route::group(['prefix' => 'cars'], function ($router) {
    Route::get('/', [CarController::class, 'index']);
    Route::get('/{car_id}', [CarController::class, 'get_details']); 
    //add middleware to protect this route
    Route::group(['middleware' => 'auth:api'], function ($router) {
        Route::post('/', [CarController::class, 'store']); //create a new car
        Route::patch('/{car_id}', [CarController::class, 'update']); //update a car
        Route::delete('/{car_id}', [CarController::class, 'destroy']); //delete a car
    });
});

//add group endpoints for offers
Route::group(['prefix' => 'offers', 'middleware' => 'auth:api'], function () {
    Route::get('/', [OfferController::class, 'index']); //get all offers
    Route::get('/{offer_id}', [OfferController::class, 'show']); //get a specific offer
    Route::post('/', [OfferController::class, 'store']); //create a new offer
    Route::patch('/{offer_id}', [OfferController::class, 'update']); //update an offer
    Route::delete('/{offer_id}', [OfferController::class, 'delete']); //delete an offer
});

//uploading media files
Route::group(['prefix' => 'media', 'middleware' => 'auth:api'], function () {
    Route::get('/{media}', [MediaController::class, 'show']);
    Route::get('/', [MediaController::class, 'index']);
    Route::post('/', [MediaController::class, 'store']);
    // Route::patch('/{media}',[MediaController::class,'update']);
    Route::delete('/{media}', [MediaController::class, 'destroy']);
});
