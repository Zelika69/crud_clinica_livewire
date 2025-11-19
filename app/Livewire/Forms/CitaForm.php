<?php

namespace App\Livewire\Forms;

use App\Models\Cita;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CitaForm extends Form
{
    public ?Cita $cita = null;

    #[Validate('required|exists:pacientes,id')]
    public $paciente_id = '';

    #[Validate('required|exists:doctores,id')]
    public $doctor_id = '';

    #[Validate('required|date_format:Y-m-d\\TH:i')]
    public $fecha_hora = '';

    #[Validate('nullable|in:programada,confirmada,cancelada,atendida')]
    public $estado = 'programada';

    #[Validate('nullable|string|max:255')]
    public $motivo = '';

    public function setCita(Cita $cita)
    {
        $this->cita = $cita;
        $this->paciente_id = $cita->paciente_id;
        $this->doctor_id = $cita->doctor_id;
        // Convertir fecha_hora al formato que espera datetime-local (Y-m-d\TH:i)
        $this->fecha_hora = $cita->fecha_hora instanceof \DateTime
            ? $cita->fecha_hora->format('Y-m-d\TH:i')
            : \Carbon\Carbon::parse($cita->fecha_hora)->format('Y-m-d\TH:i');
        $this->estado = $cita->estado;
        $this->motivo = $cita->motivo;
    }

    public function update()
    {
        $data = $this->validate();
        $this->cita->update($data);
    }

    public function store()
    {
        $data = $this->validate();
        Cita::create($data);
    }
}
