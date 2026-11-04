{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'user' => auth()->user(),
    'subtitle' => '',
    'identifier' => '',
])

@php
    $photoUrl = $user?->portalProfilePhotoUrl();
@endphp

<div class="page-topbar__profile profile-avatar" x-data="{ open: false }">
    <button type="button" class="page-topbar__profile-trigger profile-avatar__trigger" @click="open = !open">
        @if($photoUrl)
            <img src="{{ $photoUrl }}" alt="Foto de perfil" class="profile-avatar__circle">
        @else
            <div class="profile-avatar__circle">{{ $user?->portalBadge() ?? 'U' }}</div>
        @endif
        <div class="info">
            <span class="name">{{ $user?->shortName() ?? 'Usuario' }}</span>
            <span class="id">{{ $identifier ?: $subtitle }}</span>
        </div>
    </button>

    <div x-cloak x-show="open" @click.away="open = false" class="profile-avatar__menu">
        <div class="profile-avatar__menu-head">
            @if($photoUrl)
                <img src="{{ $photoUrl }}" alt="Foto de perfil" class="profile-avatar__circle">
            @else
                <div class="profile-avatar__circle">{{ $user?->portalBadge() ?? 'U' }}</div>
            @endif
            <div>
                <div class="profile-avatar__menu-name">{{ $user?->name }}</div>
                <div class="profile-avatar__menu-subtitle">{{ $subtitle }}</div>
            </div>
        </div>
        <div class="profile-avatar__menu-meta">
            @if($identifier)
                <div><strong>Referencia:</strong> {{ $identifier }}</div>
            @endif
            <div><strong>Correo:</strong> {{ $user?->email }}</div>
        </div>
    </div>
</div>
