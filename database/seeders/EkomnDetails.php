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
                'address' => 'Ekomn Address',
                'pincode' => '123456',
                'city' => 'Ekomn City',
                'state' => 'Ekomn State',
                'contact' => '1234567890',
                'email' => 'ekomn@gmail.com',
                'gst' => '1234567890',
            ],
        ];

        foreach ($ekomnDetails as $ekomnDetail) {
            \App\Models\EkomnDetails::create($ekomnDetail);
        }
    }
}
