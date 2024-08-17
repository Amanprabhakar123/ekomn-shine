<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthUserLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $buyer = User::create([
            'id' => 1, // If your table uses auto-increment for ID, you can omit this field
            'name' => 'buyer',
            'email' => 'buyer@yopmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('Test@123'), // Change to a hashed password
        ]);
        $buyer->assignRole(User::ROLE_BUYER);

        $suppleir = User::create([
            'id' => 2, // If your table uses auto-increment for ID, you can omit this field
            'name' => 'supplier',
            'email' => 'supplier@yopmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('Test@123'), // Change to a hashed password
        ]);
        $suppleir->assignRole(User::ROLE_SUPPLIER);

        $admin = User::create([
            'id' => 3, // If your table uses auto-increment for ID, you can omit this field
            'name' => 'Ekomn Admin',
            'email' => 'ekomnops@ekomn.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('Test@123'), // Change to a hashed password
        ]);
        $admin->assignRole(User::ROLE_ADMIN);
    }
}
