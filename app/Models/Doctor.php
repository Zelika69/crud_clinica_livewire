<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Doctor extends Model
{
    /**
     * The table associated with the model.
     *
     * Migration creates table `doctores` (Spanish plural),
     * so set the model to use that table name.
     */
    use HasFactory;

    protected $table = 'doctores';

    protected $fillable = ['nombre', 'apellido', 'especialidad', 'email', 'telefono', 'foto_perfil'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
