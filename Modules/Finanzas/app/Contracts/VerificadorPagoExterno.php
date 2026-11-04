<?php

namespace Modules\Finanzas\Contracts;

/** Contrato aislado para un proveedor futuro; no acepta ni expone secretos de proveedor. */
interface VerificadorPagoExterno
{
    /** @return array{verificado:bool, referencia:string, mensaje:string} */
    public function verificar(string $referencia): array;
}
