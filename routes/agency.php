<?php

use App\Http\Controllers\AgencyController;
use App\Http\Middleware\RedirectLanguage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Agency Subdomain Routes
|--------------------------------------------------------------------------
|
| Routes for the agency subdomain. The RedirectLanguage middleware detects
| the visitor's browser language and redirects to the matching locale
| prefix (en = default/no prefix, fr, es).
|
*/

Route::middleware(RedirectLanguage::class)->group(function () {
    // Default (English) — no locale prefix
    Route::get('/', [AgencyController::class, 'index'])->name('agency.home');

    // Locale-prefixed routes
    Route::get('/{locale}', [AgencyController::class, 'index'])
        ->whereIn('locale', ['fr', 'es'])
        ->name('agency.home.locale');
});
