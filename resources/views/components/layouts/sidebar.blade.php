{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'role' => null,
])

@php
    $user = Auth::user();
    $identity = app(\Modules\Core\Services\UniversityIdentityService::class);
    $navigation = app(\Modules\Core\Services\PortalNavigationService::class)->forUser($user, $role);
    $userRole = $navigation['role'];
    $menuSections = $navigation['sections'];
    $portalSwitchItems = $navigation['portalSwitchItems'];
@endphp

<aside class="sidebar" :class="{ 'sidebar--open': mobileMenuOpen, 'sidebar--collapsed': sidebarCollapsed }">
    <div class="sidebar__top">
        <div class="sidebar__brand" id="sidebarToggle" title="Colapsar o expandir menu" @click="toggleSidebarCollapse()">
            <div class="sidebar__logo">
                <span>{{ $user?->portalBadge() ?? 'U' }}</span>
            </div>
            <div class="sidebar__brand-text sidebar__brand-text--centered">
                <div class="sidebar__title">{{ $identity->shortName() }}</div>
                <div class="sidebar__subtitle">{{ $userRole ? strtoupper($userRole) : 'INVITADO' }}</div>
            </div>
        </div>

        <nav class="sidebar__nav">
            @foreach($menuSections as $section)
                @if(!empty($section['title']))
                    @php
                        $sectionHasActiveItem = collect($section['items'])->contains(fn ($item) => $item['active']);
                    @endphp
                    <div class="sidebar__group"
                         x-data="{ open: {{ $sectionHasActiveItem ? 'true' : 'false' }} }"
                         :class="{ 'sidebar__group--open': open, 'sidebar__group--active': {{ $sectionHasActiveItem ? 'true' : 'false' }} }">
                        <button type="button"
                                class="sidebar__group-header"
                                title="{{ $section['title'] }}"
                                @click="if (sidebarCollapsed) { sidebarCollapsed = false; open = true; } else { open = !open; }">
                            @if(!empty($section['icon']))
                                <span class="sidebar__group-icon">
                                    <span class="icon icon--{{ $section['icon'] }}"></span>
                                </span>
                            @endif
                            <span class="sidebar__group-title">{{ $section['title'] }}</span>
                            <span class="sidebar__group-toggle" aria-hidden="true">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M8 10L12 14L16 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </button>
                        <div class="sidebar__group-content" x-show="open && !sidebarCollapsed" x-cloak>
                            @foreach($section['items'] as $item)
                                <a href="{{ $item['href'] }}" wire:navigate class="sidebar__item {{ $item['active'] ? 'sidebar__item--active' : '' }}" title="{{ $item['label'] }}">
                                    <span class="sidebar__item-icon">
                                        <span class="icon icon--{{ $item['icon'] }}"></span>
                                    </span>
                                    <span class="sidebar__item-label">{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                        <div class="sidebar__group-flyout" x-cloak>
                            <div class="sidebar__group-flyout-title">{{ $section['title'] }}</div>
                            <div class="sidebar__group-flyout-list">
                                @foreach($section['items'] as $item)
                                    <a href="{{ $item['href'] }}" wire:navigate class="sidebar__item {{ $item['active'] ? 'sidebar__item--active' : '' }}" title="{{ $item['label'] }}">
                                        <span class="sidebar__item-icon">
                                            <span class="icon icon--{{ $item['icon'] }}"></span>
                                        </span>
                                        <span class="sidebar__item-label">{{ $item['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    @foreach($section['items'] as $item)
                        <a href="{{ $item['href'] }}" wire:navigate class="sidebar__item {{ $item['active'] ? 'sidebar__item--active' : '' }}" title="{{ $item['label'] }}">
                            <span class="sidebar__item-icon">
                                <span class="icon icon--{{ $item['icon'] }}"></span>
                            </span>
                            <span class="sidebar__item-label">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                @endif
            @endforeach
        </nav>
    </div>

    <div class="sidebar__bottom">
        @if(count($portalSwitchItems) > 1)
            <div class="sidebar__group sidebar__group--open">
                <button type="button" class="sidebar__group-header sidebar__group-header--static" title="Cambiar portal" tabindex="-1" aria-disabled="true">
                    <span class="sidebar__group-icon"><span class="icon icon--acciones-v"></span></span>
                    <span class="sidebar__group-title">Cambiar portal</span>
                </button>
                <div class="sidebar__group-content">
                    @foreach($portalSwitchItems as $item)
                        <a href="{{ $item['href'] }}" wire:navigate class="sidebar__item {{ $item['active'] ? 'sidebar__item--active' : '' }}" title="{{ $item['label'] }}">
                            <span class="sidebar__item-icon">
                                <span class="icon icon--{{ $item['icon'] }}"></span>
                            </span>
                            <span class="sidebar__item-label">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="sidebar__user">
            <div class="profile-avatar__circle sidebar__user-avatar">
                @auth
                    @php($profilePhotoUrl = Auth::user()->portalProfilePhotoUrl())
                    @if($profilePhotoUrl)
                        <img src="{{ $profilePhotoUrl }}" alt="Foto de perfil de {{ Auth::user()->shortName() }}">
                    @else
                        {{ Auth::user()->portalBadge() }}
                    @endif
                @else
                    U
                @endauth
            </div>
            <div>
                <div class="sidebar__user-name">
                    @auth
                        {{ Auth::user()->shortName() }}
                    @else
                        Invitado
                    @endauth
                </div>
                <div class="sidebar__user-role">
                    @auth
                        {{ Auth::user()->roles->first()?->name ?? 'Usuario' }}
                    @endauth
                </div>
            </div>
        </div>

        @livewire('auth-logout-button')
    </div>
</aside>
