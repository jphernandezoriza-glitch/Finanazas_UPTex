---
description: CAMBIAR MODULO LARAVEL
---

# Cambiar modulo Laravel

Usa este workflow cuando la tarea afecte un modulo de este sistema.

## Pasos
1. Revisa primero `docs/arquitectura/mapa-ownership-modular.md`.
2. Identifica el modulo responsable del cambio.
3. Revisa capas completas relacionadas: migraciones, seeders, modelos, servicios, controladores, middleware, requests, Livewire, vistas Blade, estilos/assets, rutas y tests.
4. Confirma como se conecta ese modulo con otros antes de editar.
5. Implementa el cambio dentro del modulo correcto.
6. Evita mover logica a otros modulos si no es necesario.
7. Verifica el flujo mas cercano al modulo afectado.
8. Si cambias ownership o mueves archivos, actualiza el mapa modular en el mismo cambio.
9. Resume el impacto funcional y tecnico del cambio.

## Regla de integridad modular
- No se considera finalizado un cambio modular si solo mueve controladores.
- Debe quedar cerrada la trazabilidad completa de ownership en todas las capas impactadas.

## Objetivo
- Mantener cohesion modular.
- Evitar cambios dispersos.
- Respetar la arquitectura del sistema.
