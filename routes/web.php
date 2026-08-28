<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\ProfileAuditController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::post('/audits', [ProfileAuditController::class, 'store'])->name('profile-audits.store');
    Route::get('/audits/{profileAudit}/processing', [ProfileAuditController::class, 'processing'])->name('profile-audits.processing');
    Route::get('/audits/{profileAudit}/status', [ProfileAuditController::class, 'status'])->name('profile-audits.status');
    Route::get('/audits/{profileAudit}', [ProfileAuditController::class, 'show'])->name('profile-audits.show');

    Route::get('/dashboard', [ProfileAuditController::class, 'history'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

require __DIR__.'/auth.php';
