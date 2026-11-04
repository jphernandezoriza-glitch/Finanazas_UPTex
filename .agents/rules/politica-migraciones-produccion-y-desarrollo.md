---
trigger: always_on
---

# Politica de migraciones en Produccion y Desarrollo

Esta regla define los limites estrictos para la ejecucion de comandos de migracion de Laravel (`php artisan migrate*`) segun el entorno de ejecucion.

## Entorno de Produccion (`APP_ENV=production`)

1. **`php artisan migrate:fresh` prohibido para el agente:**
   - Queda ESTRICTAMENTE PROHIBIDO que el agente ejecute o proponga `php artisan migrate:fresh`, `migrate:refresh`, `migrate:reset` o `db:wipe` en produccion.
   - Solo el usuario (administrador/humano) tiene la facultad exclusiva de ejecutar `php artisan migrate:fresh` de manera manual si fuera absolutamente necesario.
2. **`php artisan migrate` condicionado:**
   - En produccion solo se permite `php artisan migrate` en caso de **nuevas tablas o migraciones acumulativas** (creacion de nuevos esquemas o columnas sin alterar/eliminar datos existentes).
   - Siempre se debe informar y solicitar confirmacion previa del usuario explicando que solo se crearan las nuevas estructuras.

## Entorno de Desarrollo (`APP_ENV=local` / `testing` / `development`)

1. **Base Principal (`DB_CONNECTION` / por defecto):**
   - **`php artisan migrate` permitido:** Únicamente para incorporar nuevas migraciones, nuevas tablas o columnas incrementales.
   - **`migrate:fresh`, `--seed` y destructivos PROHIBIDOS:** Queda prohibido ejecutar `php artisan migrate:fresh`, `migrate:refresh`, `migrate:reset`, `db:wipe` o comandos con `--seed` sobre la base principal.
2. **Base Especializada de QA (`qa_database`):**
   - Para pruebas de desarrollo, verificación de seeders y escenarios (`MiniAdmision`, `EvaluacionMini`, etc.), se debe usar exclusivamente la base QA.
   - Se permite ejecutar `migrate:fresh` y `db:seed` siempre que se incluya obligatoriamente el flag `--database=qa_database`.

## Resumen de Permisos de Migración y Seeders

| Comando | Base Principal (Desarrollo / Prod) | Base QA (`--database=qa_database`) |
| :--- | :--- | :--- |
| `php artisan migrate` | **Permitido** (solo para nuevas tablas/columnas acumulativas) | **Permitido** |
| `php artisan migrate:fresh` | **PROHIBIDO** | **Permitido** (para resetear escenarios de prueba) |
| `php artisan migrate:rollback` | **Prohibido** sin revisión previa y aprobación | **Permitido** |
| `php artisan db:seed` | **PROHIBIDO** (no contaminar base principal con pruebas) | **Permitido** (para poblar escenarios QA) |

