<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';
    protected $primaryKey = 'ID_Pregunta';
    public $timestamps = false;

    protected $fillable = [
        'Pregunta',
        'ID_Apartado',
        'Maxima_Calificacion',
        'Estado',
    ];

public function apartado()
{
    return $this->belongsTo(Apartado::class, 'ID_Apartado', 'ID_Apartado')
            ->where('Estado', 'Activo')
            ->orderBy('ID_Apartado');;
}

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'ID_Pregunta', 'ID_Pregunta');
        
    }
}
