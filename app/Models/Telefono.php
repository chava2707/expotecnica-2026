<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    protected $table = 'telefonos';
    protected $primaryKey = 'ID_Telefono';
    public $timestamps = false;

    protected $fillable = [
        'IDPersona',
        'Numero_Telefono',
        'Activo',
        'Es_Principal',
        'Estado',
    ];

    protected function casts(): array
    {
        return [
            'Activo' => 'boolean',
            'Es_Principal' => 'boolean',
        ];
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'IDPersona', 'ID_Cedula');
    }
}
