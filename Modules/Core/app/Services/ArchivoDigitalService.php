<?php

namespace Modules\Core\Services;

/** Contrato local para asociar digitalizaciones al expediente del alumno. */
class ArchivoDigitalService { public function registrar(int $alumnoId, string $path, string $categoria): array { return compact('alumnoId', 'path', 'categoria'); } }
