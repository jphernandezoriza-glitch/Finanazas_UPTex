{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'section' => null,
    'current' => null,
    'breadcrumbs' => [], // Array of ['label' => '...', 'url' => '...']
    // Keep this literal: Blade escapes HTML entities passed through props, so they render visibly wrong.
    'separator' => '>',
    'showNotifications' => true,
    'notificationsStorageKey' => 'uptex_notifications',
    'notificationsItems' => [],
    'showProfile' => true,
    'profileUser' => auth()->user(),
    'profileSubtitle' => '',
    'profileIdentifier' => '',
    'portalRole' => null,
])

@php
    $contextFromPath = function (string $path): ?array {
        $path = trim($path, '/');

        if (str_starts_with($path, 'portal-administrativo')) {
            return ['label' => 'Portal Administrativo', 'url' => route('portal-administrativo.index'), 'role' => 'administrativo'];
        }

        if (str_starts_with($path, 'portal-alumno')) {
            return ['label' => 'Portal Alumno', 'url' => route('portal-alumno.index'), 'role' => 'alumno'];
        }

        if (str_starts_with($path, 'alumno')) {
            return ['label' => 'Portal Alumno', 'url' => route('alumno.inicio'), 'role' => 'alumno'];
        }

        if (str_starts_with($path, 'docente')) {
            return ['label' => 'Portal Docente', 'url' => route('docente.inicio'), 'role' => 'docente'];
        }

        if (str_starts_with($path, 'egresado')) {
            return ['label' => 'Portal Egresado', 'url' => route('egresado.inicio'), 'role' => 'egresado'];
        }

        return null;
    };

    $contextFromRole = fn (?string $role): ?array => match (strtolower((string) $role)) {
        'administrativo', 'administrador' => ['label' => 'Portal Administrativo', 'url' => route('portal-administrativo.index'), 'role' => 'administrativo'],
        'alumno' => ['label' => 'Portal Alumno', 'url' => route('alumno.inicio'), 'role' => 'alumno'],
        'docente' => ['label' => 'Portal Docente', 'url' => route('docente.inicio'), 'role' => 'docente'],
        'egresado' => ['label' => 'Portal Egresado', 'url' => route('egresado.inicio'), 'role' => 'egresado'],
        default => null,
    };

    $requestPath = trim(request()->path(), '/');
    $portalContext = $contextFromPath($requestPath);

    if ($portalContext === null && str_starts_with($requestPath, 'livewire/')) {
        $refererPath = (string) parse_url((string) request()->headers->get('referer', ''), PHP_URL_PATH);
        $portalContext = $contextFromPath($refererPath);
    }

    $resolvedPortalMenuRole = $portalRole ? strtolower((string) $portalRole) : ($portalContext['role'] ?? null);

    if (! $resolvedPortalMenuRole && auth()->check()) {
        // Livewire puede re-renderizar este header desde /livewire/* sin ruta navegable;
        // este fallback mantiene visible el lanzador de menu segun el portal del usuario.
        $resolvedPortalMenuRole = app(\Modules\Core\Services\PortalContextService::class)->defaultContext(auth()->user());
    }

    $portalContext ??= $contextFromRole($resolvedPortalMenuRole);
    $portalLabel = $portalContext['label'] ?? '';
    $portalUrl = $portalContext['url'] ?? '';

    $hasNamedLeft = isset($left);
    $hasNamedRight = isset($right);
    $slotContent = trim((string) $slot);
    $navigationMode = app(\Modules\Core\Services\UniversityIdentityService::class)->demoNavigation();
    $usesMenuNavigation = $navigationMode === \Modules\Core\Services\PortalNavigationService::ModeMenu;
    $navigationBreadcrumbs = app(\Modules\Core\Services\PortalNavigationService::class)->breadcrumbsForCurrentRoute($resolvedPortalMenuRole);
    $headerClass = 'page-topbar portal-layout__header-bar';

    $usesLegacyMarkup = ! $hasNamedLeft
        && ! $hasNamedRight
        && $slotContent !== ''
        && (str_contains($slotContent, 'page-topbar__left') || str_contains($slotContent, 'page-topbar__breadcrumb'));
    $usesAutomaticBreadcrumbs = ! empty($navigationBreadcrumbs) && empty($breadcrumbs) && ! $section && ! $current;
    $legacyRight = null;

    if ($usesLegacyMarkup && preg_match('/<div class="page-topbar__right">\s*(?P<right>[\s\S]*)\s*<\/div>\s*$/', $slotContent, $legacyRightMatch) === 1) {
        $legacyRight = new \Illuminate\Support\HtmlString($legacyRightMatch['right']);
    }

    $displayBreadcrumbs = ! empty($breadcrumbs) ? $breadcrumbs : $navigationBreadcrumbs;

    if (empty($displayBreadcrumbs) && $section) {
        $displayBreadcrumbs[$section] = null;
    } elseif ($section && $current && ! array_key_exists($section, $displayBreadcrumbs)) {
        $displayBreadcrumbs[$section] = null;
    }

    if ($portalLabel && ! array_key_exists($portalLabel, $displayBreadcrumbs)) {
        $displayBreadcrumbs = array_merge([$portalLabel => $portalUrl], $displayBreadcrumbs);
    }

    if ($current && ! array_key_exists($current, $displayBreadcrumbs)) {
        $displayBreadcrumbs[$current] = null;
    }
