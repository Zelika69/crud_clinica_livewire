<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = ['cita_id', 'diagnostico', 'tratamiento', 'notas'];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
