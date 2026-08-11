<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartado extends Model
{
    protected $table = 'apartados';
    protected $primaryKey = 'ID_Apartado';
    public $timestamps = false;

    protected $fillable = [
        'Titulo',
        'ID_Categoria',
        'ID_Rubrica', // <-- Agregado para permitir asignación masiva
        'Orden',
        'Estado',
    ];

    /**
     * Un apartado pertenece a una categoría.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'ID_Categoria', 'ID_Categoria');
    }

    /**
     * Un apartado pertenece a una rúbrica.
     */
    public function rubrica()
    {
        return $this->belongsTo(Rubrica::class, 'ID_Rubrica', 'ID_Rubrica');
    }

    /**
     * Un apartado tiene muchas preguntas.
     */
    public function preguntas()
    {
        return $this->hasMany(
            Pregunta::class,
            'ID_Apartado',
            'ID_Apartado'
        )
        ->where('Estado', 'Activo')
        ->orderBy('ID_Pregunta');
    }

    public static function maximaPorCombinacion()
    {
        return static::where('Estado', 'Activo')
            ->with('preguntas')
            ->get()
            ->groupBy(fn($a) => $a->ID_Categoria . '|' . $a->ID_Rubrica)
            ->map(fn($grupo) => $grupo->flatMap(fn($a) => $a->preguntas)->sum('Maxima_Calificacion'));
    }
}