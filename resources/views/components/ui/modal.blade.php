{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props([
    'open' => false,
    'title' => null,
    'subtitle' => null,
    'closeAction' => null,
    'alpineOpen' => null,
    'alpineClose' => null,
    'alpineTitle' => null,
    'alpineSubtitle' => null,
    'size' => 'md',
    'dismissible' => true,
    'bodyClass' => '',
    'dialogClass' => '',
    'footerClass' => '',
    'teleport' => true,
    'icon' => null,
])

@php
    $modalTitleId = 'ui-modal-title-'.\Illuminate\Support\Str::uuid();
    $modalSubtitleId = 'ui-modal-subtitle-'.\Illuminate\Support\Str::uuid();
    $usesAlpineState = filled($alpineOpen);
    $shouldRender = $open || $usesAlpineState;
    $normalizedIcon = is_string($icon) ? trim($icon) : '';
    $normalizedIcon = $normalizedIcon !== '' ? $normalizedIcon : 'configuracion';
    $normalizedIcon = preg_replace('/^icon--/', '', $normalizedIcon);
    $normalizedIcon = $normalizedIcon ? preg_replace('/[^a-z0-9-]/i', '', $normalizedIcon) : null;
    $hasHeaderIcon = filled($normalizedIcon);
@endphp

@if($shouldRender)
    <div
        x-data="{
            previousFocus: null,
            hasFocused: false,
            init() {
                this.previousFocus = document.activeElement;
                this.prepare();
            },
            prepare() {
                if (this.hasFocused) return;
                this.hasFocused = true;
                this.$nextTick(() => {
                    window.dispatchEvent(new CustomEvent('uptex:select-enhancer:scan', { detail: { root: this.$refs.dialog } }));
                    requestAnimationFrame(() => this.focusFirstControl());
                });
            },
            focusFirstControl() {
                if (!this.$refs.dialog) return;
                const scope = this.$refs.dialog.querySelector('.ui-modal__body') || this.$refs.dialog;
                scope.querySelector('input:not([disabled]):not(.uptex-native-select--enhanced), .uptex-select__button:not([disabled]), textarea:not([disabled]), button:not([disabled]), select:not([disabled]):not(.uptex-native-select--enhanced)')?.focus();
            },
            close() {
                if (! @js((bool) $dismissible)) return;
                this.previousFocus?.focus();
                @if(filled($alpineClose))
                    {!! $alpineClose !!};
                @elseif(filled($closeAction))
                    this.$wire['{{ $closeAction }}']();
                @endif
            },
            handleTab(event) {
                const focusable = [...this.$refs.dialog.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]):not(.uptex-native-select--enhanced), .uptex-select__button:not([disabled]), select:not([disabled]):not(.uptex-native-select--enhanced), textarea:not([disabled]), [tabindex]:not([tabindex=\'-1\'])')];
                const first = focusable[0];
                const last = focusable[focusable.length - 1];

                if (!first || !last) return;
                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            },
        }"
    >
        @if($teleport)
        <template x-teleport="body">
        @endif
            <div
                class="ui-modal"
                x-init="init()"
                @if($usesAlpineState)
                    x-show="{{ $alpineOpen }}"
                    x-effect="if ({{ $alpineOpen }}) prepare()"
                    x-cloak
                    x-transition.opacity
                @endif
                x-on:keydown.escape.window="close()"
                role="presentation"
            >
                @if($dismissible)
                    <button
                        type="button"
                        class="ui-modal__backdrop"
                        x-on:click="close()"
                        aria-label="Cerrar ventana"
                    ></button>
                @else
                    <div class="ui-modal__backdrop" aria-hidden="true"></div>
                @endif

                <section
                    x-ref="dialog"
                    class="ui-modal__dialog ui-modal__dialog--{{ $size }} {{ $dialogClass }}"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="{{ $modalTitleId }}"
                    @if($subtitle || $alpineSubtitle)
                        aria-describedby="{{ $modalSubtitleId }}"
                    @endif
                    x-on:keydown.tab="handleTab($event)"
                >
                    <header class="ui-modal__header {{ $hasHeaderIcon ? 'ui-modal__header--with-icon' : '' }}">
                        @if($hasHeaderIcon)
                            <span class="ui-modal__header-icon" aria-hidden="true">
                                <span class="icon icon--{{ $normalizedIcon }}"></span>
                            </span>
                        @endif
                        <div class="ui-modal__heading">
                            <h2 id="{{ $modalTitleId }}" @if($alpineTitle) x-text="{{ $alpineTitle }}" @endif>{{ $title }}</h2>
                            @if($subtitle || $alpineSubtitle)
                                <p id="{{ $modalSubtitleId }}" @if($alpineSubtitle) x-text="{{ $alpineSubtitle }}" @endif>{{ $subtitle }}</p>
                            @endif
                        </div>
                        @if($dismissible)
                            <button
                                type="button"
                                class="ui-modal__close"
                                x-on:click="close()"
                                aria-label="Cerrar"
                                title="Cerrar"
                            >
                                <span aria-hidden="true"></span>
                            </button>
                        @elseif($hasHeaderIcon)
                            <span class="ui-modal__header-spacer" aria-hidden="true"></span>
                        @endif
                    </header>

                    <div class="ui-modal__body {{ $bodyClass }}">
                        {{ $slot }}
                    </div>

                    @isset($footer)
                        <footer class="ui-modal__footer {{ $footerClass }}">
                            {{ $footer }}
                        </footer>
                    @endisset
                </section>
            </div>
        @if($teleport)
        </template>
        @endif
    </div>
@endif
