@props([
    'storageKey' => null,
])

@php
    // Cada portal mantiene su propio scope local para no mezclar toasts diferidos
    // de alumno/docente/administrativo cuando el mismo usuario cambia de portal.
    $resolvedStorageKey = $storageKey
        ?: (request()->is('portal-administrativo*')
            ? 'uptex_admin_notificaciones'
            : ((request()->is('alumno*') || request()->is('portal-alumno*'))
                ? 'uptex_alumno_notificaciones'
                : (request()->is('docente*')
                    ? 'uptex_docente_notificaciones'
                    : 'uptex_notifications')));

    // Los flash messages legacy se convierten a toast flotante para que cualquier
    // redirect del sistema use la misma experiencia visual.
    $flashMessages = array_values(array_filter([
        session()->has('success') ? [
            'title' => 'Operacion completada',
            'message' => session('success'),
            'level' => 'success',
        ] : null,
        session()->has('error') ? [
            'title' => 'Se detecto un problema',
            'message' => session('error'),
            'level' => 'error',
        ] : null,
        session()->has('message') ? [
            'title' => 'Aviso del sistema',
            'message' => session('message'),
            'level' => 'info',
        ] : null,
        session()->has('warning') ? [
            'title' => 'Atencion',
            'message' => session('warning'),
            'level' => 'warning',
        ] : null,
        session()->has('info') ? [
            'title' => 'Aviso del sistema',
            'message' => session('info'),
            'level' => 'info',
        ] : null,
        session()->has('status') ? [
            'title' => 'Aviso del sistema',
            'message' => session('status'),
            'level' => 'info',
        ] : null,
    ]));
@endphp

{{-- Centro global de toasts: escucha universidad:toast y los mensajes normalizados desde WebSockets. --}}
<div
    x-data="toastCenter({ storageKey: @js($resolvedStorageKey), flashMessages: @js($flashMessages) })"
    x-init="init()"
    class="ui-toast-center"
    aria-live="polite"
    aria-atomic="true"
>
    <template x-for="toast in toasts" :key="toast.id">
        <article class="ui-toast" :data-level="toast.level" :class="{ 'is-visible': toast.visible }">
            <div class="ui-toast__body">
                <strong x-text="toast.title"></strong>
                <p x-text="toast.message"></p>
                <span x-text="toast.date"></span>
            </div>
            <button type="button" class="ui-toast__close" x-on:click="dismiss(toast.id)" aria-label="Cerrar notificacion">x</button>
            <div class="ui-toast__progress">
                <span :style="`animation-duration:${toast.timeout}ms`"></span>
            </div>
        </article>
    </template>
</div>
