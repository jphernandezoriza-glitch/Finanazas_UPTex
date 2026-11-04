{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'model' => 'search',
    'placeholder' => 'Buscar...',
    'debounce' => '350ms',
    'clearAction' => null,
])

@php
    $inputId = $attributes->get('id', 'search-'.$model);
@endphp

<div {{ $attributes->except('id')->merge(['class' => 'ui-search-bar']) }}>
    <svg class="ui-search-bar__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
    <input
        id="{{ $inputId }}"
        name="{{ $model }}"
        type="search"
        wire:model.live.debounce.{{ $debounce }}="{{ $model }}"
        placeholder="{{ $placeholder }}"
        class="ui-search-bar__input"
    >
    @if($clearAction)
        <button type="button" class="ui-search-bar__clear" wire:click="{{ $clearAction }}" aria-label="Limpiar busqueda">x</button>
    @endif
</div>
