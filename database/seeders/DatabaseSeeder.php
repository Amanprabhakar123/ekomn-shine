<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\PlanSeeder;
use Database\Seeders\CourierList;
use Database\Seeders\EkomnDetails;
use Database\Seeders\AddTDSCharges;
use Database\Seeders\PincodeSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CanHandleSeeder;
use Database\Seeders\OrdersTableSeeder;
use Database\Seeders\BusinessTypeSeeder;
use Database\Seeders\ChargesTableSeeder;
use Database\Seeders\CompanyBuyerSeeder;
use Database\Seeders\SalesChannelSeeder;
use Database\Seeders\AuthUserLoginSeeder;
use Database\Seeders\ImportWorldSqlSeeder;
use Database\Seeders\AddCourierPermisssion;
use Database\Seeders\CompanySupplierSeeder;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\PaymentPermissionSeeder;
use Database\Seeders\UserListPermissionSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(AuthUserLoginSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(CanHandleSeeder::class);
        $this->call(BusinessTypeSeeder::class);
        $this->call(SalesChannelSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(CompanySupplierSeeder::class);
        $this->call(CompanyBuyerSeeder::class);
        $this->call(ChargesTableSeeder::class);
        $this->call(ImportWorldSqlSeeder::class);
        $this->call(PincodeSeeder::class);
        $this->call(CourierList::class);
        $this->call(AddCourierPermisssion::class);
        $this->call(PaymentPermissionSeeder::class);
        $this->call(AddTDSCharges::class);
        $this->call(MisAdminPermission::class);
        $this->call(EkomnDetails::class);
        $this->call(UserListPermissionSeeder::class);
        // $this->call(OrdersTableSeeder::class);
        
        // $this->call(ProductSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
