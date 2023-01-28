<?php

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', SubstituteBindings::class])->group(function () {
    // TODO
});
