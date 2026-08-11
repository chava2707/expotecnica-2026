<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            RubricaSeeder::class,
            CategoriaSeeder::class,
            ApartadoPreguntaSeeder::class,
            RolesSeeder::class,
            AdminSeeder::class,
        ];

        if (!app()->environment('production')) {
            $seeders[] = UserTestSeeder::class;
        }

        $this->call($seeders);
    }
}
