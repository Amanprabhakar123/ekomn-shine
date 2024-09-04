<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => PERMISSION_SUBSCRIPTION_LIST]);
        Permission::create(['name' => PERMISSION_SUBSCRIPTION_VIEW]);
        Permission::create(['name' => PERMISSION_PLAN_LIST]);
        Permission::create(['name' => PERMISSION_PLAN_EDIT]);


        $role = Role::findByName(ROLE_ADMIN);
        $role->givePermissionTo(PERMISSION_SUBSCRIPTION_LIST);
        $role->givePermissionTo(PERMISSION_PLAN_LIST);
        $role->givePermissionTo(PERMISSION_PLAN_EDIT);

        $role_buyer = Role::findByName(ROLE_BUYER);
        $role_buyer->givePermissionTo(PERMISSION_SUBSCRIPTION_VIEW);
        
    }
}
