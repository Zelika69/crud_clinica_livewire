<?php

namespace App\Livewire\Paciente;
use App\Models\Paciente;

use Livewire\Component;

class IndexPaciente extends Component
{
    public function delete(Paciente $paciente)
    {
        $paciente->delete();
        session()->flash('success', 'Paciente eliminado correctamente.');
        $this->redirectRoute('paciente.index-paciente', navigate: true);

    }
    public function render()
    {
        return view('livewire.paciente.index-paciente',
    [
        'pacientes' => Paciente::latest()->paginate(10)
    ]);
    }
}
