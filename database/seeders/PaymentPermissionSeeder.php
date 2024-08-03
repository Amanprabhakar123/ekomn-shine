<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PaymentPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => PERMISSION_PAYMENT_LIST]);
        Permission::create(['name' => PERMISSION_PAYMENT_EDIT]);
        Permission::create(['name' => PERMISSION_PAYMENT_EXPORT]);

        // assign permission to supplier role
        $role = Role::findByName(ROLE_SUPPLIER);
        $role->givePermissionTo([PERMISSION_PAYMENT_LIST, PERMISSION_PAYMENT_EXPORT]);
        // assign permission to admin role
        $role = Role::findByName(ROLE_ADMIN);
        $role->givePermissionTo(Permission::all());
    }
}
