<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('correo_enviados', function (Blueprint $table) {
        $table->id('ID_Correo');

        $table->unsignedBigInteger('ID_Proyecto');

        $table->string('Correo_destino');

        $table->string('Archivo_PDF')->nullable();

        $table->enum('Estado', [
            'Pendiente',
            'Enviado',
            'Error'
        ])->default('Pendiente');

        $table->text('Mensaje_Error')->nullable();

        $table->timestamp('Fecha_Envio')->nullable();

        $table->foreign('ID_Proyecto')
            ->references('ID_Proyecto')
            ->on('proyectos');

        $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('correo_enviados');
    }
};
