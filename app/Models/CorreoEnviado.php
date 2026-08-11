<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorreoEnviado extends Model
{
    protected $table = 'correo_enviados';
    protected $primaryKey = 'ID_Correo';
    public $timestamps = false;

    protected $fillable = [
        'ID_Proyecto',
        'Correo_destino',
        'Archivo_PDF',
        'Estado',
        'Mensaje_Error',
        'Fecha_Envio',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'ID_Proyecto', 'ID_Proyecto');
    }
}
