<?php

use App\Http\Controllers\Advertisements\AdvertisementsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\categories\categorycontroller;
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


// Authentication
Route::post('/SendOtp', [AuthController::class, 'SendOtp']);

Route::post('/checkotp', [AuthController::class, 'CheckOtp']);



// Advertisement
Route::get('/Advertisements', [AdvertisementsController::class , 'index']);

Route::get('/Advertisement/{advertisement}/show', [AdvertisementsController::class , 'show']);

Route::put('/Advertisement/{advertisement}/update', [AdvertisementsController::class , 'update']);

Route::delete('/Advertisement/{advertisement}/delete', [AdvertisementsController::class , 'delete']);

Route::post('/Advertisement/store', [AdvertisementsController::class, 'store']);


// Categories
Route::post('/category/store', [categorycontroller::class , 'store']);

Route::delete('/category/{category}/delete', [categorycontroller::class , 'delete']);

Route::put('/category/{category}/update', [categorycontroller::class , 'update']);

Route::get('/category/{category}/show', [categorycontroller::class , 'show']);
