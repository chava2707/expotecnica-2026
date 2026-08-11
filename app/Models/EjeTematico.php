<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EjeTematico extends Model
{
  protected $table = 'ejes_tematicos';
  protected $primaryKey = 'ID_Eje';
  public $timestamps = false; // Para mantener la misma convención que tus otros modelos

  protected $fillable = [
    'Nombre',
    'Descripcion',
    'ID_Categoria',
  ];

  // Relación: Un Eje Temático pertenece a una Categoría
  public function categoria()
  {
    return $this->belongsTo(Categoria::class, 'ID_Categoria', 'ID_Categoria');
  }

  // Relación: Un Eje Temático puede tener muchos Proyectos asociados
  public function proyectos()
  {
    return $this->hasMany(Proyecto::class, 'ID_Eje', 'ID_Eje');
  }
}