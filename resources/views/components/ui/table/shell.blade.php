{{-- Componente de tabla UPTex: enmarca titulo, descripcion, conteo y contenido de una tabla reutilizable. --}}
@props([
    'variant' => 'directory',
    'title' => null,
    'description' => null,
    'count' => null,
    'countLabel' => 'registros',
])

<section {{ $attributes->class(['admin-table-card', 'uptex-table-card', 'uptex-table-card--'.$variant]) }}>
    @if(isset($header))
        {{ $header }}
    @elseif($title || $description || ! is_null($count))
        <div class="admin-table-card__header uptex-table-card__header">
            <div>
                @if($title)
                    <h2>{{ $title }}</h2>
                @endif
                @if($description)
                    <p>{{ $description }}</p>
                @endif
            </div>

            @if(! is_null($count))
                <span class="admin-table-card__badge admin-pill admin-pill--neutral">
                    {{ $count }} {{ $countLabel }}
                </span>
            @endif
        </div>
    @endif

    {{ $slot }}
</section>
