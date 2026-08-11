<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rubrica;

class RubricaSeeder extends Seeder
{
    public function run(): void
    {
        Rubrica::firstOrCreate(
            ['Nombre' => 'Exposición'],
            [
                'Estado' => 'Activo',
            ]
        );

        Rubrica::firstOrCreate(
            ['Nombre' => 'Trabajo Escrito'],
            [
                'Estado' => 'Activo',
            ]
        );
    }
}