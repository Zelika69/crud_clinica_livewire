<?php

namespace App\Livewire\Forms;

use App\Models\Paciente;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PacienteForm extends Form
{
    public ?Paciente $pacientes;

    #[Validate('required|string|max:255', as: 'Paciente nombre')]
    public $nombre;
    #[Validate('required|string|max:255', as: 'Paciente apellido')]
    public $apellido;
    #[Validate('required|email|max:255', as: 'Paciente email')]
    public $email;
    #[Validate('nullable|string|max:20', as: 'Paciente telefono')]
    public $telefono;
    #[Validate('nullable|date', as: 'Paciente fecha_nacimiento')]
    public $fecha_nacimiento;
    #[Validate('nullable|string', as: 'Paciente direccion')]
    public $direccion;

    public function setPaciente(Paciente $paciente)
    {
        $this->pacientes = $paciente;

        $this->nombre = $paciente->nombre;
        $this->apellido = $paciente->apellido;
        $this->email = $paciente->email;
        $this->telefono = $paciente->telefono;
        $this->fecha_nacimiento = $paciente->fecha_nacimiento;
        $this->direccion = $paciente->direccion;
    }
    public function update()
    {
        $data = $this->validate();
        $this->pacientes->update($data);
    }

    public function store()
    {
        $data = $this->validate();

        Paciente::create($data);
    }
}
