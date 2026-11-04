{{-- Componente de tabla UPTex: aporta scroll horizontal institucional sin acoplarse a un modulo especifico. --}}
@props([
    'variant' => 'directory',
])

<div {{ $attributes->class(['admin-table-wrapper', 'uptex-table-scroll', 'uptex-table-scroll--'.$variant]) }}>
    {{ $slot }}
</div>
