<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Revoke permissions from all users
        foreach (Permission::all() as $permission) {
            $permission->users()->detach();
            $permission->roles()->detach();
        }
        // Delete all permissions
        Permission::query()->delete();

        // Revoke roles from all users
        foreach (Role::all() as $role) {
            $role->users()->detach();
            $role->permissions()->detach();
        }
        // Delete all roles
        Role::query()->delete();
        
        // Create permissions
        Permission::create(['name' => PERMISSION_ADD_PRODUCT]);
        Permission::create(['name' => PERMISSION_LIST_PRODUCT]);
        Permission::create(['name' => PERMISSION_EDIT_PRODUCT_DETAILS]);
        Permission::create(['name' => PERMISSION_ADD_CONNCETION]);
        Permission::create(['name' => PERMISSION_EDIT_CONNCETION]);
        Permission::create(['name' => PERMISSION_ADD_NEW_ORDER]);
        Permission::create(['name' => PERMISSION_LIST_ORDER]);
        Permission::create(['name' => PERMISSION_EDIT_ORDER]);
        Permission::create(['name' => PERMISSION_CANCEL_ORDER]);
        Permission::create(['name' => PERMISSION_ADD_NEW_RETURN]);


        // Create role  s and assign existing permissions
        $role = Role::create(['name' => ROLE_BUYER]);
        $role->givePermissionTo(PERMISSION_ADD_CONNCETION);
        $role->givePermissionTo(PERMISSION_EDIT_CONNCETION);
        $role->givePermissionTo(PERMISSION_ADD_NEW_ORDER);
        $role->givePermissionTo(PERMISSION_LIST_ORDER);
        $role->givePermissionTo(PERMISSION_CANCEL_ORDER);
        $role->givePermissionTo(PERMISSION_ADD_NEW_RETURN);

        $role = Role::create(['name' => ROLE_SUPPLIER]);
        $role->givePermissionTo(PERMISSION_ADD_PRODUCT);
        $role->givePermissionTo(PERMISSION_LIST_PRODUCT);
        $role->givePermissionTo(PERMISSION_EDIT_PRODUCT_DETAILS);
        $role->givePermissionTo(PERMISSION_LIST_ORDER);
        $role->givePermissionTo(PERMISSION_CANCEL_ORDER);
        $role->givePermissionTo(PERMISSION_EDIT_ORDER);

        $role = Role::create(['name' => ROLE_ADMIN]);
        $role->givePermissionTo(Permission::all());
    }
}
