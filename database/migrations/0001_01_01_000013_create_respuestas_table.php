<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id('ID_Respuesta');
            $table->unsignedBigInteger('ID_Pregunta');
            $table->float('Calificacion')->nullable();
            $table->string('Observaciones', 255)->nullable();
            $table->unsignedBigInteger('ID_Proyecto');
            $table->unsignedBigInteger('ID_Usuario');
            $table->string('Estado', 255)->nullable();
            $table->unsignedBigInteger('ID_Rubrica');

            $table->foreign('ID_Rubrica')
                ->references('ID_Rubrica')
                ->on('rubricas');


            $table->foreign('ID_Pregunta')->references('ID_Pregunta')->on('preguntas');
            $table->foreign('ID_Proyecto')->references('ID_Proyecto')->on('proyectos');
            $table->foreign('ID_Usuario')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
