<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class MisAdminPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => PERMISSION_TOP_CATEGORY]);
        Permission::create(['name' => PERMISSION_TOP_PRODUCT]);
        Permission::create(['name' => PERMISSION_BANNER]);

        // assign permission to admin role
        $role = Role::findByName(ROLE_ADMIN);
        $role->givePermissionTo(Permission::all());
    }
}
