<?php

namespace App\Livewire\Consulta;

use App\Livewire\Forms\ConsultaForm;
use App\Models\Consulta;
use App\Models\Cita;
use Livewire\Component;

class CrearConsulta extends Component
{
    public ConsultaForm $form;
    public $consulta = null;
    public $editando = false;

    public function mount($consulta = null)
    {
        if ($consulta) {
            $this->consulta = $consulta;
            $this->editando = true;
            $this->form->setConsulta($consulta);
        }
    }

    public function save()
    {
        $this->form->validate();

        if ($this->editando) {
            $this->form->update();
            session()->flash('success', 'La consulta se actualizó correctamente.');
        } else {
            $this->form->store();
            session()->flash('success', 'La consulta se registró correctamente.');
        }

        return redirect()->route('consulta.index-consulta');
    }

    public function render()
    {
        $citas = Cita::with(['paciente', 'doctor'])
            ->orderBy('fecha_hora', 'desc')
            ->get();

        return view('livewire.consulta.crear-consulta', [
            'citas' => $citas,
            'editando' => $this->editando,
            'form' => $this->form
        ]);
    }
}
