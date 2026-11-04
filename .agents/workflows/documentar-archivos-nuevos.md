---
description: DOCUMENTAR ARCHIVOS NUEVOS
---

# Documentar archivos nuevos

Usa este workflow al crear migraciones, modelos, controladores, servicios, Livewire, rutas, vistas, SCSS, JS, seeders, jobs, eventos, comandos o configuraciones.

## Pasos

1. Lista los archivos nuevos o movidos antes de cerrar la tarea.
2. Para cada archivo, identifica su tipo y responsabilidad dentro del modulo.
3. Agrega comentarios utiles en espanol:
   - proposito del archivo;
   - contrato de metodos publicos o acciones y como transforman datos;
   - datos inyectados en vistas, plantillas llamadas y bindings Livewire/Alpine;
   - eventos, permisos, transacciones o efectos laterales;
   - decisiones no obvias, calculos relevantes o compatibilidad legacy.
4. Evita comentarios redundantes que repitan el nombre de variables o instrucciones evidentes.
5. Si el archivo cambia comportamiento visible, actualiza el documento vivo mas cercano en `docs/`.
6. Ejecuta validacion minima:
   - PHP: `vendor/bin/pint --dirty --format agent` y test/filtro relevante.
   - SCSS/JS: `pnpm run build` y guardia visual si existe.
   - Rutas/datos: test de feature o comando de inspeccion correspondiente.

## Criterio de aceptacion

La tarea no se considera cerrada si hay archivos productivos nuevos sin comentarios utiles o si la documentacion viva queda desactualizada frente al comportamiento implementado.
