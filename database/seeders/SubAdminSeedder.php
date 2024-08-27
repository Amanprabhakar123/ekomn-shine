<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Contracts\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubAdminSeedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => ROLE_SUB_ADMIN]);

        
    }
}
