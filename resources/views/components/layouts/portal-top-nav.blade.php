@props([
    'role' => null,
])

@php
    $navigation = app(\Modules\Core\Services\PortalNavigationService::class)->forUser(Auth::user(), $role);
    $sections = $navigation['sections'];
    $portalSwitchItems = $navigation['portalSwitchItems'];
@endphp

{{-- Topbar demo: usa el mismo mapa canonico que sidebar/menu para conservar permisos, grupos y rutas activas. --}}
<nav class="portal-top-nav" aria-label="Navegacion principal del portal">
    <div class="portal-top-nav__brand">
        <span class="portal-top-nav__mark">{{ Auth::user()?->portalBadge() ?? 'U' }}</span>
        <span>{{ strtoupper($navigation['role'] ?: (string) $role) }}</span>
    </div>

    <div class="portal-top-nav__scroller">
        @foreach($sections as $section)
            @php
                $hasTitle = ! empty($section['title']);
                $sectionIcon = $section['icon'] ?? ($section['items'][0]['icon'] ?? 'lista');
                $sectionHasActiveItem = collect($section['items'])->contains(fn ($item) => $item['active']);
            @endphp

            @if($hasTitle)
                {{-- Los grupos se abren por hover/focus en CSS; no requieren estado Alpine ni click persistente. --}}
                <div class="portal-top-nav__group {{ $sectionHasActiveItem ? 'is-active' : '' }}">
                    <button type="button" class="portal-top-nav__group-trigger" aria-label="{{ $section['title'] }}">
                        <span class="icon icon--{{ $sectionIcon }}"></span>
                    </button>
                    <div class="portal-top-nav__flyout">
                        <div class="portal-top-nav__flyout-title">{{ $section['title'] }}</div>
                        @foreach($section['items'] as $item)
                            <a href="{{ $item['href'] }}" wire:navigate class="portal-top-nav__flyout-item {{ $item['active'] ? 'is-active' : '' }}">
                                <span class="icon icon--{{ $item['icon'] }}"></span>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                @foreach($section['items'] as $item)
                    {{-- Las entradas directas conservan label flotante porque no tienen titulo de flyout. --}}
                    <a href="{{ $item['href'] }}" wire:navigate class="portal-top-nav__item {{ $item['active'] ? 'is-active' : '' }}" aria-label="{{ $item['label'] }}">
                        <span class="icon icon--{{ $item['icon'] }}"></span>
                        <span class="portal-top-nav__tooltip">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            @endif
        @endforeach
    </div>

    <div class="portal-top-nav__actions">
        @if(count($portalSwitchItems) > 1)
            <div class="portal-top-nav__group portal-top-nav__group--switch">
                <button type="button" class="portal-top-nav__group-trigger" aria-label="Cambiar portal">
                    <span class="icon icon--acciones-v"></span>
                </button>
                <div class="portal-top-nav__flyout portal-top-nav__flyout--right">
                    <div class="portal-top-nav__flyout-title">Cambiar portal</div>
                    @foreach($portalSwitchItems as $item)
                        <a href="{{ $item['href'] }}" wire:navigate class="portal-top-nav__flyout-item {{ $item['active'] ? 'is-active' : '' }}">
                            <span class="icon icon--{{ $item['icon'] }}"></span>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @livewire('auth-logout-button', ['variant' => 'topbar'])
    </div>
</nav>
