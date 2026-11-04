{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'role',
    'useCustomBundle' => false,
    'footerText' => null,
])

@php
    $footerText ??= '© '.date('Y').' '.app(\Modules\Core\Services\UniversityIdentityService::class)->footer();
@endphp

<x-layouts.layout-portal :role="$role" :footer-text="$footerText" :use-custom-bundle="$useCustomBundle">
    {{ $slot }}
</x-layouts.layout-portal>
