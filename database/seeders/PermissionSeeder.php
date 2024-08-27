<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sub_admin_role = Role::create(['name' => ROLE_SUB_ADMIN]);
        
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

        // create all permissions
        
        Permission::create(['name' => PERMISSION_ADD_PRODUCT]);
        Permission::create(['name' => PERMISSION_LIST_PRODUCT]);
        Permission::create(['name' => PERMISSION_EDIT_PRODUCT_DETAILS]);
        Permission::create(['name' => PERMISSION_ADD_CONNCETION]);
        Permission::create(['name' => PERMISSION_EDIT_CONNCETION]);
        Permission::create(['name' => PERMISSION_ADD_NEW_ORDER]);
        Permission::create(['name' => PERMISSION_LIST_ORDER]);
        Permission::create(['name' => PERMISSION_EDIT_ORDER]);
        Permission::create(['name' => PERMISSION_CANCEL_ORDER]);
        Permission::create(['name' => PERMISSION_ADD_COURIER]);
        Permission::create(['name' => PERMISSION_LIST_COURIER]);
        Permission::create(['name' => PERMISSION_EDIT_COURIER]);
        Permission::create(['name' => PERMISSION_ORDER_TRACKING]);
        Permission::create(['name' => PERMISSION_PAYMENT_LIST]);
        Permission::create(['name' => PERMISSION_PAYMENT_EDIT]);
        Permission::create(['name' => PERMISSION_PAYMENT_EXPORT]);
        Permission::create(['name' => PERMISSION_TOP_CATEGORY]);
        Permission::create(['name' => PERMISSION_TOP_PRODUCT]);
        Permission::create(['name' => PERMISSION_BANNER]);
        Permission::create(['name' => PERMISSION_MIS_SETTING_INVENTORY]);
        Permission::create(['name' => PERMISSION_CREATE_RETURN_ORDER]);
        Permission::create(['name' => PERMISSION_LIST_RETURN_ORDER]);
        Permission::create(['name' => PERMISSION_VIEW_RETURN_ORDER]);
        Permission::create(['name' => PERMISSION_EDIT_RETURN_ORDER]);
        Permission::create(['name' => PERMISSION_USER_LIST]);


        // assign permissions Buyer
        $role = Role::findByName(ROLE_BUYER);
        $role->givePermissionTo(PERMISSION_ADD_CONNCETION);
        $role->givePermissionTo(PERMISSION_EDIT_CONNCETION);
        $role->givePermissionTo(PERMISSION_ADD_NEW_ORDER);
        $role->givePermissionTo(PERMISSION_LIST_ORDER);
        $role->givePermissionTo(PERMISSION_CANCEL_ORDER);
        $role->givePermissionTo(PERMISSION_CREATE_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_VIEW_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_LIST_RETURN_ORDER);

        // assign permissions Supplier
        $role = Role::findByName(ROLE_SUPPLIER);
        $role->givePermissionTo(PERMISSION_ADD_PRODUCT);
        $role->givePermissionTo(PERMISSION_LIST_PRODUCT);
        $role->givePermissionTo(PERMISSION_EDIT_PRODUCT_DETAILS);
        $role->givePermissionTo(PERMISSION_LIST_ORDER);
        $role->givePermissionTo(PERMISSION_CANCEL_ORDER);
        $role->givePermissionTo(PERMISSION_EDIT_ORDER);
        $role->givePermissionTo(PERMISSION_PAYMENT_LIST);
        $role->givePermissionTo(PERMISSION_PAYMENT_EXPORT);
        $role->givePermissionTo(PERMISSION_LIST_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_VIEW_RETURN_ORDER);
        $role->givePermissionTo(PERMISSION_EDIT_RETURN_ORDER);

        // assign permissions Super admin
        $role = Role::findByName(ROLE_ADMIN);
        $role->givePermissionTo(Permission::all());        
    }
}
