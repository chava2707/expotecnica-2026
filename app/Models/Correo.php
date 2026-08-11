<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'correos';
    protected $primaryKey = 'ID_Correo';
    public $timestamps = false;

    protected $fillable = [
        'IDPersona',
        'Correo',
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
