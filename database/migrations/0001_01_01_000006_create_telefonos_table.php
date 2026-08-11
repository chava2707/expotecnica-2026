<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telefonos', function (Blueprint $table) {
            $table->id('ID_Telefono');
            $table->integer('IDPersona');
            $table->string('Numero_Telefono', 255);
            $table->boolean('Activo')->default(true);
            $table->boolean('Es_Principal')->default(false);
            $table->string('Estado', 255)->nullable();

            $table->foreign('IDPersona')->references('ID_Cedula')->on('personas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telefonos');
    }
};
