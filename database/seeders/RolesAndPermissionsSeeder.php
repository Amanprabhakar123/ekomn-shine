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

        // Create permissions
        Permission::create(['name' => 'add_product_details']);
        Permission::create(['name' => 'edit_product_details']);
        Permission::create(['name' => 'add_connection']);
        Permission::create(['name' => 'edit_connection']);
        Permission::create(['name' => 'add_new_order']);
        Permission::create(['name' => 'edit_order']);
        Permission::create(['name' => 'add_new_return']);


        // Create role  s and assign existing permissions
        $role = Role::create(['name' => 'buyer']);
        $role->givePermissionTo('add_connection');
        $role->givePermissionTo('edit_connection');
        $role->givePermissionTo('add_new_order');
        $role->givePermissionTo('edit_order');
        $role->givePermissionTo('add_new_return');

        $role = Role::create(['name' => 'supplier']);
        $role->givePermissionTo('add_product_details');
        $role->givePermissionTo('edit_connection');

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
