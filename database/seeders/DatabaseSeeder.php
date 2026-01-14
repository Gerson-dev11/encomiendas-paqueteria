<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
=======
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UsersSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

>>>>>>> 6d71e0d (Cosas Realizadas: 1. Migrations y Seeders Configuradas establecidas y testeadas 2. Declaraciones de las reglas del negocios ENTITY 3. Desarrollo de los Modelos)
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
<<<<<<< HEAD

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
=======
    $this->call([
        RolesSeeder::class,
        PermissionsSeeder::class,
        RolePermissionSeeder::class,  
        UsersSeeder::class,  
    ]);

        // If you want to create a default user via a model factory, ensure the model exists
        // and has the namespace App\Models\User, otherwise remove or adapt this.
>>>>>>> 6d71e0d (Cosas Realizadas: 1. Migrations y Seeders Configuradas establecidas y testeadas 2. Declaraciones de las reglas del negocios ENTITY 3. Desarrollo de los Modelos)
    }
}
