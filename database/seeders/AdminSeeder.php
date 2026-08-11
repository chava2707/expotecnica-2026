<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
  public function run(): void
  {
    $personaAdmin = Persona::firstOrCreate(
      ['ID_Cedula' => 12345678],
      [
        'Nombre' => 'Juan',
        'Apellido_1' => 'Perez',
        'Apellido_2' => 'Lopez',
        'Fecha_Nacimiento' => '1990-01-15',
        'Estado' => true,
      ]
    );

    $rolAdmin = Role::firstOrCreate(
      ['ID_Roles' => 1],
      [
        'Nombre_rol' => 'Administrador',
        'Descripcion_rol' => 'Rol de administrador del sistema',
        'Estado' => 'Activo',
      ]
    );

    User::firstOrCreate(
      ['email' => 'admin@test.com'],
      [
        'name' => 'Juan Perez',
        'Nombre_usuario' => 'admin',
        'IDPersona' => $personaAdmin->ID_Cedula,
        'IDrol' => $rolAdmin->ID_Roles,
        'password' => Hash::make('password'),
        'Activo' => true,
      ]
    );
  }
}
