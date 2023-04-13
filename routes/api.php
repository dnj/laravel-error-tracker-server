<?php

use dnj\ErrorTracker\Laravel\Server\Http\Controllers\AppController;
use dnj\ErrorTracker\Laravel\Server\Http\Controllers\DeviceController;
use dnj\ErrorTracker\Laravel\Server\Http\Controllers\LogController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', SubstituteBindings::class])->group(function () {
    Route::apiResources([
        'apps' => AppController::class,
        'devices' => DeviceController::class,
        'logs' => LogController::class,
    ]);
    Route::group(['prefix' => 'logs', 'as' => 'logs.'], function () {
        Route::put('/markAsRead/{log}', [LogController::class, 'markAsRead'])->name('mark_as_read');
        Route::put('/markAsUnRead/{log}', [LogController::class, 'markAsUnRead'])->name('mark_as_unread');
    });
});
