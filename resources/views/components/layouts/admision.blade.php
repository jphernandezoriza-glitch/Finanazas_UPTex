@props(['pasoActual' => 1, 'token' => null])

<x-layouts.public :title="'Admisión - Paso ' . $pasoActual" :include-livewire="true">
    <div class="admission-container">
        <header class="admission-header">
            <h1>Admision {{ app(\Modules\Core\Services\UniversityIdentityService::class)->shortName() }}</h1>
            <p>Sigue los pasos para completar tu registro de ingreso.</p>
        </header>

        <x-admision.stepper :pasoActual="$pasoActual" />

        <div class="admission-card" 
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 50)"
             x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translateY-10"
             x-transition:enter-end="opacity-100 translateY-0">
            <!-- Mensajes de Estado -->


            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</x-layouts.public>
