<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Tablas mínimas del contrato financiero, aisladas de tablas académicas institucionales. */
return new class extends Migration {
    public function up(): void {
        Schema::create('finanzas_conceptos_pago', function (Blueprint $table): void { $table->id(); $table->string('nombre'); $table->string('tipo')->index(); $table->decimal('monto', 10, 2); $table->boolean('activo')->default(true); $table->timestamps(); });
        Schema::create('finanzas_pagos_alumno', function (Blueprint $table): void { $table->id(); $table->foreignId('alumno_id')->constrained('alumnos')->cascadeOnDelete(); $table->string('tipo')->index(); $table->decimal('monto', 10, 2); $table->string('referencia')->unique(); $table->string('estatus')->default('pendiente')->index(); $table->timestamps(); });
        Schema::create('finanzas_pago_comprobantes', function (Blueprint $table): void { $table->id(); $table->foreignId('pago_id')->constrained('finanzas_pagos_alumno')->cascadeOnDelete(); $table->string('path'); $table->string('mime_type'); $table->timestamps(); });
        Schema::create('finanzas_pago_validaciones', function (Blueprint $table): void { $table->id(); $table->foreignId('pago_id')->constrained('finanzas_pagos_alumno')->cascadeOnDelete(); $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); $table->string('estatus'); $table->text('comentario')->nullable(); $table->timestamps(); });
    }
    public function down(): void { Schema::dropIfExists('finanzas_pago_validaciones'); Schema::dropIfExists('finanzas_pago_comprobantes'); Schema::dropIfExists('finanzas_pagos_alumno'); Schema::dropIfExists('finanzas_conceptos_pago'); }
};
