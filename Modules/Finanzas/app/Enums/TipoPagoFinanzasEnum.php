<?php

namespace Modules\Finanzas\Enums;

/** Catálogo estable de conceptos iniciales; el equipo puede ampliarlo con aprobación funcional. */
enum TipoPagoFinanzasEnum: string
{
    case Reinscripcion = 'reinscripcion';
    case Admision = 'admision';
    case Credencial = 'credencial';
    case Casillero = 'casillero';
    case Estacionamiento = 'estacionamiento';
    case Curso = 'curso';
    case Extraordinario = 'extraordinario';
    case Constancia = 'constancia';
    case Otro = 'otro';
}
