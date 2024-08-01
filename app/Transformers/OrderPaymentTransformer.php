<?php
namespace App\Transformers;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class OrderPaymentTransformer extends TransformerAbstract
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

            $data = [
               'id' => salt_encrypt($order->id),
                'order_no' => $order->order_number,
                'store_order' => !is_null($order->store_order) ? $order->store_order : '' ,
                'customer_name' => $order->full_name,
                'order_date' => $order->order_date->toDateString(),
                'total_amount' => $order->total_amount,
                'status' => $order->getStatus(),
                'order_type' => $order->getOrderType(),
                'payment_status' => $order->getPaymentStatus(),
                'order_channel_type' => $order->getOrderChannelType(),
                'view_order' => route('view.order', salt_encrypt($order->id)),
                'created_at' => $order->created_at->toDateTimeString(),
                'updated_at' => $order->updated_at->toDateTimeString(),
            ];
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