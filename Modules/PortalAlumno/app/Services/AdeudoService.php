<?php

namespace Modules\PortalAlumno\Services;

use Modules\Core\Models\Adeudo;

/** Servicio persistente de sandbox compatible con los consumidores de no adeudo del monolito. */
class AdeudoService
{
    public function crearAdeudo(int $alumnoId, string $concepto, float $monto, bool $bloqueaInscripcion = true): Adeudo { return Adeudo::create(['alumno_id' => $alumnoId, 'concepto' => $concepto, 'monto' => $monto, 'bloquea_inscripcion' => $bloqueaInscripcion]); }
    public function tieneAdeudosPendientes(int $alumnoId): bool { return Adeudo::query()->where('alumno_id', $alumnoId)->where('pagado', false)->exists(); }
    public function tieneAdeudosBloqueantes(int $alumnoId): bool { return Adeudo::query()->where('alumno_id', $alumnoId)->where('pagado', false)->where('bloquea_inscripcion', true)->exists(); }
}
