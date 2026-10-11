<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CrudController;
use App\Http\Controllers\SystemInstallerController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\InquirySubmissionController;

// Public UI Catalog for Design System Review
Route::get('/_ui', function () {
    return view('ui.catalog');
})->name('ui.catalog');

// Root redirect to default locale (/fa)
Route::get('/', function () {
    return redirect('/fa');
});

// Bilingual Public Pages (/fa and /en)
Route::prefix('{locale}')->where(['locale' => 'fa|en'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Portfolio
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

    // Blog
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    // Pages
    Route::get('/services', [PageController::class, 'services'])->name('services.index');
    Route::get('/resume', [PageController::class, 'resume'])->name('resume.index');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact.index');
    Route::post('/contact', [InquirySubmissionController::class, 'store'])->name('contact.store');
});

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


