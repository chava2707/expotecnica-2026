<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('ID_Roles');
            $table->string('Nombre_rol', 255);
            $table->string('Descripcion_rol', 255)->nullable();
            $table->string('Estado', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
