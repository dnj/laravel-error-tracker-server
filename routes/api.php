<?php

use dnj\ErrorTracker\Laravel\Server\Http\Controllers\AppController;
use dnj\ErrorTracker\Laravel\Server\Http\Controllers\DeviceController;
use dnj\ErrorTracker\Laravel\Server\Http\Controllers\LogController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', SubstituteBindings::class])->group(function () {
    Route::group(['prefix' => 'app', 'as' => 'app.'], function () {
        Route::get('/search', [AppController::class, 'search'])->name('search');
        Route::post('/store', [AppController::class, 'store'])->name('store');
        Route::put('/update/{id}', [AppController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [AppController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'device', 'as' => 'device.'], function () {
        Route::get('/search', [DeviceController::class, 'search'])->name('search');
        Route::post('/store', [DeviceController::class, 'store'])->name('store');
        Route::put('/update/{id}', [DeviceController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [DeviceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'log', 'as' => 'log.'], function () {
        Route::get('/search', [LogController::class, 'search'])->name('search');
        Route::post('/store', [LogController::class, 'store'])->name('store');
        Route::delete('/destroy/{id}', [LogController::class, 'destroy'])->name('destroy');
    });
});
