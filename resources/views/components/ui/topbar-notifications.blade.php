{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'storageKey' => null,
    'items' => [],
])

@php
    $resolvedStorageKey = $storageKey
        ?: (request()->is('portal-administrativo*')
            ? 'uptex_admin_notificaciones'
            : ((request()->is('alumno*') || request()->is('portal-alumno*'))
                ? 'uptex_alumno_notificaciones'
                : (request()->is('docente*')
                    ? 'uptex_docente_notificaciones'
                    : 'uptex_notifications')));
    $databaseItems = auth()->check()
        ? auth()->user()
            ->notificacionesInstitucionales()
            ->latest()
            ->limit(25)
            ->get()
            ->map->toRealtimePayload()
            ->values()
            ->all()
        : [];
    $seedItems = array_values(array_merge($databaseItems, $items));
    $inboxUrl = auth()->check() ? route('notificaciones-institucionales.index') : null;
    $readAllUrl = auth()->check() ? route('notificaciones-institucionales.read-all') : null;
    $clearUrl = auth()->check() ? route('notificaciones-institucionales.clear') : null;
    $trashUrl = auth()->check() ? route('notificaciones-institucionales.trash') : null;
    $readUrlTemplate = auth()->check() ? url('notificaciones-institucionales/__ID__/leer') : null;
    $restoreUrlTemplate = auth()->check() ? url('notificaciones-institucionales/__ID__/restaurar') : null;
@endphp

<div
    x-data="notificationCenter({
        storageKey: @js($resolvedStorageKey),
        seed: @js($seedItems),
        inboxUrl: @js($inboxUrl),
        readUrlTemplate: @js($readUrlTemplate),
        readAllUrl: @js($readAllUrl),
        clearUrl: @js($clearUrl),
        trashUrl: @js($trashUrl),
        restoreUrlTemplate: @js($restoreUrlTemplate)
    })"
    class="ui-notifications"
>
    <button type="button" class="page-topbar__bell ui-notifications__trigger" @click="open = !open" :aria-expanded="open.toString()">
        <span class="icon icon--notificacion icon--slate"></span>
        <span class="dot" x-show="unreadCount > 0"></span>
    </button>

    <div x-cloak x-show="open" @click.away="open = false" class="ui-notifications__panel">
        <div class="ui-notifications__header">
            <div>
                <h4 x-text="view === 'trash' ? 'Papelera' : 'Notificaciones'"></h4>
                <span x-show="view === 'active'" x-text="`${unreadCount} sin leer · ${items.length} registradas`"></span>
                <span x-show="view === 'trash'" x-text="`${trashItems.length} en papelera · 30 dias de retencion`"></span>
            </div>
            <div class="ui-notifications__actions">
                <button type="button" class="ui-notifications__clear" @click="markAllRead()" x-show="view === 'active' && items.length > 0">Marcar leidas</button>
                <button type="button" class="ui-notifications__clear ui-notifications__clear--danger" @click="clearNotifications()" x-show="view === 'active' && items.length > 0">Limpiar notificaciones</button>
            </div>
        </div>

        <div class="ui-notifications__tabs">
            <button type="button" :class="{ 'is-active': view === 'active' }" @click="showActive()">
                <span class="icon icon--notificacion" aria-hidden="true"></span>
                <span>Notificaciones</span>
            </button>
            <button type="button" :class="{ 'is-active': view === 'trash' }" @click="showTrash()">
                <span class="icon icon--eliminar" aria-hidden="true"></span>
                <span>Papelera</span>
            </button>
        </div>

        <template x-if="view === 'active' && items.length === 0">
            <div class="ui-notifications__empty">No hay alertas registradas por ahora.</div>
        </template>

        <div class="ui-notifications__list" x-show="view === 'active' && items.length > 0" x-ref="list">
            <template x-for="item in items" :key="item.id">
                <article class="ui-notifications__item" :data-level="item.level" :class="{ 'is-read': item.read_at }" @click="markRead(item)">
                    <div class="ui-notifications__item-title" x-text="item.title"></div>
                    <div class="ui-notifications__item-message" x-text="item.message"></div>
                    <div class="ui-notifications__item-date" x-text="item.date"></div>
                </article>
            </template>
        </div>

        <template x-if="view === 'trash' && trashItems.length === 0">
            <div class="ui-notifications__empty">La papelera esta vacia.</div>
        </template>

        <div class="ui-notifications__retention" x-show="view === 'trash' && trashItems.length > 0">
            Las notificaciones se eliminan definitivamente despues de 30 dias.
        </div>

        <div class="ui-notifications__list" x-show="view === 'trash' && trashItems.length > 0" x-ref="trashList">
            <template x-for="item in trashItems" :key="item.id">
                <article class="ui-notifications__item ui-notifications__item--trash" :data-level="item.level">
                    <div>
                        <div class="ui-notifications__item-title" x-text="item.title"></div>
                        <div class="ui-notifications__item-message" x-text="item.message"></div>
                        <div class="ui-notifications__item-date" x-text="item.date"></div>
                    </div>
                    <button type="button" class="ui-notifications__restore" @click.stop="restoreNotification(item)">Restaurar</button>
                </article>
            </template>
        </div>
    </div>
</div>
