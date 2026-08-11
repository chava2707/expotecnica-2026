<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avisos_impresion', function (Blueprint $table) {
            $table->id('ID_Aviso');

            $table->unsignedBigInteger('ID_Correo');
            $table->unsignedBigInteger('ID_Proyecto');

            $table->enum('Estado', [
                'Pendiente',
                'Recogido',
                'Cancelado'
            ])->default('Pendiente');

            $table->timestamp('Fecha_Recogido')->nullable();

            $table->timestamps();

            $table->foreign('ID_Correo')
                ->references('ID_Correo')
                ->on('correo_enviados');

            $table->foreign('ID_Proyecto')
                ->references('ID_Proyecto')
                ->on('proyectos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avisos_impresion');
    }
};
