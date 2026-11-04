<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        foreach (['acceso.finanzas', 'acceso.alumno'] as $name) { Permission::findOrCreate($name); }
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $admin = Role::findOrCreate('ADMINISTRATIVO'); $admin->syncPermissions('acceso.finanzas');
        $alumno = Role::findOrCreate('ALUMNO'); $alumno->syncPermissions('acceso.alumno');
        // Credenciales deliberadamente ficticias: el ZIP nunca transporta usuarios reales.
        $finance = User::updateOrCreate(['email' => 'admin@uptex-sandbox.test'], ['name' => 'ADMINISTRATIVO SANDBOX', 'password' => Hash::make('Sandbox2026!')]); $finance->syncRoles($admin);
        $student = User::updateOrCreate(['email' => 'alumno@uptex-sandbox.test'], ['name' => 'ALUMNO SANDBOX', 'password' => Hash::make('Sandbox2026!')]); $student->syncRoles($alumno);
    }
}
