{{-- Accion iconografica para filas de tabla: centraliza aria-label/title/tooltip y deja que Livewire, Alpine o enlaces pasen sus atributos sin acoplar el componente a un modulo. --}}
@props([
    'href' => null,
    'icon' => 'ver',
    'label',
    'ariaLabel' => null,
    'variant' => 'neutral',
    'type' => 'button',
    'disabled' => false,
])

@php
    $normalizedIcon = preg_replace('/^icon--/', '', $icon);
    $resolvedAriaLabel = $ariaLabel ?: $label;
    $classes = [
        'admin-table-action',
        'admin-table-action--'.$variant,
        'is-disabled' => $disabled,
    ];
@endphp

@if($href)
    <a
        href="{{ $disabled ? '#' : $href }}"
        title="{{ $label }}"
        data-admin-table-action-label="{{ $label }}"
        aria-label="{{ $resolvedAriaLabel }}"
        @if($disabled) aria-disabled="true" tabindex="-1" @endif
        {{ $attributes->class($classes) }}
    >
        <span class="icon icon--{{ $normalizedIcon }}" aria-hidden="true"></span>
        <span class="admin-table-action__tooltip">{{ $label }}</span>
    </a>
@else
    <button
        type="{{ $type }}"
        title="{{ $label }}"
        data-admin-table-action-label="{{ $label }}"
        aria-label="{{ $resolvedAriaLabel }}"
        @disabled($disabled)
        {{ $attributes->class($classes) }}
    >
        <span class="icon icon--{{ $normalizedIcon }}" aria-hidden="true"></span>
        <span class="admin-table-action__tooltip">{{ $label }}</span>
    </button>
@endif