@endphp

<header {{ $attributes->merge(['class' => $headerClass]) }}>
    @if($usesLegacyMarkup && empty($navigationBreadcrumbs))
        {!! $slot !!}
    @else
        <div class="page-topbar__left">
            @if($hasNamedLeft && ! $usesAutomaticBreadcrumbs)
                {{ $left }}
            @else
                <div class="page-topbar__vertical-divider"></div>
                <div class="page-topbar__breadcrumb">
                    @if(!empty($displayBreadcrumbs))
                        @foreach($displayBreadcrumbs as $label => $url)
                            @php
                                $isCurrent = $label === $current || ($current === null && $loop->last);
                            @endphp
                            @if($url && ! $isCurrent)
                                <a href="{{ $url }}" wire:navigate>{{ $label }}</a>
                            @else
                                <span class="{{ $isCurrent ? 'active' : '' }}">{{ $label }}</span>
                            @endif
                            @unless($loop->last)
                                <span>{{ $separator }}</span>
                            @endunless
                        @endforeach
                    @else
                        {{ $section }}
                        @if ($current)
                            <span>{{ $separator }}</span>
                            <span class="active">{{ $current }}</span>
                        @endif
                    @endif
                </div>
            @endif
        </div>

        <div class="page-topbar__right">
            @isset($right)
                @php
                    $rightContent = (string) $right;
                    $rightHasNotifications = str_contains($rightContent, 'topbar-notifications')
                        || str_contains($rightContent, 'portal-header-actions')
                        || str_contains($rightContent, 'ui-notifications');
                @endphp
                @if ($showNotifications && ! $rightHasNotifications)
                    <x-ui.topbar-notifications :storage-key="$notificationsStorageKey" :items="$notificationsItems" />
                @endif
                {{ $right }}
                @if($usesMenuNavigation)
                    <x-layouts.portal-menu-launcher :role="$resolvedPortalMenuRole" />
                @endif
            @else
                @if($legacyRight)
                    {!! $legacyRight !!}
                    @if($usesMenuNavigation)
                        <x-layouts.portal-menu-launcher :role="$resolvedPortalMenuRole" />
                    @endif
                @elseif ($usesLegacyMarkup)
                    @if($usesMenuNavigation)
                        <x-layouts.portal-menu-launcher :role="$resolvedPortalMenuRole" />
                    @endif
                @else
                @if ($showNotifications || $showProfile)
                    <x-ui.portal-header-actions
                        :storage-key="$notificationsStorageKey"
                        :items="$notificationsItems"
                        :show-notifications="$showNotifications"
                        :show-profile="$showProfile"
                        :user="$profileUser"
                        :subtitle="$profileSubtitle"
                        :identifier="$profileIdentifier"
                    />
                    @if($usesMenuNavigation)
                        <x-layouts.portal-menu-launcher :role="$resolvedPortalMenuRole" />
                    @endif
                @endif
                @endif
            @endisset
        </div>
    @endif
</header>
