<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id('ID_Pregunta');
            $table->string('Pregunta', 255);
            $table->unsignedBigInteger('ID_Apartado');
            $table->integer('Maxima_Calificacion')->nullable();
            $table->string('Estado', 255)->nullable();

            $table->foreign('ID_Apartado')->references('ID_Apartado')->on('apartados')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
