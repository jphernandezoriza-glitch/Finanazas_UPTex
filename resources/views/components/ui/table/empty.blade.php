{{-- Componente de tabla UPTex: estado vacio consistente para filas sin resultados. --}}
@props([
    'colspan' => 1,
    'message' => 'No hay registros para mostrar.',
])

<tr>
    <td colspan="{{ $colspan }}">
        <div class="admin-empty uptex-table__empty">
            <p>{{ $message }}</p>
        </div>
    </td>
</tr>
