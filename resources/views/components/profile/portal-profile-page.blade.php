{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'shellClass' => 'admin-view',
    'contentClass' => 'admin-content',
    'homeLabel' => 'Portal',
    'homeUrl' => '#',
    'portalSubtitle' => '',
    'storageKey' => null,
    'eyebrow' => 'Perfil institucional',
    'title' => auth()->user()?->name,
    'meta' => '',
    'fotoPerfil' => null,
])

<div class="{{ $shellClass }} portal-profile-page">
    <x-layouts.portal-header
        :breadcrumbs="[
            $homeLabel => $homeUrl,
            'Mi Perfil' => null,
        ]"
    >
        <x-slot:right>
            <x-ui.portal-header-actions :user="auth()->user()" :subtitle="$portalSubtitle" :storage-key="$storageKey" />
        </x-slot:right>
    </x-layouts.portal-header>

    <div class="{{ $contentClass }} portal-profile-page__content">
        <section class="portal-profile-hero">
            <div class="portal-profile-hero__identity">
                @if(auth()->user()->portalProfilePhotoUrl())
                    <img src="{{ auth()->user()->portalProfilePhotoUrl() }}" alt="Foto de perfil">
                @else
                    <div class="portal-profile-hero__avatar">{{ auth()->user()->portalBadge() }}</div>
                @endif
                <div>
                    <span>{{ $eyebrow }}</span>
                    <h1>{{ $title }}</h1>
                    <p>{{ $meta ?: (auth()->user()->email ?? 'Sin correo registrado') }}</p>
                </div>
            </div>
            <span class="portal-profile-hero__badge">{{ $portalSubtitle ?: 'Usuario' }}</span>
        </section>

        <div class="portal-profile-grid">
            <section class="portal-profile-card">
                <div class="portal-profile-card__header">
                    <h2>Foto de perfil</h2>
                    <p>Esta fotografía se mostrará en los portales institucionales.</p>
                </div>
                <form wire:submit.prevent="actualizarFotoPerfil" class="portal-profile-form">
                    <label class="portal-profile-form__label" for="portal-foto-perfil">Nueva fotografía</label>
                    <div class="portal-profile-file">
                        <input
                            id="portal-foto-perfil"
                            class="portal-profile-file__input"
                            type="file"
                            wire:model="fotoPerfil"
                            accept="image/jpeg,image/png,image/webp"
                        >
                        <label class="portal-profile-file__button" for="portal-foto-perfil">
                            <span class="icon icon--documento"></span>
                            <span>Seleccionar archivo</span>
                        </label>
                        <span class="portal-profile-file__name">
                            {{ $fotoPerfil ? $fotoPerfil->getClientOriginalName() : 'JPG, PNG o WEBP hasta 2 MB' }}
                        </span>
                    </div>
                    @error('fotoPerfil') <span class="error-msg">{{ $message }}</span> @enderror
                    <button type="submit" class="admin-btn admin-btn--primary" wire:loading.attr="disabled" wire:target="fotoPerfil,actualizarFotoPerfil">
                        Actualizar foto
                    </button>
                </form>
            </section>

            <section class="portal-profile-card">
                <div class="portal-profile-card__header">
                    <h2>Cambio de contraseña</h2>
                    <p>Usa una contraseña con mayúsculas, minúsculas y números.</p>
                </div>
                <form wire:submit.prevent="cambiarPassword" class="portal-profile-form">
                    <label class="portal-profile-form__label" for="portal-password">Nueva contraseña</label>
                    <input id="portal-password" type="password" wire:model="password" autocomplete="new-password">
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror

                    <label class="portal-profile-form__label" for="portal-password-confirmation">Confirmar contraseña</label>
                    <input id="portal-password-confirmation" type="password" wire:model="password_confirmation" autocomplete="new-password">

                    <button type="submit" class="admin-btn admin-btn--primary">Cambiar contraseña</button>
                </form>
            </section>
        </div>

        @if(trim((string) $slot) !== '')
            {{-- Slot extensible: cada portal puede agregar bloques propios sin duplicar la pantalla base de perfil. --}}
            {{ $slot }}
        @endif
    </div>
</div>
