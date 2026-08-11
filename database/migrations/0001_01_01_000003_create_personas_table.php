<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->integer('ID_Cedula')->primary();
            $table->string('Nombre', 255);
            $table->string('Apellido_1', 255);
            $table->string('Apellido_2', 255)->nullable();
            $table->date('Fecha_Nacimiento')->nullable();
            $table->boolean('Estado')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
