<?php

namespace App\Livewire\Consulta;

use App\Models\Consulta;
use Livewire\Component;

class IndexConsulta extends Component
{
    public function delete(Consulta $consulta)
    {
        $consulta->delete();
        session()->flash('success', 'Consulta eliminada correctamente.');
        $this->redirectRoute('consulta.index-consulta', navigate: true);
    }

    public function render()
    {
        return view('livewire.consulta.index-consulta', [
            'consultas' => Consulta::with(['cita.paciente', 'cita.doctor'])->paginate(10),
        ]);
    }
}
