<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table = 'respuestas';
    protected $primaryKey = 'ID_Respuesta';
    public $timestamps = false;

    protected $fillable = [
        'ID_Pregunta',
        'Calificacion',
        'Observaciones',
        'ID_Proyecto',
        'ID_Usuario',
        'Estado',
        'ID_Rubrica',
    ];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'ID_Pregunta', 'ID_Pregunta');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'ID_Proyecto', 'ID_Proyecto');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'ID_Usuario', 'id');
    }
}
