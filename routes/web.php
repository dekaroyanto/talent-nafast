<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GajiTalentController;
use App\Http\Controllers\SesiTalentController;
// use App\Models\GajiTalent;

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

    Route::resource('gaji-talent', GajiTalentController::class)->except(['show']);
    Route::post('gaji-talent/calculate-salary', [GajiTalentController::class, 'calculateSalary'])->name('gaji-talent.calculate-salary');
    Route::get('gaji-talent/filter', [GajiTalentController::class, 'filter'])->name('gaji-talent.filter');
    Route::post('gaji-talent/export-excel', [GajiTalentController::class, 'exportExcel'])->name('gaji-talent.export-excel');
    Route::post('gaji-talent/import-excel', [GajiTalentController::class, 'importExcel'])->name('gaji-talent.import-excel');
    Route::get('gaji-talent/template-excel', [GajiTalentController::class, 'downloadTemplate'])->name('gaji-talent.template-excel');


    Route::get('rekap', [GajiTalentController::class, 'rekapTalent'])->name('rekap');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
