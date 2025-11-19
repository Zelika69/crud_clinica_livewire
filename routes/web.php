<?php

use App\Livewire\Cita\IndexCita;
use App\Livewire\Cita\CrearCita;
use App\Livewire\Cita\EditarCita;
use App\Livewire\Consulta\IndexConsulta;
use App\Livewire\Consulta\CrearConsulta;
use App\Livewire\Consulta\EditarConsulta;
use App\Livewire\Doctor\CrearDoctor;
use App\Livewire\Doctor\IndexDoctor;
use App\Livewire\Doctor\EditarDoctor;
use App\Livewire\Paciente\CrearPaciente;
use App\Livewire\Paciente\EditarPaciente;
use App\Livewire\Paciente\IndexPaciente;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
        Route::get('paciente', IndexPaciente::class)->name('paciente.index-paciente');
        Route::get('paciente/crear', CrearPaciente::class)->name('paciente.crear-paciente');
        Route::get('paciente/{paciente}/editar', EditarPaciente::class)->name('paciente.editar-paciente');

        Route::get('doctor', IndexDoctor::class)->name('doctor.index-doctor');
        Route::get('doctor/crear', CrearDoctor::class)->name('paciente.crear-doctor');
        Route::get('doctor/{doctor}/editar', EditarDoctor::class)->name('paciente.editar-doctor');

        Route::get('cita', IndexCita::class)->name('cita.index-cita');
        Route::get('cita/crear', CrearCita::class)->name('cita.crear-cita');
        Route::get('cita/{cita}/editar', EditarCita::class)->name('cita.editar-cita');

        Route::get('consulta', IndexConsulta::class)->name('consulta.index-consulta');
        Route::get('consulta/crear', CrearConsulta::class)->name('consulta.crear-consulta');
        Route::get('consulta/{consulta}/editar', EditarConsulta::class)->name('consulta.editar-consulta');
});
