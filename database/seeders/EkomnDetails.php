<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EkomnDetails extends Seeder
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

        foreach ($ekomnDetails as $ekomnDetail) {
            \App\Models\EkomnDetails::create($ekomnDetail);
        }
    }
}
