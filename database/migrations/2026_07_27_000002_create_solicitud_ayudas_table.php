<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitud_ayudas', function (Blueprint $table) {
            $table->id('ID_Solicitud');
            $table->unsignedBigInteger('ID_Usuario');
            $table->string('Mensaje')->nullable();
            $table->string('Estado', 50)->default('Pendiente');
            $table->string('Respuesta')->nullable();
            $table->timestamps();

            $table->foreign('ID_Usuario')
                ->references('id')
                ->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitud_ayudas');
    }
};
