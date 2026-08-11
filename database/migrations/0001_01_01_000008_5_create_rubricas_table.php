<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rubricas', function (Blueprint $table) {

            $table->id('ID_Rubrica');

            $table->string('Nombre',255);

            $table->string('Estado',255)->default('Activo');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rubricas');
    }
};