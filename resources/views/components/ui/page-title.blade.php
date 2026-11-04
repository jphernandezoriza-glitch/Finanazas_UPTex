{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'title',
    'subtitle' => null,
    'eyebrow' => null,
])

<section {{ $attributes->merge(['class' => 'ui-page-title']) }}>
    <div class="ui-page-title__copy">
        @if($eyebrow)
            <span class="ui-page-title__eyebrow">{{ $eyebrow }}</span>
        @endif
        <h1>{{ $title }}</h1>
        @if($subtitle)
            <p>{{ $subtitle }}</p>
        @endif
    </div>

    @if(trim((string) $slot) !== '')
        <div class="ui-page-title__actions">
            {{ $slot }}
        </div>
    @endif
</section>
