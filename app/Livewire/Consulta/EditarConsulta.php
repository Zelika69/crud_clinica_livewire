<?php

namespace App\Livewire\Consulta;

use App\Livewire\Forms\ConsultaForm;
use App\Models\Consulta;
use App\Models\Cita;
use Livewire\Component;

class EditarConsulta extends Component
{
    public ConsultaForm $form;
    public Consulta $consulta;

    public function mount(Consulta $consulta)
    {
        $this->consulta = $consulta;
        $this->form->setConsulta($consulta);
    }

    public function save()
    {
        $this->form->validate();
        $this->form->update();
        session()->flash('success', 'Consulta editada correctamente!');
        return redirect()->route('consulta.index-consulta');
    }

    public function render()
    {
        return view('livewire.consulta.crear-consulta', [
            'citas' => Cita::with(['paciente', 'doctor'])->orderBy('fecha_hora', 'desc')->get(),
            'editando' => true
        ]);
    }
}
