<?php

namespace Modules\Finanzas\Services;

use Modules\Finanzas\Contracts\VerificadorPagoExterno;

/** Implementación determinista exclusiva del sandbox para probar el contrato sin red. */
final class VerificadorPagoLocal implements VerificadorPagoExterno
{
    public function verificar(string $referencia): array
    {
        return ['verificado' => str_starts_with($referencia, 'SAN-'), 'referencia' => $referencia, 'mensaje' => 'Resultado local de sandbox'];
    }
}
