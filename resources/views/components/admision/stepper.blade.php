{{-- Vista Blade: organiza la presentacion de datos inyectados por controlador, ruta o componente Livewire. --}}
@props(['pasoActual' => 1])

@php
    $pasos = [
        1 => 'Programa',
        2 => 'Personales',
        3 => 'Domicilio',
        4 => 'Interés',
        5 => 'Familiares',
        6 => 'Procedencia',
        7 => 'Documentos',
        8 => 'Finalizar'
    ];
@endphp

<div class="stepper">
    @foreach($pasos as $num => $label)
        <div class="stepper__step {{ $num < $pasoActual ? 'stepper__step--completed' : ($num == $pasoActual ? 'stepper__step--active' : '') }}">
            <div class="stepper__step-circle">
                @if($num < $pasoActual)
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                @else
                    {{ $num }}
                @endif
            </div>
            <div class="stepper__step-label">{{ $label }}</div>
        </div>
    @endforeach
</div>
