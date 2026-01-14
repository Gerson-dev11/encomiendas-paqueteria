<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        $operatorRoleId = DB::table('roles')->where('name', 'operator')->value('id');

        $permissions = DB::table('permissions')->pluck('id');

        // Admin → todos los permisos
        foreach ($permissions as $permissionId) {
            DB::table('permissions_role')->insert([
                'role_id' => $adminRoleId,
                'permission_id' => $permissionId,
            ]);
        }

        // Operator → solo ver usuarios
        $viewUsersPermission = DB::table('permissions')
            ->where('slug', 'users.view')
            ->value('id');

        DB::table('permissions_role')->insert([
            'role_id' => $operatorRoleId,
            'permission_id' => $viewUsersPermission,
        ]);
    }
}