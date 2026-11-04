---
description: IMPLEMENTAR CAMBIO CON VERIFICACION
---

# Implementar cambio con verificacion

Usa este workflow para nuevas funciones, ajustes visuales, mejoras o cambios de comportamiento.

## Pasos
1. Comprende el objetivo exacto.
2. Revisa `docs/arquitectura/mapa-ownership-modular.md` para confirmar ownership antes de editar.
3. Lee los archivos y patrones directamente relacionados.
4. Implementa solo lo necesario para resolver la tarea.
5. Evita cambios colaterales no solicitados.
6. Ejecuta la verificacion minima relevante.
7. Si moviste archivos o cambiaste ownership, actualiza el mapa modular.
8. Entrega con un resumen breve de lo que cambiaste y como lo validaste.

## Alcance obligatorio en cambios modulares
- Verifica impacto en: servicios, vistas, estilos, Livewire, modelos, migraciones, seeders, rutas y tests.
- Si solo se corrigen imports pero hay capas relacionadas sin revisar, el cambio se considera incompleto.

## Verificacion
- Prefiere validaciones pequenas y precisas.
- Si una verificacion no puede ejecutarse, indicalo claramente.
- Para refactor modular: incluye al menos un test/ruta del flujo movido y build de frontend si se tocaron assets.
