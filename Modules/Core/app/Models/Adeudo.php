<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

/** Obligación sintética de sandbox, sin importar reglas financieras institucionales. */
class Adeudo extends Model
{
    protected $fillable = ['alumno_id', 'concepto', 'monto', 'pagado', 'bloquea_inscripcion'];
    protected function casts(): array { return ['monto' => 'decimal:2', 'pagado' => 'boolean', 'bloquea_inscripcion' => 'boolean']; }
}
