<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\DoctorRepController;
use App\Http\Controllers\Api\JobPostController;
use App\Http\Controllers\Api\DocumentController;

Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/select-account', [AuthController::class, 'selectAccount']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', fn(Request $request) => $request->user());
    Route::get('/doctors', [AuthController::class, 'getAllDoctors']);
    Route::get('/doctor/{id}', [AuthController::class, 'getDoctorById']);
    Route::get('/medical-representatives', [AuthController::class, 'getAllMedicalRepresentatives']);
    Route::get('/medical-representative/{id}', [AuthController::class, 'getMedicalRepresentativeById']);

    Route::post('/update-profile', [AuthController::class, 'updateProfile']);

    Route::post('/update-mr-profile', [AuthController::class, 'updateMrProfile']);
    Route::post('/profile/photo', [AuthController::class, 'updateProfilePhoto']);
    Route::delete('/profile/photo', [AuthController::class, 'removeProfilePhoto']);
    Route::get('/profile/photo', [AuthController::class, 'getProfilePhoto']);

    Route::post('/profile/update', [DoctorRepController::class, 'updateProfile']);

    Route::post('/doctor/rep-action', [DoctorRepController::class, 'repAction']);
    // ✅ Your Plans API
    Route::get('/plans', [PlanController::class, 'index']);

    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);


    Route::post('/doctor/assign-slot', [DoctorRepController::class, 'assignSlot']);
    Route::get('/doctor/slots-by-date', [DoctorRepController::class, 'getSlotsByDate']);
    Route::post('/jobs', [JobPostController::class, 'store']); // For doctors to post job
    Route::get('/jobs', [JobPostController::class, 'index']);   // Optional: Get all jobs

    Route::post('/documents/upload', [DocumentController::class, 'upload']);
    Route::get('/documents', [DocumentController::class, 'index']);

});
