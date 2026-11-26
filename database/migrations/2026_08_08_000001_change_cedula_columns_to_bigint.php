<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['IDPersona']);
        });
        Schema::table('telefonos', function (Blueprint $table) {
            $table->dropForeign(['IDPersona']);
        });
        Schema::table('correos', function (Blueprint $table) {
            $table->dropForeign(['IDPersona']);
        });

        // MySQL necesita MODIFY COLUMN; otros motores (SQLite en pruebas) ya
        // almacenan los enteros como 64 bits.
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE personas MODIFY COLUMN ID_Cedula BIGINT NOT NULL');
        }

        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('IDPersona')->nullable()->change();
        });
        Schema::table('telefonos', function (Blueprint $table) {
            $table->bigInteger('IDPersona')->change();
        });
        Schema::table('correos', function (Blueprint $table) {
            $table->bigInteger('IDPersona')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('IDPersona')->references('ID_Cedula')->on('personas');
        });
        Schema::table('telefonos', function (Blueprint $table) {
            $table->foreign('IDPersona')->references('ID_Cedula')->on('personas');
        });
        Schema::table('correos', function (Blueprint $table) {
            $table->foreign('IDPersona')->references('ID_Cedula')->on('personas');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['IDPersona']);
        });
        Schema::table('telefonos', function (Blueprint $table) {
            $table->dropForeign(['IDPersona']);
        });
        Schema::table('correos', function (Blueprint $table) {
            $table->dropForeign(['IDPersona']);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE personas MODIFY COLUMN ID_Cedula INT NOT NULL');
        }

        Schema::table('users', function (Blueprint $table) {
            $table->integer('IDPersona')->nullable()->change();
        });
        Schema::table('telefonos', function (Blueprint $table) {
            $table->integer('IDPersona')->change();
        });
        Schema::table('correos', function (Blueprint $table) {
            $table->integer('IDPersona')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('IDPersona')->references('ID_Cedula')->on('personas');
        });
        Schema::table('telefonos', function (Blueprint $table) {
            $table->foreign('IDPersona')->references('ID_Cedula')->on('personas');
        });
        Schema::table('correos', function (Blueprint $table) {
            $table->foreign('IDPersona')->references('ID_Cedula')->on('personas');
        });
    }
};
