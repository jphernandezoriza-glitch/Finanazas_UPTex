{{-- Componente de tabla UPTex: aplica clases base y variantes sin imponer columnas ni datos. --}}
@props([
    'variant' => 'directory',
    'mobileCarousel' => true,
])

<table {{ $attributes->class([
    'admin-tbl',
    'uptex-table',
    'uptex-table--'.$variant,
    'mobile-table-source--has-carousel' => $mobileCarousel,
]) }}>
    {{ $slot }}
</table>
