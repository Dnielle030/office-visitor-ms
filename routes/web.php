<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\VisitorController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Any active staff member (receptionist or admin)
Route::middleware(['auth', RoleMiddleware::class.':receptionist,admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');
    Route::get('/visitors/inside', [VisitorController::class, 'inside'])->name('visitors.inside');
    Route::get('/visitors/create', [VisitorController::class, 'create'])->name('visitors.create');
    Route::post('/visitors', [VisitorController::class, 'store'])->name('visitors.store');
    Route::patch('/visitors/{visitor}/checkout', [VisitorController::class, 'checkout'])
        ->whereNumber('visitor')->name('visitors.checkout');
});

// Administrators only
Route::middleware(['auth', RoleMiddleware::class.':admin'])->group(function () {
    Route::get('/visitors/{visitor}/edit', [VisitorController::class, 'edit'])->whereNumber('visitor')->name('visitors.edit');
    Route::put('/visitors/{visitor}', [VisitorController::class, 'update'])->whereNumber('visitor')->name('visitors.update');
    Route::delete('/visitors/{visitor}', [VisitorController::class, 'archive'])->whereNumber('visitor')->name('visitors.archive');
    Route::patch('/visitors/{visitor}/restore', [VisitorController::class, 'restore'])
        ->whereNumber('visitor')->withTrashed()->name('visitors.restore');

    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::patch('/staff/{user}/toggle', [StaffController::class, 'toggle'])->name('staff.toggle');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('logs.index');
});
