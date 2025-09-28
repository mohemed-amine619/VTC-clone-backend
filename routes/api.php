<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MapBox\PlaceController;
use App\Http\Controllers\Vehicule\VehiculeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('/users', 'register');
    Route::post('/login', 'Login');
    Route::post('/users/verify-email', 'ValidateUserEmail');
});

Route::controller(PlaceController::class) ->group(function(){
    Route::get('/places', 'fetchPlaces');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(AuthController::class)->group(function () {

        Route::post('/logout', 'logout');
        Route::get('/users', 'getUsers');
        Route::post('users/modify-role', 'updateRole');
    });
    Route::controller(VehiculeController::class)->group(function () {
        Route::post('/vehicules', 'store');
        Route::put('/vehicules', 'update');
        Route::delete('/vehicules', 'destroy');
        Route::post('vehicules/images', 'addImage');
        Route::get('/vehicules', 'getVehicule');
    });
  
});