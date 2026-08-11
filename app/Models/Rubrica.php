<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubrica extends Model
{
    protected $table = 'rubricas';
    protected $primaryKey = 'ID_Rubrica';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Estado',
    ];

    /**
     * Una rúbrica tiene muchas categorías.
     */
    public function categorias()
    {
        return $this->hasMany(
            Categoria::class,
            'ID_Rubrica',
            'ID_Rubrica'
        );
    }

    /**
     * Una rúbrica tiene muchos apartados.
     */
    public function apartados()
    {
        return $this->hasMany(
            Apartado::class,
            'ID_Rubrica',
            'ID_Rubrica'
        );
    }
}