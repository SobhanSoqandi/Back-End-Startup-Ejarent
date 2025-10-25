<?php

use App\Http\Controllers\Advertisements\AdvertisementsController;
use App\Http\Controllers\Auth\AuthController;
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



Route::post('/SendOtp', [AuthController::class, 'SendOtp']);

Route::post('/check-otp', [AuthController::class, 'CheckOtp']);

Route::get('/Advertisement/{Advertisement}/show', [AdvertisementsController::class , 'show']);

Route::put('/Advertisement/{Advertisement}/update', [AdvertisementsController::class , 'update']);

Route::post('/Advertisement/store', [AdvertisementsController::class, 'store']);
