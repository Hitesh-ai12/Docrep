<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlanController;

// Login + Auth
Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Admin Routes - Protected
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('/users', 'admin.users')->name('users');
    Route::view('/payments', 'admin.payments')->name('payments');
    Route::view('/subscriptions', 'admin.subscriptions')->name('subscriptions');
    Route::view('/content', 'admin.content')->name('content');
    Route::view('/roles', 'admin.roles')->name('roles');
    Route::view('/notifications', 'admin.notifications')->name('notifications');
    Route::view('/feedback', 'admin.feedback')->name('feedback');
    Route::view('/settings', 'admin.settings')->name('settings');
    Route::view('/plans', 'admin.plans')->name('plans');

    //plan
    Route::get('/plans', [PlanController::class, 'index'])->name('plans');
    Route::post('/plans/store', [PlanController::class, 'store'])->name('plans.store');
    Route::post('/plans/update/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/delete/{plan}', [PlanController::class, 'destroy'])->name('plans.delete');

});
