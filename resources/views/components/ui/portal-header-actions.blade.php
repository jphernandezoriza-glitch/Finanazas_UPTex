{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'user' => auth()->user(),
    'subtitle' => '',
    'identifier' => '',
    'storageKey' => null,
    'items' => [],
    'showNotifications' => true,
    'showProfile' => true,
])

<div class="portal-header-actions">
    @if(trim((string) $slot) !== '')
        <div class="portal-header-actions__search">
            {{ $slot }}
        </div>
    @endif

    @isset($tools)
        <div class="portal-header-actions__tools">
            {{ $tools }}
        </div>
    @endisset

    @if($showNotifications)
        <x-ui.topbar-notifications :storage-key="$storageKey" :items="$items" />
    @endif

    @if($showProfile)
        <x-ui.topbar-profile :user="$user" :subtitle="$subtitle" :identifier="$identifier" />
    @endif
</div>
