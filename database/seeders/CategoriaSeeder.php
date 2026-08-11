<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'Nombre' => 'Steam',
                'Descripcion' => 'Proyectos enfocados en ciencia, tecnología, ingeniería, arte y matemáticas.',
            ],
            [
                'Nombre' => 'Emprendimiento',
                'Descripcion' => 'Proyectos de innovación empresarial, modelos de negocio y emprendedurismo.',
            ],
            [
                'Nombre' => 'Inglés',
                'Descripcion' => 'Proyectos con dominio lingüístico en inglés (evaluación de exposición).',
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate(
                ['Nombre' => $categoria['Nombre']],
                [
                    'Descripcion' => $categoria['Descripcion'],
                ]
            );
        }
    }
}