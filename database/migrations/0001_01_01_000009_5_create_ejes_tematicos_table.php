<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('ejes_tematicos', function (Blueprint $table) {
      // Llave primaria personalizada
      $table->id('ID_Eje');

      // Campos de texto
      $table->string('Nombre');
      $table->text('Descripcion')->nullable();

      // Icono con valor por defecto
      $table->string('Icono', 50)->default('code');

      // Llave foránea para la Categoría
      // Usamos unsignedBigInteger porque el método id() crea ese tipo de dato por defecto
      $table->unsignedBigInteger('ID_Categoria')->nullable();

      // Descomenta la siguiente línea si tu tabla de categorías YA EXISTE en las migraciones
      // y su llave primaria también se llama 'ID_Categoria'
      // $table->foreign('ID_Categoria')->references('ID_Categoria')->on('categorias')->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ejes_tematicos');
  }
};