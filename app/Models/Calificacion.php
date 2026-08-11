<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';
    protected $primaryKey = 'ID_Calificaciones';
    public $timestamps = false;

    protected $fillable = [
        'ID_Proyecto',
        'ID_Usuario',
        'Nota_Final',
        'ID_Rubrica',
        'Estado',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'ID_Proyecto', 'ID_Proyecto');
    }
    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'ID_Usuario',
            'id'
        );
    }
    public function rubrica()
{
    return $this->belongsTo(Rubrica::class, 'ID_Rubrica', 'ID_Rubrica');
}
    public function solicitudesEdicion()
    {
        return $this->hasMany(SolicitudEdicion::class, 'ID_Calificacion', 'ID_Calificaciones');
    }

    public function solicitudAprobada()
    {
        return $this->hasOne(SolicitudEdicion::class, 'ID_Calificacion', 'ID_Calificaciones')
            ->where('Estado', 'Aprobada');
    }
}
