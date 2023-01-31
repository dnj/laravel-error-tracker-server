<?php

use dnj\ErrorTracker\Laravel\Server\Http\Controllers\AppController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', SubstituteBindings::class])->group(function () {
    Route::group(['prefix' => 'app', 'as' => 'app.'], function () {
        Route::get('/search', [AppController::class, 'search'])->name('search');
        Route::post('/store', [AppController::class, 'store'])->name('store');
        Route::put('/update/{id}', [AppController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [AppController::class, 'destroy'])->name('destroy');
    });
});
