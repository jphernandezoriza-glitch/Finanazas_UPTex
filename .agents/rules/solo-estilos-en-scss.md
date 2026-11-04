---
trigger: always_on
---

# Solo estilos en SCSS

Este proyecto usa SCSS como fuente principal de estilos.

## Reglas
- Crea y modifica estilos en archivos `.scss`.
- Prioriza la estructura existente dentro de `resources/scss`.
- Evita agregar archivos `.css` nuevos, salvo que el proyecto ya dependa explicitamente de uno existente y sea necesario tocarlo.
- Evita estilos inline en Blade, Livewire o componentes, excepto casos muy puntuales y justificados.
- Reutiliza variables, mixins, parciales y patrones existentes antes de crear nuevos estilos.

## Organizacion
- Si el cambio corresponde a una pagina, agregalo en el parcial de pagina adecuado.
- Si el cambio corresponde a un componente reutilizable, agregalo en `components`.
- Si el estilo es global, colocalo en la capa global correcta y no en una vista aislada.

## Objetivo
- Mantener consistencia visual.
- Evitar CSS disperso.
- Respetar la arquitectura SCSS ya presente en este workspace.