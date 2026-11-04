<?php

use Illuminate\Support\Facades\Route;
use Modules\PortalAdministrativo\Http\Controllers\PortalAdministrativoController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('portaladministrativos', PortalAdministrativoController::class)->names('portaladministrativo');
});
