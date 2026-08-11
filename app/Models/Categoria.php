<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
  protected $table = 'categorias';
  protected $primaryKey = 'ID_Categoria';
  public $timestamps = false;

  protected $fillable = [
    'Nombre',
    'Descripcion',
  ];

  public function preguntas()
  {
    return $this->hasMany(Pregunta::class, 'ID_Categoria', 'ID_Categoria');
  }

  public function proyectos()
  {
    return $this->hasMany(Proyecto::class, 'ID_categoria', 'ID_Categoria');
  }
  public function apartados()
  {
    return $this->hasMany(Apartado::class, 'ID_Categoria', 'ID_Categoria')
      ->where('Estado', 'Activo')
      ->orderBy('Orden');
  }


  // Relación: Una Categoría tiene muchos Ejes Temáticos
  public function ejesTematicos()
  {
    return $this->hasMany(EjeTematico::class, 'ID_Categoria', 'ID_Categoria');
  }
}