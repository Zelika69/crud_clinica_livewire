<?php

namespace App\Livewire\Cita;

use App\Livewire\Forms\CitaForm;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Doctor;
use Livewire\Component;

class CrearCita extends Component
{
    public CitaForm $form;
    public $cita = null;
    public $editando = false;

    public function mount($cita = null)
    {
        if ($cita) {
            $this->cita = $cita;
            $this->editando = true;
            $this->form->setCita($cita);
        }
    }

    public function save()
    {
        $this->form->validate();

        if ($this->editando) {
            $this->form->update();
            session()->flash('success', 'La cita se actualizó correctamente.');
        } else {
            $this->form->store();
            session()->flash('success', 'La cita se registró correctamente.');
        }

        return redirect()->route('cita.index-cita');
    }

    public function render()
    {
        return view('livewire.cita.crear-cita', [
            'pacientes' => Paciente::orderBy('nombre')->get(),
            'doctores' => Doctor::orderBy('nombre')->get(),
            'editando' => $this->editando
        ]);
    }
}
