<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReturnOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => PERMISSION_CREATE_RETURN_ORDER]);
        Permission::create(['name' => PERMISSION_LIST_RETURN_ORDER]);
        Permission::create(['name' => PERMISSION_VIEW_RETURN_ORDER]);
        Permission::create(['name' => PERMISSION_EDIT_RETURN_ORDER]);
      
        // assign permission to admin role
        $role = Role::findByName(ROLE_BUYER);
        $role->givePermissionTo(PERMISSION_CREATE_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_VIEW_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_LIST_RETURN_ORDER);

        $role = Role::findByName(ROLE_SUPPLIER);
        $role->givePermissionTo(PERMISSION_LIST_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_VIEW_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_EDIT_RETURN_ORDER);

        $role = Role::findByName(ROLE_ADMIN);
        $role->givePermissionTo(PERMISSION_CREATE_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_LIST_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_VIEW_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_EDIT_RETURN_ORDER);
        
        
    }

   
}
