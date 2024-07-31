<?php

namespace Database\Seeders;

use App\Models\CourierDetails;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourierList extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'courier_name' => 'Other',
                'tracking_url' => '',
            ],
            [
                'courier_name' => 'DHL',
                'tracking_url' => 'https://www.dhl.com/en/express/tracking.html?AWB={awb}',
            ],
            [
                'courier_name' => 'Shiprocket',
                'tracking_url' => 'https://shiprocket.co/tracking/{awb}',
            ],
            [
                'courier_name' => 'Bludart',
                'tracking_url' => 'https://www.bluedart.com/maintracking.html#/track/{awb}',
            ],
            [
                'courier_name' => 'Delhivery',
                'tracking_url' => 'https://www.delhivery.com/track/package/',
            ],
            [
                'courier_name' => 'Gati',
                'tracking_url' => 'https://www.gati.com/track/',
            ],
            [
                'courier_name' => 'India Post',
                'tracking_url' => 'https://www.indiapost.gov.in/_layouts/15/dop.portal.tracking/trackconsignment.aspx',
            ],
            [
                'courier_name' => 'Ekart',
                'tracking_url' => 'https://www.ekartlogistics.com/track/',
            ],
            [
                'courier_name' => 'Amazon',
                'tracking_url' => 'https://www.amazon.com/progress-tracker/package/ref=oh_aui_detailpage_o00_s00?ie=UTF8&itemId=',
            ],
            [
                'courier_name' => 'Flipkart',
                'tracking_url' => 'https://www.flipkart.com/track/',
            ],
        ];

        foreach ($data as $item) {
            CourierDetails::create($item);
        }
    }
}
