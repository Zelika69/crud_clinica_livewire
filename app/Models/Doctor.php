<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /**
     * The table associated with the model.
     *
     * Migration creates table `doctores` (Spanish plural),
     * so set the model to use that table name.
     */
    
    protected $table = 'doctores';

    protected $fillable = ['nombre', 'apellido', 'especialidad', 'email', 'telefono', 'foto_perfil'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
