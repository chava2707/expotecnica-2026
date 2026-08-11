<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'ID_Cedula';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'ID_Cedula',
        'Nombre',
        'Apellido_1',
        'Apellido_2',
        'Fecha_Nacimiento',
        'Estado',
    ];

    protected function casts(): array
    {
        return [
            'Fecha_Nacimiento' => 'date',
            'Estado' => 'boolean',
        ];
    }

    public function telefonos()
    {
        return $this->hasMany(Telefono::class, 'IDPersona', 'ID_Cedula');
    }

    public function correos()
    {
        return $this->hasMany(Correo::class, 'IDPersona', 'ID_Cedula');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'IDPersona', 'ID_Cedula');
    }
}
