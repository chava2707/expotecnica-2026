<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudEdicion extends Model
{
    protected $table = 'solicitud_edicions';
    protected $primaryKey = 'ID_Solicitud';
    public $timestamps = true;

    protected $fillable = [
        'ID_Calificacion',
        'ID_Usuario',
        'Motivo',
        'Estado',
    ];

    public function calificacion()
    {
        return $this->belongsTo(Calificacion::class, 'ID_Calificacion', 'ID_Calificaciones');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'ID_Usuario', 'id');
    }
}
