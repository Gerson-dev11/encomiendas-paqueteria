<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UsersSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
    $this->call([
        RolesSeeder::class,
        PermissionsSeeder::class,
        RolePermissionSeeder::class,  
        UsersSeeder::class,  
    ]);

        // If you want to create a default user via a model factory, ensure the model exists
        // and has the namespace App\Models\User, otherwise remove or adapt this.
    }
}
