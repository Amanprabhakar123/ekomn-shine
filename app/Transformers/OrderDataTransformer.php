<?php
namespace App\Transformers;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class OrderDataTransformer extends TransformerAbstract
{
    /**
     * Transform the given Order model into a formatted array.
     *
     * @param  Order  $order
     * @return array
     */
    public function transform(Order $order)
    {
        try {
            $quantity = 0;
            $title = '';
            foreach($order->orderItemsCharges as $orderItemsCharges){
                $quantity += $orderItemsCharges->quantity;
                $title = $orderItemsCharges->product->title;
            }
            $data = [
                'id' => salt_encrypt($order->id),
                'title' => $title,
                'order_no' => $order->order_number,
                'store_order' => $order->store_order,
                // 'costomer_name' => $order->customer_name,
                'quantity' => $quantity,
                'order_date' => $order->order_date,
                'total_amount' => $order->total_amount,
                'order_type' => $order->order_type,
                'status' => $order->status,
                'pickup_address_id' => $order->pickup_address_id,
                'order_type' => $order->getOrderType(),
                'status' => $order->getPaymentStatus(),
                'order_channel_type' => $order->getOrderChannelType(),
    
            ];

            // if(auth()->user()->hasRole(User::ROLE_BUYER)){
            //     $data['buyer_id'] = salt_encrypt($order->buyer_id);
            //     $data['supplier_id'] = salt_encrypt($order->supplier_id);
            // }
            return $data;
        } catch (\Exception $e) {
            // Handle the exception here
            // You can log the error, return a default value, or throw a custom exception
            // For example, you can log the error and return an empty array
            Log::error('Error transforming Order: ' . $e->getMessage());
            return [];
        }
    }
}
