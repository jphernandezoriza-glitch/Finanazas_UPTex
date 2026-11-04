{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'role' => null,
])

@php
    $navigation = app(\Modules\Core\Services\PortalNavigationService::class);
    $menuUrl = $navigation->menuUrlForRole($role);
@endphp

@if($menuUrl)
    <a href="{{ $menuUrl }}" wire:navigate class="portal-menu-launcher" aria-label="Abrir menu de vistas" title="Menu de vistas">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <circle cx="5" cy="5" r="1.8"></circle>
            <circle cx="12" cy="5" r="1.8"></circle>
            <circle cx="19" cy="5" r="1.8"></circle>
            <circle cx="5" cy="12" r="1.8"></circle>
            <circle cx="12" cy="12" r="1.8"></circle>
            <circle cx="19" cy="12" r="1.8"></circle>
            <circle cx="5" cy="19" r="1.8"></circle>
            <circle cx="12" cy="19" r="1.8"></circle>
            <circle cx="19" cy="19" r="1.8"></circle>
        </svg>
    </a>
@endif
