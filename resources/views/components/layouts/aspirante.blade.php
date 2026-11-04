{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
<x-layouts.master>

<div class="app aspirante-layout" id="mainApp"
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
        $watch('sidebarCollapsed', val => {
            if (! isMobile) {
                localStorage.setItem('sidebarCollapsed', val);
            }
        });
     "
     @resize.window="syncMobileState()"
     :class="{ 'app--collapsed': sidebarCollapsed && !isMobile }">

    <div class="sidebar-overlay" id="sidebarOverlay"
         :class="{ 'sidebar-overlay--active': mobileMenuOpen }"
         x-show="mobileMenuOpen"
         x-cloak
         @click="mobileMenuOpen = false"></div>

    <x-layouts.sidebar role="aspirante" />

    <main class="app__content">
        <div class="mobile-header">
            <button class="mobile-header__btn" id="mobileMenuBtn" @click="mobileMenuOpen = true" aria-label="Abrir menu lateral">
                ☰
            </button>
            <div class="mobile-header__title">Portal Aspirante</div>
        </div>

        <div class="page-topbar">
            <div class="page-topbar__left">
                <div class="page-topbar__vertical-divider"></div>
                <div class="page-topbar__breadcrumb">
                    Portal Aspirante <span>></span> <span class="active">{{ $title ?? 'Inicio' }}</span>
                </div>
            </div>

            <div class="page-topbar__right">
                <div class="page-topbar__profile profile-avatar">
                    <div class="profile-avatar__circle">
                        {{ Auth::user()->initials() }}
                    </div>
                    <div class="info">
                        <span class="name">{{ Auth::user()->name }}</span>
                        <span class="id">Aspirante</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="portal-content aspirante-portal-content">
            {{ $slot }}
        </div>

        <footer class="app__footer">
            <p>© {{ date('Y') }} {{ app(\Modules\Core\Services\UniversityIdentityService::class)->footer() }}</p>
        </footer>
    </main>

</div>

</x-layouts.master>
