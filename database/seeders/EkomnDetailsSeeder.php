<?php

namespace Database\Seeders;

use App\Models\EkomnDetails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EkomnDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ekomnDetails = [
            [
                'ekomn_name' => 'Ekomn',
                'address' => 'Ocus Quantum, Ocus Quantum Internal Rd, Sector 51,',
                'pincode' => '122003',
                'city' => 'Gurugram',
                'state' => 'Haryana',
                'contact' => '+91 9810164845',
                'email' => 'info@ekomn.com',
                'gst' => '1234567890',
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        EkomnDetails::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        foreach ($ekomnDetails as $ekomnDetail) {
            EkomnDetails::create($ekomnDetail);
        }
    }
}
