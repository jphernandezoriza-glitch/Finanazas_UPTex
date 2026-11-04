<?php

namespace Modules\Finanzas\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Finanzas\Enums\TipoPagoFinanzasEnum;
use Modules\Finanzas\Models\PagoAlumno;

/**
 * Referencia ejecutable del enlace académico-financiero. La referencia externa
 * queda única para impedir cargos duplicados cuando el origen reintenta el evento.
 */
final class GenerarObligacionExtraordinarioAction
{
    public function execute(int $alumnoId, string $referenciaOrigen, float $monto): PagoAlumno
    {
        return DB::transaction(fn (): PagoAlumno => PagoAlumno::firstOrCreate(
            ['referencia' => $referenciaOrigen],
            ['alumno_id' => $alumnoId, 'tipo' => TipoPagoFinanzasEnum::Extraordinario, 'monto' => $monto, 'estatus' => 'pendiente'],
        ));
    }
}
