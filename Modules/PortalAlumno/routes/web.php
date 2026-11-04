<?php

use Illuminate\Support\Facades\Route;
use Modules\PortalAlumno\Http\Controllers\PortalAlumnoController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('portalalumnos', PortalAlumnoController::class)->names('portalalumno');
});
