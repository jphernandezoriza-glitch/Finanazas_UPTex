<?php

use Modules\Finanzas\Services\VerificadorPagoLocal;

test('el verificador local nunca realiza llamadas externas', function (): void {
    expect((new VerificadorPagoLocal)->verificar('SAN-001')['verificado'])->toBeTrue()
        ->and((new VerificadorPagoLocal)->verificar('REAL-001')['verificado'])->toBeFalse();
});
