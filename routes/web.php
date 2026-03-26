<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Frontend\SiteController as FrontendSiteController;
use App\Http\Controllers\Tenant\MediaController;
use App\Http\Controllers\Tenant\PageController;
use App\Http\Controllers\Tenant\SiteController as TenantSiteController;
use App\Http\Middleware\TenantResolver;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('tenant.')->group(function () {
    Route::resource('sites', TenantSiteController::class)->only(['index', 'create', 'store']);

    Route::middleware(TenantResolver::class)->group(function () {
        Route::get('pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('pages/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('pages', [PageController::class, 'store'])->name('pages.store');
        Route::get('pages/{page}/builder', [PageController::class, 'builder'])->name('pages.builder');
        Route::post('pages/{page}/sections', [PageController::class, 'updateSections'])->name('pages.sections.update');
        Route::post('pages/{page}/duplicate', [PageController::class, 'duplicate'])->name('pages.duplicate');

        Route::get('media', [MediaController::class, 'index'])->name('media.index');
        Route::post('media', [MediaController::class, 'store'])->name('media.store');
    });
});

Route::middleware(['auth', 'verified', 'can:access-admin-panel'])->prefix('super-admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
});

Route::middleware(TenantResolver::class)->group(function () {
    Route::get('/', [FrontendSiteController::class, 'home'])->name('site.home');
    Route::get('/{slug}', [FrontendSiteController::class, 'show'])->name('site.show');
});
