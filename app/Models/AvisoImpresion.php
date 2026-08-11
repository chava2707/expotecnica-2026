<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvisoImpresion extends Model
{
    protected $table = 'avisos_impresion';
    protected $primaryKey = 'ID_Aviso';

    public $timestamps = true;

    protected $fillable = [
        'ID_Correo',
        'ID_Proyecto',
        'Estado',
        'Fecha_Recogido',
    ];

    public function correo()
    {
        return $this->belongsTo(CorreoEnviado::class, 'ID_Correo', 'ID_Correo');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'ID_Proyecto', 'ID_Proyecto');
    }
}
