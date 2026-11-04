{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
<button
    type="button"
    class="theme-toggle"
    data-theme-toggle
    aria-label="Cambiar a modo oscuro"
    title="Cambiar a modo oscuro"
>
    <svg class="theme-toggle__icon theme-toggle__icon--sun" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
        <circle cx="12" cy="12" r="4.5" stroke="currentColor" stroke-width="2"></circle>
        <path d="M12 2.5v2M12 19.5v2M4.6 4.6 6 6M18 18l1.4 1.4M2.5 12h2M19.5 12h2M4.6 19.4 6 18M18 6l1.4-1.4" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
    </svg>
    <svg class="theme-toggle__icon theme-toggle__icon--moon" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
        <path d="M20.2 14.6A7.7 7.7 0 0 1 9.4 3.8a8.7 8.7 0 1 0 10.8 10.8Z" stroke="currentColor" stroke-linejoin="round" stroke-width="2"></path>
    </svg>
</button>
