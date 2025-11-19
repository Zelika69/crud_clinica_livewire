<?php

namespace App\Livewire\Cita;

use App\Livewire\Forms\CitaForm;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Doctor;
use Livewire\Component;

class EditarCita extends Component
{
    public CitaForm $form;
    public Cita $cita;

    public function mount(Cita $cita)
    {
        $this->cita = $cita;
    
        $this->form->setCita($cita);
    }

    public function save()
    {
        $this->form->validate();
        $this->form->update();
        session()->flash('success', 'Cita editada correctamente!.');
        return redirect()->route('cita.index-cita');
    }

    public function render()
    {
        return view('livewire.cita.crear-cita', [
            'pacientes' => Paciente::orderBy('nombre')->get(),
            'doctores' => Doctor::orderBy('nombre')->get(),
            'editando' => true
        ]);
    }
}
