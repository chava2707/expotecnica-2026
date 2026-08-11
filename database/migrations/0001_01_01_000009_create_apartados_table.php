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
        Schema::create('apartados', function (Blueprint $table) {
            $table->id('ID_Apartado');
            $table->string('Titulo', 255);$table->unsignedBigInteger('ID_Rubrica');

    $table->foreign('ID_Rubrica')
        ->references('ID_Rubrica')
        ->on('rubricas');
            $table->unsignedBigInteger('ID_Categoria');
            $table->integer('Orden')->default(1);
            $table->string('Estado', 255)->default('Activo');
            

            $table->foreign('ID_Categoria')
                ->references('ID_Categoria')
                ->on('categorias')
                ->onDelete('cascade');
                
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartados');
    }
};