<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmpleadosSeeder extends Seeder
{
    public function run()
    {

        $admin = DB::table('roles')->where('nombre_rol', 'admin')->first();

        DB::table('empleados')->insert([
            'nombre_completo' => 'Super Admin',
            'correo' => 'admin@max.com',
            'telefono' => '0000-0000',
            'dui' => '00000000-0',
            'password' => Hash::make('PasswordUltraSeguro123'),
            'rol_id' => 1,
            'fecha_contratacion' => now(),
            'creado_el' => now(),
        ]);
    }
}