<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\ContributorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EventController;

// ── Public Routes ─────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Authenticated Routes ──────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Events
    Route::resource('events', EventController::class);

    // Contributions
    Route::resource('contributions', ContributionController::class);
    Route::patch('/contributions/{contribution}/confirm', [ContributionController::class, 'confirm'])->name('contributions.confirm');
    Route::patch('/contributions/{contribution}/reject',  [ContributionController::class, 'reject'])->name('contributions.reject');
    Route::get('/contributions/{contribution}/receipt',   [ContributionController::class, 'receipt'])->name('contributions.receipt');

    // Gifts
    Route::resource('gifts', GiftController::class);
    Route::patch('/gifts/{gift}/receive',  [GiftController::class, 'receive'])->name('gifts.receive');

    // Contributors
    Route::resource('contributors', ContributorController::class);

    // Reports
    Route::get('/reports',              [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/pdf',   [ReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('/reports/export/csv',   [ReportController::class, 'exportCsv'])->name('reports.csv');

});
