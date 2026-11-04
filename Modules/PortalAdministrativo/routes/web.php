<?php

use Illuminate\Support\Facades\Route;
use Modules\PortalAdministrativo\Http\Controllers\PortalAdministrativoController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('portaladministrativos', PortalAdministrativoController::class)->names('portaladministrativo');
});
