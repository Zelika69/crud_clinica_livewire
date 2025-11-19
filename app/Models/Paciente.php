<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $fillable = ['nombre', 'apellido', 'email', 'telefono', 'fecha_nacimiento', 'direccion'];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
