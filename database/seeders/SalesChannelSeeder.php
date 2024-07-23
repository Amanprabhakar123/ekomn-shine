<?php

namespace Database\Seeders;

use App\Models\SalesChannel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salesChanelData = [
            [
            'name' => 'Amazon',
            'is_active' => true,
            ],
            [
            'name' => 'Flipkart',
            'is_active' => false,
            ],
            [
            'name' => 'Jiomart',
            'is_active' => false,
            ],
            [
            'name' => 'Meesho',
            'is_active' => false,
            ],
            [
            'name' => 'Social Media',
            'is_active' => false,
            ],
            [
            'name' => 'Own Store',
            'is_active' => true,
            ],
        ];

        SalesChannel::insert($salesChanelData);
    }
}
