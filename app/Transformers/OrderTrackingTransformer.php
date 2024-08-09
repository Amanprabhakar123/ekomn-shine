<?php
namespace App\Transformers;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class OrderTrackingTransformer extends TransformerAbstract
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
            $title = '';
            $slug = '';
            foreach($order->orderItemsCharges as $orderItemsCharges){
                $title = $orderItemsCharges->product->title;
                $slug = $orderItemsCharges->product->slug;
            }
            $courier_name = '';
            $tracking_url = '';
            $tracking_number = '';
            //
            $shipment = $order->shipments->first();
            if($shipment){
                $courier_name = $shipment->courier->courier_name;
                $shipmet_awb = $shipment->shipmentAwb()->first();
                if($shipment->courier->id == 1){
                    $courier_name = '('. $courier_name.') - ' .$shipmet_awb->courier_provider_name;
                }
                $tracking_number = $shipmet_awb->awb_number;
                $tracking_url = str_replace('{awb}', $tracking_number, $shipment->courier->tracking_url);
            }
            $data = [
                'id' => salt_encrypt($order->id),
                'title' => $title,
                'link' => url($slug),
                'order_number' => $order->order_number,
                'order_date' => $order->order_date->toDateString(),
                'status' => $order->getStatus(),
                'order_action_status' => $order->status,
                'order_type' => $order->getOrderType(),
                'view_order' => route('view.order', salt_encrypt($order->id)),
                'courier_name' => $courier_name,
                'tracking_url' => $tracking_url,
                'tracking_number' => $tracking_number,
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
