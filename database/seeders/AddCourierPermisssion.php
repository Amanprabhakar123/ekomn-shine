<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddCourierPermisssion extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => PERMISSION_ADD_COURIER]);
        Permission::create(['name' => PERMISSION_EDIT_COURIER]);
        Permission::create(['name' => PERMISSION_LIST_COURIER]);
        Permission::create(['name' => PERMISSION_ORDER_TRACKING]);

        // assign permission to admin role
        $role = Role::findByName(ROLE_ADMIN);
        $role->givePermissionTo(Permission::all());

    }
}
