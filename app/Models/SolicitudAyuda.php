<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudAyuda extends Model
{
    protected $table = 'solicitud_ayudas';
    protected $primaryKey = 'ID_Solicitud';
    public $timestamps = true;

    protected $fillable = [
        'ID_Usuario',
        'Mensaje',
        'Estado',
        'Respuesta',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'ID_Usuario', 'id');
    }
}
