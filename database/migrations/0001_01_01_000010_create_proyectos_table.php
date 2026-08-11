<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('proyectos', function (Blueprint $table) {
      $table->id('ID_Proyecto');
      $table->string('Nombre', 255);
      $table->string('Descripcion', 255)->nullable();
      $table->string('Imagen', 255)->nullable();

      // Tus llaves foráneas
      $table->unsignedBigInteger('ID_categoria');

      // 👇 ESTA ES LA COLUMNA NUEVA 👇
      $table->unsignedBigInteger('ID_Eje')->nullable();

      // Relaciones
      $table->foreign('ID_categoria')->references('ID_Categoria')->on('categorias');

      // 👇 OPCIONAL PERO RECOMENDADO: Relación con la tabla ejes_tematicos 👇
      $table->foreign('ID_Eje')->references('ID_Eje')->on('ejes_tematicos')->onDelete('set null');
    });
  }
};