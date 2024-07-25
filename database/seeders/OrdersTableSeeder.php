<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderAddress;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'buyer_id' => 1,
            'supplier_id' => 1,
            'order_date' => Carbon::now(),
            'status' => 1,
            'total_amount' => 100.00,
            'discount' => 10.00,
            'payment_status' => 2,
            'payment_currency' => 1,
            'order_type' => Order::ORDER_TYPE_DROPSHIP,
            'order_channel_type' => Order::ORDER_CHANNEL_TYPE_MANUAL,
            'payment_method' => 2,
            'is_cancelled' => 0,
            'cancelled_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ]);

        $billingOrder =OrderAddress::create([
            'order_id' => $order->id,
            'buyer_id' => 1,
            'street' => '123 Main St',
            'city' => 'Agra',
            'state' => 'UP',
            'postal_code' => '10001',
            'country' => 'IN',
            'address_type' => OrderAddress::TYPE_BILLING_ADDRESS,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ]);

        $shippingOrder = OrderAddress::create([
            'order_id' => $order->id,
            'buyer_id' => 1,
            'street' => '123 Main St',
            'city' => 'Agra',
            'state' => 'UP',
            'postal_code' => '10002',
            'country' => 'IN',
            'address_type' => OrderAddress::TYPE_DELIVERY_ADDRESS,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ]);

        $pickUpAddress = OrderAddress::create([
            'order_id' => $order->id,
            'buyer_id' => 1,
            'street' => '123 Main St',
            'city' => 'Agra',
            'state' => 'UP',
            'postal_code' => '10002',
            'country' => 'IN',
            'address_type' => OrderAddress::TYPE_PICKUP_ADDRESS,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ]);

        $order->shipping_address_id = $shippingOrder->id;
        $order->billing_address_id = $billingOrder->id;
        $order->pickup_address_id = $pickUpAddress->id;
        $order->save();

        
    }
}
