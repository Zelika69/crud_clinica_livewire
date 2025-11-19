<?php

namespace App\Livewire\Paciente;

use App\Livewire\Forms\PacienteForm;
use Livewire\Component;

class CrearPaciente extends Component
{
    public PacienteForm $form;

    public function save()
    {
        $this->form->store();
        session()->flash('success', 'El paciente se registró correctamente.');
        return redirect()->route('paciente.index-paciente');
    }

    public function render()
    {
        return view('livewire.paciente.crear-paciente',
    [
        'editando' => false
    ]);
    }
}
