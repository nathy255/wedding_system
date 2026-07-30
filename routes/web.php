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
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Authenticated Routes ──────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard (Accessible by all roles)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Settings & Help (Accessible by all roles)
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');

    Route::post('/settings', function (Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone'     => ['required', 'string', 'max:20'],
        ]);
        auth()->user()->update($validated);
        return back()->with('success', 'Workspace settings updated!');
    })->name('settings.update');

    Route::get('/help', function () {
        return view('help.index');
    })->name('help.index');

    // ── Management Routes (Restricted) ──
    Route::middleware(['role:admin,committee,couple'])->group(function () {
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

        // Vendors
        Route::resource('vendors', \App\Http\Controllers\VendorController::class)->only(['index', 'show']);

        // Calendar
        Route::get('/calendar', function () {
            $dbEvents = \App\Models\Event::all();
            $events = [];
            foreach ($dbEvents as $ev) {
                if ($ev->event_date) {
                    $dateStr = $ev->event_date->format('Y-m-d');
                    $type = 'blue';
                    if ($ev->event_type === 'wedding') {
                        $type = 'green';
                    } elseif ($ev->event_type === 'conference') {
                        $type = 'purple';
                    }
                    $events[$dateStr][] = [
                        'label' => $ev->name,
                        'type' => $type
                    ];
                }
            }
            return view('calendar.index', compact('events'));
        })->name('calendar.index');

        // Tasks
        Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
        Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
        Route::patch('/tasks/{task}/status', [\App\Http\Controllers\TaskController::class, 'updateStatus'])->name('tasks.status');
        Route::delete('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');

        // Messages
        Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
        Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');

        // Contributors
        Route::resource('contributors', ContributorController::class);

        // Reports
        Route::get('/reports',              [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export/pdf',   [ReportController::class, 'exportPdf'])->name('reports.pdf');
        Route::get('/reports/export/csv',   [ReportController::class, 'exportCsv'])->name('reports.csv');
    });

    // ── Vendor Hub Routes (Restricted to Vendors) ──
    Route::middleware(['role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/leads',     [\App\Http\Controllers\VendorHubController::class, 'leads'])->name('leads');
        Route::get('/proposals', [\App\Http\Controllers\VendorHubController::class, 'proposals'])->name('proposals');
        Route::get('/bookings',  [\App\Http\Controllers\VendorHubController::class, 'bookings'])->name('bookings');
    });

});
