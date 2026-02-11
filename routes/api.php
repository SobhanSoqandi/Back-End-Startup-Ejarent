<?php

use App\Http\Controllers\Advertisements\AdvertisementsController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\categories\categorycontroller;
use App\Http\Controllers\Reservation\ReservationController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Users 
Route::get('/get-users', [UsersController::class, 'getUsers']);

Route::get('/get-user/{user}', [UsersController::class, 'getUser']);

Route::delete('/user/{user}/destroy', [UsersController::class, 'destroy']);






// Authentication
Route::post('/SendOtp', [AuthController::class, 'SendOtp']);

Route::post('/checkotp', [AuthController::class, 'CheckOtp']);

Route::post('/complete-profile', [AuthController::class, 'completeprofile']);




// Advertisement
Route::get('/Advertisements', [AdvertisementsController::class, 'index']);

Route::get('/Advertisements/search', [AdvertisementsController::class, 'search']);

Route::get('/Advertisement/{advertisement}/show', [AdvertisementsController::class, 'show']);



// Categories
Route::post('/category/store', [categorycontroller::class, 'store']);

Route::get('/categories', [categorycontroller::class, 'index']);

Route::delete('/category/{category}/delete', [categorycontroller::class, 'delete']);

Route::put('/category/{category}/update', [categorycontroller::class, 'update']);

// Route::get('/category/{category}/show', [categorycontroller::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {

    // Advertisement : 
    Route::post('/Advertisement/store', [AdvertisementsController::class, 'store']);

    Route::put('/advertisement/{advertisement}/update', [AdvertisementsController::class, 'update']);

    Route::delete('/advertisement/{advertisement}/delete', [AdvertisementsController::class, 'delete']);

    Route::get('/advertisement/my', [AdvertisementsController::class, 'myAdvertisements']);

    Route::get('/user/profile', [UsersController::class, 'show']);


    // Auth
    Route::post('/user/logout', [AuthController::class, 'logout']);


    Route::get('/category/{category}/show', [categorycontroller::class, 'show']);
});



// Attributes : 
Route::get('/attributes', [AttributeController::class, 'index']);

Route::post('/attribute/store', [AttributeController::class, 'store']);

Route::put('/attribute/{attribute}/update', [AttributeController::class, 'update']);


// Reservation : 
Route::post('/rent-request/store', [ReservationController::class, 'store']);

Route::get('/myrequest/{userId}', [ReservationController::class, 'myRequest']);

Route::get('/advertisement-request/{AdId}', [ReservationController::class, 'myAdvertisementRequest']);

Route::put('/reserve/update-status/{reserveid}', [ReservationController::class, 'UpdateStatus']);
