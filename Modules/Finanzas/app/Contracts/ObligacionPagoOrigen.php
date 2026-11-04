<?php

namespace Modules\Finanzas\Contracts;

/**
 * Contrato que desacopla Finanzas de Admisiones, Reinscripciones y Regularizaciones.
 * Las implementaciones reales viven en el módulo owner; este sandbox aporta fakes.
 */
interface ObligacionPagoOrigen
{
    /** @return array<int, array{referencia:string, alumno_id:int, concepto:string, monto:float}> */
    public function pendientesParaAlumno(int $alumnoId): array;
}
