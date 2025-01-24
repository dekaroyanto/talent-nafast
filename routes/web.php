<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TalentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('change-password', [AuthController::class, 'editPassword'])->name('password.edit');
    Route::post('change-password', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::get('talent', [TalentController::class, 'index'])->name('talent.index');
    Route::get('talent/create', [TalentController::class, 'create'])->name('talent.create');
    Route::post('talent', [TalentController::class, 'store'])->name('talent.store');
    Route::get('/talent/edit/{id}', [TalentController::class, 'edit'])->name('talent.edit');

    Route::post('/talent/update/{id}', [TalentController::class, 'update'])->name('talent.update');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
