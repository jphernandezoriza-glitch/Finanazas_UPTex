{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'title' => null,
    'admisionActiva' => false,
    'reinscripcionActiva' => false,
    'heroImage' => null,
    'includeLivewire' => false,
    'db_error' => false,
])

@php
    $identity = app(\Modules\Core\Services\UniversityIdentityService::class);
    $universityName = $identity->name();
    $universityShortName = $identity->shortName();
    $logoPath = $identity->logoPath();
    $footerText = $identity->footer();
    $contacto = $identity->contact();
    $contactEmail = $contacto['correo'];
    $footerSocialLinks = $identity->footerSocialLinks();
    $isDemoMode = $identity->demoEnabled();
@endphp

<x-layouts.master
    :use-custom-bundle="true"
    :title="$title"
    :include-livewire="$includeLivewire"
    :load-base-script="false"
    :load-inter-font="false"
    :load-font-awesome="false"
>
    @push('styles')
        @vite(['resources/scss/public-bundle.scss'])
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Alexandria:wght@400;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@400;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        </noscript>
        <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        </noscript>
    @endpush

    @push('scripts')
        @vite(['resources/js/public.js'])
    @endpush

    @push('meta')
        <meta name="description" content="Portal institucional de {{ $universityName }}. Consulta oferta academica, calendario escolar, noticias y procesos de admision.">
        <meta name="keywords" content="{{ $universityShortName }}, {{ $universityName }}, oferta academica, admision, calendario escolar, educacion superior">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $title ?? $universityShortName }} - {{ $universityName }}">
        <meta property="og:description" content="Innovacion y excelencia tecnologica para el desarrollo integral de nuestra comunidad academica.">
        <meta property="og:image" content="{{ asset($logoPath) }}">
    @endpush

    <div class="uptex-public {{ $isDemoMode ? 'uptex-public--demo' : '' }}">
        @if(session('database_failure') || request()->has('db_failure') || ($db_error ?? false))
            <div class="limited-service-banner">
                <div class="container">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>Ha ocurrido un error; el servicio se encuentra temporalmente limitado.</span>
                </div>
            </div>
        @endif

        <nav class="public-nav"
             x-data="{ mobileMenu: false }"
             :class="{ 'is-open': mobileMenu }"
             x-init="$watch('mobileMenu', value => document.body.classList.toggle('public-menu-open', value))">
            <div class="public-nav__logo-wrapper">
                <a href="{{ route('home') }}" class="public-nav__logo">
                    <img src="{{ asset($logoPath) }}" alt="{{ $universityShortName }} Logo" width="1033" height="679" decoding="async">
                </a>
            </div>

            <button class="public-nav__toggle"
                    x-on:click="mobileMenu = !mobileMenu"
                    aria-label="Toggle menu"
                    :aria-expanded="mobileMenu ? 'true' : 'false'">
                <i class="fas" :class="mobileMenu ? 'fa-xmark' : 'fa-bars'"></i>
            </button>

            <div class="public-nav__menu" :class="{ 'active': mobileMenu }">
                <div class="public-nav__links">
                    <a href="{{ route('home') }}">Inicio</a>
                    <a href="{{ route('public.programas') }}">Oferta Academica</a>
                    <a href="{{ route('public.calendario') }}">Calendario Escolar</a>

                    @if($admisionActiva ?? false)
                        <a href="{{ route('public.convocatoria') }}">Convocatoria</a>
                    @endif

                    @if($reinscripcionActiva ?? false)
                        <a href="{{ route('public.reinscripcion') }}">Reinscripcion</a>
                    @endif

                    <a href="{{ route('public.noticias') }}">Noticias</a>
                    <a href="{{ route('public.contacto') }}">Contacto</a>
                </div>

                <div class="public-nav__actions">
                    <x-ui.theme-toggle />
                    @auth
                        @php($redirectService = app(\Modules\Auth\Services\RedirectService::class))
                        <a href="{{ $redirectService->getRedirectPath(Auth::user()) }}" class="btn-portal btn-portal--active">Ir a mi Portal</a>
                    @else
                        <a href="{{ url('/login') }}" class="btn-portal">Acceso Portal</a>
                    @endauth
                </div>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>

        <footer class="public-footer">
            <div class="footer-grid">
                <div class="footer-section">
                    <img src="{{ asset($logoPath) }}" alt="{{ $universityShortName }} Logo" class="footer-logo" width="260" height="171" loading="lazy" decoding="async">
                    <p class="footer-text">{{ $identity->footerDescription() }}</p>
                </div>

                <div class="footer-section">
                    <h2 class="footer-title">Contacto</h2>
                    <ul class="footer-list">
                        <li><i class="fas fa-map-marker-alt"></i> {{ $contacto['direccion'] }}</li>
                        <li><i class="fas fa-phone"></i> {{ $contacto['telefono'] }}</li>
                        <li><i class="fas fa-envelope"></i> <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h2 class="footer-title">Enlaces Rapidos</h2>
                    <ul class="footer-list">
                        <li><a href="{{ route('public.programas') }}">Oferta Academica</a></li>
                        <li><a href="{{ route('public.calendario') }}">Calendario Escolar</a></li>
                        <li><a href="{{ route('public.sitemap') }}">Mapa del Sitio</a></li>
                        <li><a href="{{ route('public.sitemap.xml') }}">Sitemap XML</a></li>
                        <li><a href="#">Acerca del Sitio</a></li>
                        <li><a href="#">Legales</a></li>
                        <li><a href="{{ route('public.contacto') }}">Contactanos</a></li>
                        <li><a href="#">Aviso de Privacidad</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h2 class="footer-title">Redes Sociales</h2>
                    @if($footerSocialLinks !== [])
                        <div class="footer-social">
                            @foreach($footerSocialLinks as $socialLink)
                                <a href="{{ $socialLink['url'] }}" class="social-link" title="{{ $socialLink['label'] }}" aria-label="{{ $socialLink['label'] }}" target="_blank" rel="noopener noreferrer">
                                    <span class="icon icon--{{ $socialLink['icon'] }} social-icon" aria-hidden="true"></span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="footer-bottom">
                <p>© {{ date('Y') }} {{ $footerText }}</p>
            </div>
        </footer>
    </div>
</x-layouts.master>
