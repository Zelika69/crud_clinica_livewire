<?php

namespace App\Livewire\Forms;

use App\Models\Doctor;
use Illuminate\Container\Attributes\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DoctorForm extends Form
{
    public ?Doctor $doctores;

    #[Validate('required|string|max:255', as: 'Doctor nombre')]
    public $nombre;
    #[Validate('required|string|max:255', as: 'Doctor apellido')]
    public $apellido;
    #[Validate('required|email|max:255', as: 'Doctor email')]
    public $email;
    #[Validate('nullable|string|max:100', as: 'Doctor especialidad')]
    public $especialidad;
    #[Validate('nullable|string|max:20', as: 'Doctor telefono')]
    public $telefono;
    #[Validate('nullable|image|max:5120', as: 'Doctor foto_perfil')]
    public $foto_perfil; // <- aquí viene el file de Livewire


    public function setDoctor(Doctor $doctor)
    {
        $this->doctores = $doctor;

        $this->nombre = $doctor->nombre;
        $this->apellido = $doctor->apellido;
        $this->email = $doctor->email;
        $this->especialidad = $doctor->especialidad;
        $this->telefono = $doctor->telefono;
        $this->foto_perfil = null;
    }
    public function store()
    {
        $data = $this->validate();

        // Guardamos imagen si existe
        if ($this->foto_perfil) {
            $path = $this->foto_perfil->store('fotos/doctores', 'public');
            $data['foto_perfil'] = $path;   // sin "/storage/"
        }

        Doctor::create($data);
    }

    public function update()
    {
        $data = $this->validate();

        // Si se subió nueva imagen
        if ($this->foto_perfil) {

            // Guardar nueva imagen
            $path = $this->foto_perfil->store('fotos/doctores', 'public');
            $data['foto_perfil'] = $path;

            // ---- BORRAR FOTO ANTERIOR CON UNLINK ----
            if ($this->doctores->foto_perfil) {

                // Ruta física del archivo
                $rutaAnterior = public_path('storage/' . $this->doctores->foto_perfil);

                // Si existe, se elimina
                if (file_exists($rutaAnterior)) {
                    unlink($rutaAnterior);
                }
            }
        } else {
            // Si no subes nueva imagen, conserva la anterior
            $data['foto_perfil'] = $this->doctores->foto_perfil;
        }

        // Actualizar doctor
        $this->doctores->update($data);
    }
}
