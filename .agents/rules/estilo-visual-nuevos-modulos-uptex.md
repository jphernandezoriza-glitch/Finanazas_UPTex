---
trigger: always_on
---

# Estilo visual para nuevos modulos UPTex

Esta regla define la referencia visual que debe seguir cualquier agente al crear o modificar modulos, vistas, componentes Blade, pantallas Livewire, tablas, formularios, dashboards o experiencias publicas del sistema UPTex.

## Preflight visual obligatorio

- Revisa primero un modulo similar con `rg` antes de crear clases nuevas.
- Aplica siempre `.agents/rules/solo-estilos-en-scss.md` y `.agents/workflows/ajustar-interfaz-con-scss.md`.
- Identifica el bundle SCSS que realmente renderiza la pantalla antes de agregar imports.
- Reutiliza componentes, tokens, mixins, parciales y patrones existentes antes de crear variantes nuevas.
- Si un componente transversal se usa en varios portales, importa su SCSS en cada bundle que lo renderiza.

## Fuentes de verdad

- Usa `resources/scss/abstract/_variables.scss` como fuente principal de tokens CSS, colores, superficies, texto, estados, tablas e inputs.
- Usa `resources/scss/abstract/_mixins.scss` para `flex-center`, `flex-between`, `transition-default`, `card-base`, `kpi-bottom-accent`, `tablet` y `mobile`.
- Usa `resources/scss/components/_ui-primitives.scss` solo como agregador de primitivas compartidas; no concentres ahi estilos productivos nuevos.
- Usa los parciales especificos de cada portal o modulo para reglas visuales de pagina.

## Tokens y color

- Prioriza tokens CSS con `var(--...)`; no agregues colores hex, rgb o hsl directos fuera de `resources/scss/abstract/_variables.scss`.
- Evita fallbacks visuales como `var(--token, #123456)` porque ocultan deuda visual y rompen los guardrails de color.
- Usa tokens base como `--brand-primary`, `--brand-secondary`, `--brand-accent`, `--primary`, `--primary-soft`, `--primary-ring`, `--primary-shadow`, `--surface`, `--surface-soft`, `--surface-raised`, `--panel-surface`, `--background`, `--text`, `--text-muted`, `--border`, `--border-soft` y `--border-strong`.
- Para tablas e inputs, usa `--table-surface`, `--table-header-bg`, `--table-row-hover`, `--table-row-muted`, `--input-surface`, `--input-border` y `--input-focus`.
- Para estados, usa `--success`, `--warning`, `--danger`, `--info` y los tokens `--feedback-*`.
- Para modulos y tarjetas, usa `--module-accent`, `--card-accent`, `--icon-accent` y `--icon-accent-soft`.
- Si necesitas transparencia, prefiere tokens RGB existentes como `--primary-rgb`, `--brand-primary-rgb`, `--success-rgb`, `--warning-rgb`, `--danger-rgb` o `--info-rgb`.
- Si un color nuevo es inevitable, agregalo como token en `_variables.scss`, considera dark mode y paletas, y crea companion RGB si se usara con alpha.

## Tipografia y ritmo visual

- Usa las familias existentes: `--font-family`, `--font-body` y `--font-mono`.
- No agregues fuentes nuevas ni escalas tipograficas globales sin necesidad real.
- Mantiene espaciado, sombras, bordes y radios cerca de los patrones existentes; usa radios grandes solo para pills, avatares o controles circulares.
- Evita interfaces dominadas por una sola familia de color; apoya jerarquia con superficie, borde, texto, estado y acentos del sistema.

## Clases y componentes reutilizables

- En vistas administrativas, estructura con `.admin-view`, `.admin-content`, `.admin-header`, `.admin-header__info` y `.admin-header__actions`.
- Usa `x-layouts.portal-header` para encabezados internos y breadcrumbs cuando la vista pertenezca a un portal.
- Usa `x-ui.portal-header-actions` para acciones de cabecera, busqueda, perfil y notificaciones.
- Para KPIs y modulos administrativos, usa `.admin-kpis`, `.admin-kpi`, `.admin-module`, `--kpi-accent` y `--module-accent`.
- Para tablas administrativas, usa `.admin-table-card`, `.admin-table-wrapper`, `.admin-tbl`, `.admin-tbl__actions`, `.admin-row-actions` y `.admin-table-actions`.
- Para acciones por fila, usa `x-ui.table-action` con icono, tooltip, `aria-label`, `title` y variante semantica; evita botones de texto cuando una accion icon-only sea suficiente.
- Para celdas densas, usa helpers existentes como `.td-name`, `.td-sub`, `.td-mono`, `.td-bold`, `.admin-user-cell`, `.admin-muted` y bloques internos legibles.
- Para filtros, busquedas y controles, reutiliza `.admin-filters`, `.admin-input`, `.admin-btn`, `.ui-search-bar` y componentes Blade existentes antes de crear markup nuevo.

