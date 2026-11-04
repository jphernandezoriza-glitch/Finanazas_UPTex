<?php

use Illuminate\Support\Facades\Route;
use Modules\Finanzas\Http\Controllers\FinanzasController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('finanzas', FinanzasController::class)->names('finanzas');
});
