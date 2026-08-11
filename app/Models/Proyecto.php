<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto extends Model
{

  use HasFactory, SoftDeletes;
  protected $table = 'proyectos';
  protected $primaryKey = 'ID_Proyecto';
  public $timestamps = false;

  protected $fillable = [
    'Nombre',
    'Descripcion',
    'Imagen',
    'Archivo_PDF',
    'ID_categoria',
    'ID_Eje', // Añadir este nuevo campo
  ];

  public function categoria()
  {
    return $this->belongsTo(Categoria::class, 'ID_categoria', 'ID_Categoria');
  }

  public function personasAsignadas()
  {
    return $this->hasMany(PersonaAsignada::class, 'ID_Proyecto', 'ID_Proyecto');
  }

  public function respuestas()
  {
    return $this->hasMany(Respuesta::class, 'ID_Proyecto', 'ID_Proyecto');
  }

  public function calificaciones()
  {
    return $this->hasMany(Calificacion::class, 'ID_Proyecto', 'ID_Proyecto');
  }

  public function correosEnviados()
  {
    return $this->hasMany(CorreoEnviado::class, 'ID_Proyecto', 'ID_Proyecto');
  }


  public function ejeTematico()
  {
    return $this->belongsTo(EjeTematico::class, 'ID_Eje', 'ID_Eje');
  }
}