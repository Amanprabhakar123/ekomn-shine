<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Charges;

class AddTDSCharges extends Seeder
{

    const TDS = 'TDS';
    const TCS = 'TCS';

    // Constants for Order Types
    const DROPSHIP = 'Dropship';
    const BULK = 'Bulk';
    const RESELL = 'Resell';

    // GST Bracket Constant
    const GST_BRACKET = '0';
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $charges = [
            [self::TDS, '', self::GST_BRACKET, self::DROPSHIP, '', '1'],
            [self::TCS, '', self::GST_BRACKET, self::DROPSHIP, '', '1'],
            [self::TDS, '', self::GST_BRACKET, self::BULK, '', '1'],
            [self::TCS, '', self::GST_BRACKET, self::BULK, '', '1'],
            [self::TDS, '', self::GST_BRACKET, self::RESELL, '', '1'],
            [self::TCS, '', self::GST_BRACKET, self::RESELL, '', '1'],
        ];

        foreach ($charges as $charge) {
            Charges::create([
                'other_charges' => $charge[0],
                'hsn' => $charge[1],
                'gst_bracket' => $charge[2],
                'category' => $charge[3],
                'range' => $charge[4],
                'value' => $charge[5]
            ]);
        }
    }
}
