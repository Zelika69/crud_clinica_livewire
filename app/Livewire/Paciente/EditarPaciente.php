<?php

namespace App\Livewire\Paciente;

use App\Livewire\Forms\PacienteForm;
use App\Models\Paciente;
use Livewire\Component;

class EditarPaciente extends Component
{
    public PacienteForm $form;

    public function mount(Paciente $paciente)
    {
        $this->form->setPaciente($paciente);
    }

    public function save()
    {
        $this->form->update();
        session()->flash('success', 'Paciente editado correctamente!.');
        $this->redirectRoute('paciente.index-paciente', navigate: true);
    }

    public function render()
    {
        return view('livewire.paciente.crear-paciente',[
            'editando' => true
        ]);
    }
}
