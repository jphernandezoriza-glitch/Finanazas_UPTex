@props([
    'role' => null,
])

@php
    $identity = app(\Modules\Core\Services\UniversityIdentityService::class);
    $navigationService = app(\Modules\Core\Services\PortalNavigationService::class);
    $navigation = $navigationService->forUser(Auth::user(), $role, switchToMenuRoutes: true);
    $sections = $navigation['sections'];
    $portalSwitchItems = $navigation['portalSwitchItems'];
    $roleLabel = match ($navigation['role']) {
        'administrativo', 'administrador' => 'Portal Administrativo',
        'docente' => 'Portal Docente',
        'alumno' => 'Portal Alumno',
        default => 'Portal Institucional',
    };
@endphp

{{-- Hub demo: pantalla de entrada cuando la navegacion configurada es "menu"; las cards salen del mismo servicio que sidebar/topbar. --}}
<section class="portal-menu-hub" aria-labelledby="portal-menu-hub-title">
    <div class="portal-menu-hub__hero">
        <div>
            <span class="portal-menu-hub__eyebrow">{{ $identity->shortName() }}</span>
            <h1 id="portal-menu-hub-title">{{ $roleLabel }}</h1>
            <p>Selecciona una vista para continuar con tus actividades del sistema.</p>
        </div>
        <div class="portal-menu-hub__hero-actions">
            <div class="portal-menu-hub__badge">
                <span class="icon icon--lista"></span>
                Menu de vistas
            </div>
            @livewire('auth-logout-button', ['variant' => 'menu'])
        </div>
    </div>

    <div class="portal-menu-hub__sections">
        @foreach($sections as $section)
            {{-- Cada seccion representa un grupo jerarquico del portal y respeta permisos/modulos demo. --}}
            <section class="portal-menu-hub__section" aria-labelledby="portal-menu-section-{{ $loop->index }}">
                <div class="portal-menu-hub__section-header">
                    <span class="portal-menu-hub__section-icon">
                        <span class="icon icon--{{ $section['icon'] ?? ($section['items'][0]['icon'] ?? 'lista') }}"></span>
                    </span>
                    <h2 id="portal-menu-section-{{ $loop->index }}">{{ $section['title'] ?? 'Principal' }}</h2>
                </div>
                <div class="portal-menu-hub__grid">
                    @foreach($section['items'] as $item)
                        <a href="{{ $item['href'] }}" wire:navigate class="portal-menu-card {{ $item['active'] ? 'is-active' : '' }}">
                            <span class="portal-menu-card__icon">
                                <span class="icon icon--{{ $item['icon'] }}"></span>
                            </span>
                            <span class="portal-menu-card__copy">
                                <strong>{{ $item['label'] }}</strong>
                                <small>{{ $section['title'] ?? $roleLabel }}</small>
                            </span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach

        @if(count($portalSwitchItems) > 1)
            {{-- Cambiar portal solo se muestra cuando PortalContextService confirma mas de un acceso disponible. --}}
            <section class="portal-menu-hub__section" aria-labelledby="portal-menu-switch-title">
                <div class="portal-menu-hub__section-header">
                    <span class="portal-menu-hub__section-icon">
                        <span class="icon icon--acciones-v"></span>
                    </span>
                    <h2 id="portal-menu-switch-title">Cambiar portal</h2>
                </div>
                <div class="portal-menu-hub__grid portal-menu-hub__grid--switch">
                    @foreach($portalSwitchItems as $item)
                        <a href="{{ $item['href'] }}" wire:navigate class="portal-menu-card portal-menu-card--switch {{ $item['active'] ? 'is-active' : '' }}">
                            <span class="portal-menu-card__icon">
                                <span class="icon icon--{{ $item['icon'] }}"></span>
                            </span>
                            <span class="portal-menu-card__copy">
                                <strong>{{ $item['label'] }}</strong>
                                <small>Entrar a este portal</small>
                            </span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</section>
