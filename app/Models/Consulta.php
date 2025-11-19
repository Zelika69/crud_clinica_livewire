<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Consulta extends Model
{
    use HasFactory;
    protected $fillable = ['cita_id', 'diagnostico', 'tratamiento', 'notas'];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
