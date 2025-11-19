<?php

namespace App\Livewire\Forms;

use App\Models\Consulta;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ConsultaForm extends Form
{
    public ?Consulta $consulta = null;

    #[Validate('required|exists:citas,id')]
    public $cita_id = '';

    #[Validate('nullable|string|max:1000')]
    public $diagnostico = '';

    #[Validate('nullable|string|max:1000')]
    public $tratamiento = '';

    #[Validate('nullable|string|max:1000')]
    public $notas = '';

    public function setConsulta(Consulta $consulta)
    {
        $this->consulta = $consulta;
        $this->cita_id = $consulta->cita_id;
        $this->diagnostico = $consulta->diagnostico;
        $this->tratamiento = $consulta->tratamiento;
        $this->notas = $consulta->notas;
    }

    public function update()
    {
        $data = $this->validate();
        $this->consulta->update($data);
    }

    public function store()
    {
        $data = $this->validate();
        Consulta::create($data);
    }
}
