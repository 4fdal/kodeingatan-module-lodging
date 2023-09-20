<?php

use Illuminate\Support\Facades\Route;
use Kodeingatan\Lodging\Http\Controllers\LodgingController;
use Kodeingatan\Lodging\Http\Controllers\LandingPageController;

Route::group([
    'prefix' => config('lodging.landing_page.prefix'),
    'as' => 'lodging.',
], function () {

    Route::get('assets', [LodgingController::class, 'assets'])->name('assets');

    Route::as('landing_page.')->group(function () {
        Route::get("/", [LandingPageController::class, 'index'])->name('index');
    });
});
