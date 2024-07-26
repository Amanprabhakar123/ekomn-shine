<?php

namespace Database\Seeders;

use App\Models\Charges;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChargesTableSeeder extends Seeder
{
    // Constants for Other Charges
    const SHIPPING_CHARGES = 'Shipping charges';
    const PACKING_CHARGES = 'Packing charges';
    const LABOUR_CHARGES = 'Labour Charges';
    const PROCESSING_CHARGES = 'Processing Charges';
    const REFERRAL_CHARGES = 'Referral Charges';

    // Constants for Order Types
    const DROPSHIP = 'Dropship';
    const BULK = 'Bulk';
    const RESELL = 'Resell';

    // GST Bracket Constant
    const GST_BRACKET = '18';

    public function run()
    {
        $charges = [
            [self::SHIPPING_CHARGES, '996511', self::GST_BRACKET, self::DROPSHIP, '0 to 300', 'Auto'],
            [self::SHIPPING_CHARGES, '996511', self::GST_BRACKET, self::DROPSHIP, '301 to 1000', 'Auto'],
            [self::SHIPPING_CHARGES, '996511', self::GST_BRACKET, self::DROPSHIP, '>1000', 'Auto'],
            [self::SHIPPING_CHARGES, '996511', self::GST_BRACKET, self::BULK, '0 to 2000', 'Auto'],
            [self::SHIPPING_CHARGES, '996511', self::GST_BRACKET, self::BULK, '2001 to 10000', 'Auto'],
            [self::SHIPPING_CHARGES, '996511', self::GST_BRACKET, self::BULK, '>10000', 'Auto'],
            [self::SHIPPING_CHARGES, '996511', self::GST_BRACKET, self::RESELL, '0 to 2000', 'Auto'],
            [self::SHIPPING_CHARGES, '996511', self::GST_BRACKET, self::RESELL, '2001 to 10000', 'Auto'],
            [self::SHIPPING_CHARGES, '996511', self::GST_BRACKET, self::RESELL, '>10000', 'Auto'],
            [self::PACKING_CHARGES, '39231010', self::GST_BRACKET, self::DROPSHIP, '0 to 300', 5],
            [self::PACKING_CHARGES, '39231010', self::GST_BRACKET, self::DROPSHIP, '301 to 1000', 8],
            [self::PACKING_CHARGES, '39231010', self::GST_BRACKET, self::DROPSHIP, '>1000', 10],
            [self::PACKING_CHARGES, '39231010', self::GST_BRACKET, self::BULK, '0 to 2000', 35],
            [self::PACKING_CHARGES, '39231010', self::GST_BRACKET, self::BULK, '2001 to 10000', 60],
            [self::PACKING_CHARGES, '39231010', self::GST_BRACKET, self::BULK, '>10000', 90],
            [self::PACKING_CHARGES, '39231010', self::GST_BRACKET, self::RESELL, '0 to 2000', 35],
            [self::PACKING_CHARGES, '39231010', self::GST_BRACKET, self::RESELL, '2001 to 10000', 60],
            [self::PACKING_CHARGES, '39231010', self::GST_BRACKET, self::RESELL, '>10000', 90],
            [self::LABOUR_CHARGES, '39231010', self::GST_BRACKET, self::DROPSHIP, '0 to 300', 0],
            [self::LABOUR_CHARGES, '39231010', self::GST_BRACKET, self::DROPSHIP, '301 to 1000', 0],
            [self::LABOUR_CHARGES, '39231010', self::GST_BRACKET, self::DROPSHIP, '>1000', 0],
            [self::LABOUR_CHARGES, '39231010', self::GST_BRACKET, self::BULK, '0 to 2000', 10],
            [self::LABOUR_CHARGES, '39231010', self::GST_BRACKET, self::BULK, '2001 to 10000', 20],
            [self::LABOUR_CHARGES, '39231010', self::GST_BRACKET, self::BULK, '>10000', 30],
            [self::LABOUR_CHARGES, '39231010', self::GST_BRACKET, self::RESELL, '0 to 2000', 10],
            [self::LABOUR_CHARGES, '39231010', self::GST_BRACKET, self::RESELL, '2001 to 10000', 20],
            [self::LABOUR_CHARGES, '39231010', self::GST_BRACKET, self::RESELL, '>10000', 30],

            [self::REFERRAL_CHARGES, '998599', self::GST_BRACKET, self::DROPSHIP, '0 to 300', '0'],
            [self::REFERRAL_CHARGES, '998599', self::GST_BRACKET, self::DROPSHIP, '301 to 1000', '0'],
            [self::REFERRAL_CHARGES, '998599', self::GST_BRACKET, self::DROPSHIP, '>1000', '0'],
            [self::REFERRAL_CHARGES, '998599', self::GST_BRACKET, self::BULK, '0 to 2000', '0'],
            [self::REFERRAL_CHARGES, '998599', self::GST_BRACKET, self::BULK, '2001 to 10000', '0'],
            [self::REFERRAL_CHARGES, '998599', self::GST_BRACKET, self::BULK, '>10000', '0'],
            [self::REFERRAL_CHARGES, '998599', self::GST_BRACKET, self::RESELL, '0 to 2000', '0'],
            [self::REFERRAL_CHARGES, '998599', self::GST_BRACKET, self::RESELL, '2001 to 10000', '0'],
            [self::REFERRAL_CHARGES, '998599', self::GST_BRACKET, self::RESELL, '>10000', '0'],

            [self::PROCESSING_CHARGES, '85192000', self::GST_BRACKET, self::DROPSHIP, '0 to 300', '2'],
            [self::PROCESSING_CHARGES, '85192000', self::GST_BRACKET, self::DROPSHIP, '301 to 1000', '2'],
            [self::PROCESSING_CHARGES, '85192000', self::GST_BRACKET, self::DROPSHIP, '>1000', '2'],
            [self::PROCESSING_CHARGES, '85192000', self::GST_BRACKET, self::BULK, '0 to 2000', '2'],
            [self::PROCESSING_CHARGES, '85192000', self::GST_BRACKET, self::BULK, '2001 to 10000', '2'],
            [self::PROCESSING_CHARGES, '85192000', self::GST_BRACKET, self::BULK, '>10000', '2'],
            [self::PROCESSING_CHARGES, '85192000', self::GST_BRACKET, self::RESELL, '0 to 2000', '2'],
            [self::PROCESSING_CHARGES, '85192000', self::GST_BRACKET, self::RESELL, '2001 to 10000', '2'],
            [self::PROCESSING_CHARGES, '85192000', self::GST_BRACKET, self::RESELL, '>10000', '2']
        ];
        // dd($charges);

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
