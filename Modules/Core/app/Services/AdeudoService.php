<?php

namespace Modules\Core\Services;

/** Servicio sanitizado: contrato de adeudos usado por Finanzas y Biblioteca. */
class AdeudoService
{
    /** Registra una obligación de prueba; al integrar se reemplaza por el servicio institucional. */
    public function crearAdeudo(int $alumnoId, string $concepto, float $monto, bool $bloqueaInscripcion = true): array
    {
        return compact('alumnoId', 'concepto', 'monto', 'bloqueaInscripcion');
    }
}
