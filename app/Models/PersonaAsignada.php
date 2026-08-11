<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaAsignada extends Model
{
    protected $table = 'persona_asignadas';
    protected $primaryKey = 'ID_PersonaAsignada';
    public $timestamps = false;

    protected $fillable = [
        'ID_Usuario',
        'ID_Proyecto',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'ID_Usuario', 'id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'ID_Proyecto', 'ID_Proyecto');
    }
}
