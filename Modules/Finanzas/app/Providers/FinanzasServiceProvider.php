<?php

namespace Modules\Finanzas\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Finanzas\Contracts\VerificadorPagoExterno;
use Modules\Finanzas\Services\VerificadorPagoLocal;

class FinanzasServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Finanzas';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'finanzas';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /** Registra el fake local: cambiarlo por un adaptador real exige contrato aprobado. */
    public function register(): void
    {
        parent::register();
        $this->app->bind(VerificadorPagoExterno::class, VerificadorPagoLocal::class);
    }

    /**
     * Define module schedules.
     * 
     * @param $schedule
     */
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();
    // }
}
