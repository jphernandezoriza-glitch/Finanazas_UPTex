---
trigger: always_on
---

# Comentarios obligatorios en archivos nuevos

Todo archivo productivo nuevo debe incluir comentarios utiles en espanol desde su primera version.

## Regla general

- Comenta proposito, responsabilidad, contrato de entrada/salida, efectos laterales, dependencias tecnicas y decisiones no obvias.
- Explica como funciona el fragmento relevante cuando coordina calculos, consultas, eventos, permisos, transacciones o renderizado.
- No comentes operaciones evidentes como asignaciones simples, imports o propiedades cuyo nombre ya explique todo.
- Si el archivo nace como parte de un modulo, indica el rol del archivo dentro del flujo del modulo.
- Si el archivo emite eventos, toca permisos, persiste datos, lee configuracion o coordina servicios, documenta ese efecto.

## Por tipo de archivo

- Migraciones: explica tabla, columnas de negocio, indices, llaves foraneas y si hay decisiones irreversibles.
- Modelos: documenta entidad, relaciones principales, casts relevantes y scopes que afecten reglas academicas.
- Controladores: documenta responsabilidad HTTP y delegacion hacia servicios o Livewire.
- Rutas: comenta grupos, middleware, prefijos, permisos y rutas no navegables.
- Servicios/actions: usa DocBlocks en metodos publicos y comentarios de bloque para transacciones, imports, exports, calculos, cache, notificaciones o dependencias entre servicios.
- Livewire: comenta estado publico complejo, acciones principales, listeners, eventos `dispatch` y relacion con la vista.
- Blade: agrega comentarios `{{-- ... --}}` para datos inyectados, slots, componentes incluidos, bloques condicionales y bindings Livewire/Alpine importantes.
- SCSS: comenta tokens, secciones de componente, responsive, dark mode y excepciones visuales.
- JS: comenta eventos globales, integracion realtime, almacenamiento local/sessionStorage y helpers compartidos.
- Seeders/factories: documenta escenario que construyen y supuestos de datos.

## Cierre de tarea

Antes de entregar una implementacion con archivos nuevos, verifica que cada archivo nuevo tenga comentarios utiles y que la documentacion viva en `docs/` se actualice si cambia comportamiento, rutas, datos, UI o procesos.
