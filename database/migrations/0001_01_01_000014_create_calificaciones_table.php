<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones', function (Blueprint $table) {

            $table->id('ID_Calificaciones');

            $table->unsignedBigInteger('ID_Proyecto');
            $table->unsignedBigInteger('ID_Usuario');

            $table->float('Nota_Final')->nullable();

            $table->string('Estado', 255)->nullable();
            $table->unsignedBigInteger('ID_Rubrica');
            $table->foreign('ID_Rubrica')
                ->references('ID_Rubrica')
                ->on('rubricas');

            $table->foreign('ID_Proyecto')
                ->references('ID_Proyecto')
                ->on('proyectos');

            $table->foreign('ID_Usuario')
                ->references('id')
                ->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
