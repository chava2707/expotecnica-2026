<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('IDPersona')->references('ID_Cedula')->on('personas');
            $table->foreign('IDrol')->references('ID_Roles')->on('roles');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['IDPersona']);
            $table->dropForeign(['IDrol']);
        });
    }
};
