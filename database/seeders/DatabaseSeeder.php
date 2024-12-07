<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\File;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        // Crear 10 usuarios
        User::factory(10)->create();

        // Crear 5 proyectos
        Project::factory(5)->create();

        // Crear 10 archivos asociados a proyectos
        File::factory(10)->create();

        // Crear 20 comentarios asociados a proyectos
        Comment::factory(20)->create();


    }
}