## Tablas, responsive y datos densos

- Las tablas de escritorio deben vivir dentro de `.admin-table-wrapper`, `.uptex-scroll-x`, `.responsive-scroll-x` o el wrapper existente del portal.
- Define anchos minimos razonables por tabla cuando haya muchas columnas; no fuerces que todo quepa aplastando texto o acciones.
- Alinea contenido tabular con `vertical-align: top` cuando haya comentarios, folios, claves, fechas o bloques multiliena.
- Mantiene acciones compactas para que no deformen filas.
- Usa `.mobile-table-carousel` solo cuando la informacion pueda convertirse en tarjetas moviles claras; conserva la tabla fuente marcada conforme al patron existente.
- Si agregas una nueva primitiva responsive, actualiza o agrega cobertura en `ResponsiveVisualSourceGuardTest`.

## Arquitectura SCSS

- Global/tokens/mixins: `resources/scss/abstract`.
- Componentes compartidos: `resources/scss/components`.
- Layout global: `resources/scss/layout`.
- Portal Administrativo: crea parciales en `Modules/PortalAdministrativo/resources/assets/scss/pages/_<modulo>.scss` o `Modules/PortalAdministrativo/resources/assets/scss/components/_<componente>.scss`, e importalos desde `admin-dashboard.scss`.
- Portal Docente: crea el parcial del feature en `Modules/PortalDocente/resources/assets/scss/` e importalo desde `docente-dashboard.scss`; reutiliza estilos administrativos ya importados cuando aplique.
- Portal Alumno, Core y Public: coloca el parcial en el modulo que renderiza la vista e importalo desde el bundle real, como `resources/scss/app.scss` o `resources/scss/public-bundle.scss`.
- Modulos funcionales como Calificaciones, Reinscripciones, Becas, Reportes o Titulacion deben mantener sus estilos cerca del modulo y solo promover primitivas a `resources/scss/components` cuando sean realmente transversales.
- Usa `@use`; no introduzcas `@import`.
- No edites archivos generados en `public/build` manualmente.

## Nombres y estructura de selectores

- Usa nombres kebab-case y estilo BEM: `.modulo-feature`, `.modulo-feature__elemento`, `.modulo-feature--modificador`.
- Respeta prefijos existentes: `.admin-*`, `.portal-*`, `.docente-*`, `.student-*`, `.mobile-table-carousel-*`.
- Mantiene nesting bajo y legible; evita cadenas profundas o selectores acoplados a demasiados ancestros.
- Usa `&__elemento` y `&--modificador` solo cuando pertenezcan al bloque local.
- No crees clases genericas nuevas como `.card`, `.button`, `.table` o `.container` si ya existen primitivas del sistema.

## Dark mode, accesibilidad y estados

- Diseña primero con tokens para que dark mode funcione automaticamente.
- Si un ajuste oscuro es necesario, colocalo en el mismo parcial bajo `html[data-theme='dark']`.
- Cubre hover, focus-visible, disabled, loading, empty state, errores y estados de exito cuando el flujo lo requiera.
- Mantiene contraste suficiente y no comuniques informacion solo con color.
- Usa iconos y texto accesible en acciones compactas; los tests pueden validar `aria-label`, `title`, `data-admin-table-action-label` o `.admin-table-actions` en vez de texto visible.

## Documentacion y comentarios

- Si creas un archivo productivo nuevo, aplica `.agents/rules/comentarios-obligatorios-en-archivos-nuevos.md`.
- En SCSS nuevo, comenta proposito del parcial, contrato visual del bloque, responsive, dark mode y excepciones no obvias.
- Si cambia UI, rutas, navegacion, procesos o comportamiento visible, actualiza la documentacion viva en `docs/` y la bitacora correspondiente del modulo.

## Verificacion antes de cerrar

- Para cambios SCSS o assets, ejecuta `pnpm run build`.
- Para guardrails visuales, ejecuta `php artisan test --compact --filter=ResponsiveVisualSourceGuard` y `php artisan test --compact --filter=ScssColorTokenGuard`.
- Si cambias PHP, Blade o Livewire, ejecuta la prueba feature puntual del flujo afectado y `vendor/bin/pint --dirty --format agent`.
- Si agregas rutas, menus o breadcrumbs, verifica con `php artisan route:list --except-vendor` filtrando por el nombre relevante.
