<?php

namespace App\Livewire\Cita;

use App\Models\Cita;
use Livewire\Component;

class IndexCita extends Component
{
    public function delete(Cita $cita)
    {
        $cita->delete();
        session()->flash('success', 'Cita eliminada correctamente.');
        $this->redirectRoute('cita.index-cita', navigate: true);
    }

    public function render()
    {
        return view('livewire.cita.index-cita',[
            'citas' => Cita::with(['doctor', 'paciente'])->paginate(10),

        ]);
    }
}
