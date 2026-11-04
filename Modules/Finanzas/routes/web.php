<?php

use Illuminate\Support\Facades\Route;

// Grupo transferible: la entrada en el menú central se aplica desde integracion/monolito.patch.
Route::middleware(['web', 'auth', 'permission:acceso.finanzas'])->prefix('portal-administrativo/finanzas')->name('admin.finanzas.')->group(function (): void {
    Route::view('/', 'finanzas::index')->name('index');
    Route::view('/servicios', 'finanzas::servicios')->name('servicios');
});
