<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persona_asignadas', function (Blueprint $table) {
            $table->id('ID_PersonaAsignada');
            $table->unsignedBigInteger('ID_Usuario');
            $table->unsignedBigInteger('ID_Proyecto');

            $table->foreign('ID_Usuario')->references('id')->on('users');
            $table->foreign('ID_Proyecto')->references('ID_Proyecto')->on('proyectos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persona_asignadas');
    }
};
