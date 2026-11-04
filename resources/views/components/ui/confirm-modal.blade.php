{{-- Modal de confirmacion UPTex: reutiliza x-ui.modal y normaliza acciones destructivas o de confirmacion. --}}
@props([
    'open' => false,
    'title',
    'closeAction',
    'confirmAction',
    'confirmLabel' => 'Confirmar',
    'variant' => 'danger',
    'size' => 'sm',
    'icon' => null,
])

@php
    $modalIcon = $icon ?: ($variant === 'danger' ? 'alerta' : 'check');
@endphp

<x-ui.modal :open="$open" :title="$title" :close-action="$closeAction" :size="$size" :icon="$modalIcon">
    <div class="ui-confirm-modal ui-confirm-modal--{{ $variant }}">
        {{ $slot }}
    </div>

    <x-slot:footer>
        <div class="ui-confirm-modal__actions">
            <button type="button" class="admin-btn admin-btn--{{ $variant === 'danger' ? 'danger' : 'primary' }}" wire:click="{{ $confirmAction }}" wire:loading.attr="disabled" wire:target="{{ $confirmAction }}" data-loading-action>
                <span wire:loading.remove wire:target="{{ $confirmAction }}">{{ $confirmLabel }}</span>
                <span wire:loading wire:target="{{ $confirmAction }}">Procesando...</span>
            </button>
        </div>
    </x-slot:footer>
</x-ui.modal>
