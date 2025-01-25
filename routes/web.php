<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SesiTalentController;

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
    Route::delete('/talent/{talent}', [TalentController::class, 'destroy'])->name('talent.destroy');
    Route::post('/talent/update/{id}', [TalentController::class, 'update'])->name('talent.update');

    Route::get('/sesi-talent', [SesiTalentController::class, 'index'])->name('sesi-talent.index');
    Route::post('/sesi-talent', [SesiTalentController::class, 'store'])->name('sesi-talent.store');
    Route::get('/sesi-talent/{sesiTalent}/edit', [SesiTalentController::class, 'edit'])->name('sesi-talent.edit');
    Route::put('/sesi-talent/{sesiTalent}', [SesiTalentController::class, 'update'])->name('sesi-talent.update');
    Route::delete('/sesi-talent/{sesiTalent}', [SesiTalentController::class, 'destroy'])->name('sesi-talent.destroy');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
