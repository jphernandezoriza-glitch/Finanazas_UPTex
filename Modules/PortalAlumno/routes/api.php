<?php

use Illuminate\Support\Facades\Route;
use Modules\PortalAlumno\Http\Controllers\PortalAlumnoController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('portalalumnos', PortalAlumnoController::class)->names('portalalumno');
});
