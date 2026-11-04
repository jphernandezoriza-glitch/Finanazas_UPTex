{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'title' => null,
    'useCustomBundle' => false,
    'includeLivewire' => true,
    'loadInterFont' => true,
    'loadFontAwesome' => true,
    'loadBaseStyles' => null,
    'loadBaseScript' => true,
])

@php
    $toBoolean = static fn (mixed $value): bool => filter_var(
        $value,
        FILTER_VALIDATE_BOOL,
        FILTER_NULL_ON_FAILURE,
    ) ?? (bool) $value;

    $useCustomBundle = $toBoolean($useCustomBundle);
    $includeLivewire = $toBoolean($includeLivewire);
    $loadInterFont = $toBoolean($loadInterFont);
    $loadFontAwesome = $toBoolean($loadFontAwesome);
    $loadBaseScript = $toBoolean($loadBaseScript);
    $shouldLoadBaseStyles = is_null($loadBaseStyles) ? ! $useCustomBundle : $toBoolean($loadBaseStyles);
    $shouldIncludeLivewire = $includeLivewire && ! request()->routeIs('home', 'public.*');
    $identity = app(\Modules\Core\Services\UniversityIdentityService::class);
    $universityShortName = $identity->shortName();
    $demoPalette = $identity->demoPalette();
    $demoFont = $identity->demoFont();
    $demoTableStyle = $identity->demoTableStyle();
    $systemName = $identity->systemName();
    $resolvedTitle = $title ?: (str_contains($systemName, $universityShortName) ? $systemName : $universityShortName.' '.$systemName);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-palette="{{ $demoPalette }}" data-font="{{ $demoFont }}" data-table-style="{{ $demoTableStyle }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $identity->description() }}">
    <meta name="keywords" content="{{ $identity->keywords() }}">
    @stack('meta')
    <link rel="icon" href="{{ asset($identity->faviconPath()) }}">
    <link rel="shortcut icon" href="{{ asset($identity->faviconPath()) }}">
    <link rel="apple-touch-icon" href="{{ asset($identity->logoPath()) }}">
    <link rel="manifest" href="{{ asset('build/manifest.webmanifest') }}">
    <meta name="theme-color" content="#0d6efd">

    <title>{{ $resolvedTitle }}</title>

    <script>
        (() => {
            const storageKey = 'uptex_theme';
            let theme = 'light';

            try {
                theme = window.localStorage.getItem(storageKey) === 'dark' ? 'dark' : 'light';
            } catch (error) {
                theme = 'light';
            }

            document.documentElement.dataset.theme = theme;
            document.documentElement.dataset.palette = @js($demoPalette);
            document.documentElement.dataset.font = @js($demoFont);
            document.documentElement.dataset.tableStyle = @js($demoTableStyle);
            document.documentElement.style.colorScheme = theme;
        })();

        document.addEventListener('demo-palette-updated', (event) => {
            const allowedPalettes = new Set(['original', 'azul', 'rojo', 'rosa', 'naranja', 'verde', 'morado', 'amarillo']);
            const palette = allowedPalettes.has(event.detail?.palette) ? event.detail.palette : 'original';

            document.documentElement.dataset.palette = palette;
        });

        document.addEventListener('demo-font-updated', (event) => {
            const allowedFonts = new Set(['inter', 'source', 'plex']);
            const font = allowedFonts.has(event.detail?.font) ? event.detail.font : 'inter';

            document.documentElement.dataset.font = font;
        });

        document.addEventListener('demo-table-style-updated', (event) => {
            const allowedTableStyles = new Set(['modern', 'content-fit']);
            const tableStyle = allowedTableStyles.has(event.detail?.tableStyle) ? event.detail.tableStyle : 'modern';

            document.documentElement.dataset.tableStyle = tableStyle;
        });
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if($loadInterFont)
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700;900&family=Inter:wght@400;500;600;700;900&family=Source+Sans+3:wght@400;500;600;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700;900&family=Inter:wght@400;500;600;700;900&family=Source+Sans+3:wght@400;500;600;700;900&display=swap" rel="stylesheet">
        </noscript>
    @endif

    @if($loadFontAwesome)
        <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        </noscript>
    @endif

    @if($shouldIncludeLivewire)
        @livewireStyles
    @endif

    @php
        $viteAssets = [];
        if ($shouldLoadBaseStyles) {
            $viteAssets[] = 'resources/scss/app.scss';
        }
        if ($loadBaseScript) {
            $viteAssets[] = 'resources/js/app.js';
        }

        $authUser = auth()->user();
        $notificationStorageKey = match (true) {
            request()->is('portal-administrativo*') => 'uptex_admin_notificaciones',
            request()->is('alumno*'), request()->is('portal-alumno*') => 'uptex_alumno_notificaciones',
            request()->is('docente*') => 'uptex_docente_notificaciones',
            default => 'uptex_notifications',
        };
        $realtimeContext = [
            'userId' => $authUser?->id,
            'isAuthenticated' => $authUser !== null,
            'canBypassMaintenance' => (bool) $authUser?->can(\Modules\Core\Enums\PermissionsEnum::ACCESO_SISTEMAS->value),
            'notificationStorageKey' => $notificationStorageKey,
        ];
    @endphp

    <script>
        window.UPTEX_REALTIME_CONTEXT = @js($realtimeContext);
    </script>

    @if(!empty($viteAssets))
        @vite($viteAssets)
    @endif

    @stack('styles')
</head>
<body>
    {{ $slot }}

    <x-ui.toast-center />
    <x-ui.alertas-operativas />

    @if($shouldIncludeLivewire)
        @livewireScripts
    @endif

    @stack('scripts')
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('{{ asset('build/sw.js') }}', { scope: '/' })
                    .catch(() => {});
            });
        }
    </script>
</body>
</html>
