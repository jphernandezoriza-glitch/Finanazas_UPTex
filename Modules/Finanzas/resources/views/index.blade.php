<x-finanzas::layouts.master>
{{-- Punto de partida vacío del módulo Finanzas. --}}<h1>Finanzas: lienzo de desarrollo</h1><p>El módulo está registrado y protegido; no contiene pagos ni datos institucionales.</p><form method="post" action="{{ route('logout') }}">@csrf<button>Salir</button></form>

    <p>Module: {!! config('finanzas.name') !!}</p>
</x-finanzas::layouts.master>
