<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolesSeeder extends Seeder {
    public function run() {
        DB::table('roles')->insert([
            ['rol_id' => 1, 'nombre_rol' => 'admin', 'nivel_acceso' => 10],
            ['rol_id' => 2, 'nombre_rol' => 'empleado', 'nivel_acceso' => 5],
        ]);
    }
}