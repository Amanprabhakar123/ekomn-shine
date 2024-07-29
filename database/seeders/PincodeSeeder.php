<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pincode;
use Illuminate\Support\Facades\Storage;

class PincodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $filePath = storage_path('app/public/pincode/pincode.csv');
        $filePath = 'pincode.csv';
        $file = fopen($filePath, 'r');

        // Skip the first row (header)
        fgetcsv($file);

        while (($data = fgetcsv($file)) !== false) {
            Pincode::updateOrcreate(['pincode' => $data[0]], [
                'pincode' => $data[0],
                'district' => ucwords(strtolower($data[1])),
                'state' => ucwords(strtolower($data[2])),
                'latitude' => $data[3],
                'longitude' => $data[4],
            ]);
        }

        fclose($file);
        
    }
}
