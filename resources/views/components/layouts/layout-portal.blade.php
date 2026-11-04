{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'role',
    'useCustomBundle' => false,
    'footerText' => null,
])

@php
    $identity = app(\Modules\Core\Services\UniversityIdentityService::class);
    $footerText ??= '(c) '.date('Y').' '.$identity->footer();
    $navigationMode = $identity->demoNavigation();
    $usesSidebarNavigation = $navigationMode === \Modules\Core\Services\PortalNavigationService::ModeSidebar;
    $usesTopNavigation = $navigationMode === \Modules\Core\Services\PortalNavigationService::ModeTopbar;
    $usesMenuNavigation = $navigationMode === \Modules\Core\Services\PortalNavigationService::ModeMenu;
@endphp

<x-layouts.master :use-custom-bundle="$useCustomBundle">
    <div class="app portal-layout" id="mainPortalApp"
         data-nav-mode="{{ $navigationMode }}"
         x-data="{
            sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
            mobileMenuOpen: false,
            isMobile: window.matchMedia('(max-width: 768px)').matches,
            syncMobileState() {
                this.isMobile = window.matchMedia('(max-width: 768px)').matches;

                if (this.isMobile) {
                    this.sidebarCollapsed = false;
                }
            },
            toggleSidebarCollapse() {
                if (this.isMobile) {
                    this.sidebarCollapsed = false;

                    return;
                }

                this.sidebarCollapsed = ! this.sidebarCollapsed;
            }
         }"
         x-init="
            syncMobileState();
            $watch('sidebarCollapsed', value => {
                if (! isMobile) {
                    localStorage.setItem('sidebarCollapsed', value);
                }
            });
         "
         @resize.window="syncMobileState()"
         :class="{ 'app--collapsed': sidebarCollapsed && !isMobile && {{ $usesSidebarNavigation ? 'true' : 'false' }} }">

        @if($usesSidebarNavigation)
            <div class="sidebar-overlay" id="sidebarOverlay"
                 :class="{ 'sidebar-overlay--active': mobileMenuOpen }"
                 x-show="mobileMenuOpen"
                 x-cloak
                 @click="mobileMenuOpen = false"></div>

            <x-layouts.sidebar :role="$role" />
        @endif

        <main class="app__content portal-layout__content">
            @if($usesTopNavigation)
                <x-layouts.portal-top-nav :role="$role" />
            @endif

            <div class="mobile-header">
                @if($usesSidebarNavigation)
                    <button class="mobile-header__btn" id="mobileMenuBtn" @click="mobileMenuOpen = true" aria-label="Abrir menu lateral">
                        ☰
                    </button>
                @endif
                <div class="mobile-header__title">{{ $identity->shortName() }}</div>
            </div>

            @isset($header)
                <div class="portal-layout__header">
                    {{ $header }}
                </div>
            @endisset

            <div class="portal-layout__body">
                {{ $slot }}
            </div>

            <footer class="app__footer">
                <p>{{ $footerText }}</p>
            </footer>
        </main>

        {{-- Componente transversal: solo renderiza la burbuja en portales internos soportados. --}}
        @auth
            @livewire('core.reportar-problema-sistema')
        @endauth
    </div>

    @if (Auth::check() && Auth::user()->requiresPasswordChange())
        @livewire('auth.force-password-change')
    @endif

    <script>
        document.addEventListener('livewire:navigated', () => {
            if (!window.Alpine) {
                return;
            }

            const app = document.getElementById('mainPortalApp');
            if (!app) {
                return;
            }

            const data = window.Alpine.$data(app);
            if (data) {
                data.mobileMenuOpen = false;
            }
        });
    </script>
</x-layouts.master>
