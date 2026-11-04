# Integración de Finanzas

Base: monolito UPTex, módulos `Core`, `PortalAdministrativo`, `PortalAlumno` y `Finanzas` habilitado.

1. Copiar `Modules/Finanzas` completo.
2. Ejecutar `php artisan module:enable Finanzas --no-interaction`.
3. Revisar y aplicar `monolito.patch`; solo agrega permisos, navegación y el import SCSS.
4. Ejecutar migraciones y las pruebas del módulo en una base QA; nunca en producción sin revisión.

El soporte `Auth`, `Core` y portales de este ZIP es exclusivamente de sandbox y no se copia.
