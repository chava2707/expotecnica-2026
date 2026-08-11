<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTestSeeder extends Seeder
{
  public function run(): void
  {
    // ==========================================
    // 1. ADMINISTRADOR (Tu registro original)
    // ==========================================
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

    // ==========================================
    // 2. CREACIÓN O BÚSQUEDA DE NUEVOS ROLES
    // ==========================================
    $rolJuez = Role::firstOrCreate(
      ['Nombre_rol' => 'Juez'],
      [
        'Descripcion_rol' => 'Evaluador principal de proyectos',
        'Estado' => 'Activo',
      ]
    );

    $rolSuplente = Role::firstOrCreate(
      ['Nombre_rol' => 'Juez Suplente'],
      [
        'Descripcion_rol' => 'Evaluador suplente en caso de ausencias',
        'Estado' => 'Activo',
      ]
    );

    $rolEstudiante = Role::firstOrCreate(
      ['Nombre_rol' => 'Estudiante'],
      [
        'Descripcion_rol' => 'Estudiante expositor de proyectos',
        'Estado' => 'Activo',
      ]
    );

    // ==========================================
    // 3. DATOS DE LOS NUEVOS PARTICIPANTES
    // ==========================================

    // 3 Jueces Titulares
    $jueces = [
      ['cedula' => 50111111, 'nombre' => 'Carlos', 'ap1' => 'Alvarado', 'ap2' => 'Castro', 'email' => 'juez1@test.com'],
      ['cedula' => 50222222, 'nombre' => 'Elena', 'ap1' => 'Rodríguez', 'ap2' => 'Méndez', 'email' => 'juez2@test.com'],
      ['cedula' => 50333333, 'nombre' => 'Mauricio', 'ap1' => 'Sánchez', 'ap2' => 'Vargas', 'email' => 'juez3@test.com'],
    ];

    // 4 Jueces Suplentes
    $suplentes = [
      ['cedula' => 60111111, 'nombre' => 'Roberto', 'ap1' => 'Jiménez', 'ap2' => 'Solano', 'email' => 'suplente1@test.com'],
      ['cedula' => 60222222, 'nombre' => 'Lucía', 'ap1' => 'Fernández', 'ap2' => 'Araya', 'email' => 'suplente2@test.com'],
      ['cedula' => 60333333, 'nombre' => 'Andrés', 'ap1' => 'Salazar', 'ap2' => 'Chaves', 'email' => 'suplente3@test.com'],
      ['cedula' => 60444444, 'nombre' => 'Sofía', 'ap1' => 'Mora', 'ap2' => 'Quesada', 'email' => 'suplente4@test.com'],
    ];

    // 4 Estudiantes
    $estudiantes = [
      ['cedula' => 70111111, 'nombre' => 'Mateo', 'ap1' => 'Vargas', 'ap2' => 'Rojas', 'email' => 'estudiante1@test.com'],
      ['cedula' => 70222222, 'nombre' => 'Valeria', 'ap1' => 'Gomez', 'ap2' => 'Herrera', 'email' => 'estudiante2@test.com'],
      ['cedula' => 70333333, 'nombre' => 'Diego', 'ap1' => 'López', 'ap2' => 'Campos', 'email' => 'estudiante3@test.com'],
      ['cedula' => 70444444, 'nombre' => 'Camila', 'ap1' => 'Castro', 'ap2' => 'Murillo', 'email' => 'estudiante4@test.com'],
    ];

    // ==========================================
    // 4. BÚCLE DE INSERCIÓN AUTOMÁTICA
    // ==========================================

    // Insertar Jueces
    foreach ($jueces as $j) {
      $p = Persona::firstOrCreate(
        ['ID_Cedula' => $j['cedula']],
        ['Nombre' => $j['nombre'], 'Apellido_1' => $j['ap1'], 'Apellido_2' => $j['ap2'], 'Fecha_Nacimiento' => '1985-06-20', 'Estado' => true]
      );
      User::firstOrCreate(
        ['email' => $j['email']],
        ['name' => $j['nombre'] . ' ' . $j['ap1'], 'Nombre_usuario' => strtolower($j['nombre'] . $j['cedula']), 'IDPersona' => $p->ID_Cedula, 'IDrol' => $rolJuez->ID_Roles, 'password' => Hash::make('password'), 'Activo' => true]
      );
    }

    // Insertar Suplentes
    foreach ($suplentes as $s) {
      $p = Persona::firstOrCreate(
        ['ID_Cedula' => $s['cedula']],
        ['Nombre' => $s['nombre'], 'Apellido_1' => $s['ap1'], 'Apellido_2' => $s['ap2'], 'Fecha_Nacimiento' => '1988-04-12', 'Estado' => true]
      );
      User::firstOrCreate(
        ['email' => $s['email']],
        ['name' => $s['nombre'] . ' ' . $s['ap1'], 'Nombre_usuario' => strtolower($s['nombre'] . $s['cedula']), 'IDPersona' => $p->ID_Cedula, 'IDrol' => $rolSuplente->ID_Roles, 'password' => Hash::make('password'), 'Activo' => true]
      );
    }

    // Insertar Estudiantes
    foreach ($estudiantes as $e) {
      $p = Persona::firstOrCreate(
        ['ID_Cedula' => $e['cedula']],
        ['Nombre' => $e['nombre'], 'Apellido_1' => $e['ap1'], 'Apellido_2' => $e['ap2'], 'Fecha_Nacimiento' => '2003-09-18', 'Estado' => true]
      );
      User::firstOrCreate(
        ['email' => $e['email']],
        ['name' => $e['nombre'] . ' ' . $e['ap1'], 'Nombre_usuario' => strtolower($e['nombre'] . $e['cedula']), 'IDPersona' => $p->ID_Cedula, 'IDrol' => $rolEstudiante->ID_Roles, 'password' => Hash::make('password'), 'Activo' => true]
      );
    }
  }
}
