<?php

namespace Modules\Finanzas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Models\Alumno;
use Modules\Finanzas\Enums\TipoPagoFinanzasEnum;

/** Obligación o pago genérico; las transiciones institucionales se implementan fuera del starter. */
class PagoAlumno extends Model
{
    protected $table = 'finanzas_pagos_alumno';
    protected $fillable = ['alumno_id', 'tipo', 'monto', 'referencia', 'estatus'];
    protected function casts(): array { return ['tipo' => TipoPagoFinanzasEnum::class, 'monto' => 'decimal:2']; }
    public function alumno(): BelongsTo { return $this->belongsTo(Alumno::class); }
}
