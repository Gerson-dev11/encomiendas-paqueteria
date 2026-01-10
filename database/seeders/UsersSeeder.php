<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');

        DB::table('users')->insert([
            'full_name' => 'System Administrator',
            'email' => 'admin@local.test',
            'phone' => '+50370000000',
            'password' => Hash::make('password'),
            'role_id' => $adminRoleId,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}

