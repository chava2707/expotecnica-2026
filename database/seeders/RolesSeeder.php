<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
  public function run(): void
  {
    $roles = [
      ['ID_Roles' => 1, 'Nombre_rol' => 'Administrador', 'Descripcion_rol' => 'Rol de administrador del sistema', 'Estado' => 'Activo'],
      ['Nombre_rol' => 'Juez', 'Descripcion_rol' => 'Evaluador principal de proyectos', 'Estado' => 'Activo'],
      ['Nombre_rol' => 'Juez Suplente', 'Descripcion_rol' => 'Evaluador suplente en caso de ausencias', 'Estado' => 'Activo'],
      ['Nombre_rol' => 'Estudiante', 'Descripcion_rol' => 'Estudiante expositor de proyectos', 'Estado' => 'Activo'],
    ];

    foreach ($roles as $rol) {
      Role::firstOrCreate(
        array_key_exists('ID_Roles', $rol) ? ['ID_Roles' => $rol['ID_Roles']] : ['Nombre_rol' => $rol['Nombre_rol']],
        $rol
      );
    }
  }
}
