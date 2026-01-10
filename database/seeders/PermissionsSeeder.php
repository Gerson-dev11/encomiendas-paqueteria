<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Esto conecta directo con Policies/Gates después.
 */

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permissions')->insert([
            // Users
            ['name' => 'Create users', 'slug' => 'users.create', 'group_name' => 'users'],
            ['name' => 'Edit users', 'slug' => 'users.edit', 'group_name' => 'users'],
            ['name' => 'View users', 'slug' => 'users.view', 'group_name' => 'users'],

            // Reports
            ['name' => 'View reports', 'slug' => 'reports.view', 'group_name' => 'reports'],
        ]);
    }
}

