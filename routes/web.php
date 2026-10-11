<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CrudController;
use App\Http\Controllers\SystemInstallerController;

Route::get('/', function () {
    return redirect('/_ui');
});

Route::get('/_ui', function () {
    return view('ui.catalog');
})->name('ui.catalog');

// Production Web Installer / Updater (ParsPack cPanel support)
Route::get('/_install', [SystemInstallerController::class, 'install'])->name('system.install');
Route::get('/_update', [SystemInstallerController::class, 'update'])->name('system.update');

// Admin Authentication
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Authenticated Admin Shell
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Dynamic CRUD Engine Routes
        Route::prefix('resources/{resource}')->name('crud.')->group(function () {
            Route::get('/', [CrudController::class, 'index'])->name('index');
            Route::get('/create', [CrudController::class, 'create'])->name('create');
            Route::post('/', [CrudController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CrudController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CrudController::class, 'update'])->name('update');
            Route::delete('/{id}', [CrudController::class, 'destroy'])->name('destroy');
        });
    });
});


