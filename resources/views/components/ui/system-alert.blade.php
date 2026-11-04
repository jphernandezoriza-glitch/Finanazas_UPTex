{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'type' => 'info',
    'title' => null,
    'icon' => null,
])

@php
    $level = in_array($type, ['success', 'warning', 'danger', 'error', 'info', 'neutral'], true) ? $type : 'info';
    $level = $level === 'error' ? 'danger' : $level;
@endphp

<div {{ $attributes->merge(['class' => "ui-system-alert ui-system-alert--{$level}"]) }} role="alert">
    @if($icon)
        <span class="icon {{ $icon }} ui-system-alert__icon" aria-hidden="true"></span>
    @endif
    <div class="ui-system-alert__body">
        @if($title)
            <strong>{{ $title }}</strong>
        @endif
        <div>{{ $slot }}</div>
    </div>
</div>
