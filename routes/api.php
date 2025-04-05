<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/select-account', [AuthController::class, 'selectAccount']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/doctors', [AuthController::class, 'getAllDoctors']);
Route::middleware('auth:sanctum')->get('/doctor/{id}', [AuthController::class, 'getDoctorById']);
Route::middleware('auth:sanctum')->post('/update-profile', [AuthController::class, 'updateProfile']);
