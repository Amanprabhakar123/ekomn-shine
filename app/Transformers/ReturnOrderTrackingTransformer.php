<?php
namespace App\Transformers;
use App\Models\User;
use App\Models\ReturnShipment;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class ReturnOrderTrackingTransformer extends TransformerAbstract
{
    /**
     * Transform the given Order model into a formatted array.
     *
     * @param  Order  $order
     * @return array
     */
    public function transform(ReturnShipment $returnShipment)
    {
        try {
            $title = '';
            $slug = '';
            foreach($returnShipment->order->orderItemsCharges as $orderItemsCharges){
                $title = $orderItemsCharges->product->title;
                $slug = $orderItemsCharges->product->slug;
            }
            $courier_name = $returnShipment->courier->courier_name;
            if($returnShipment->courier->id == 1){
                $courier_name = '('. $courier_name.') - ' .$returnShipment->provider_name;
            }
            
            $data = [
                'id' => salt_encrypt($returnShipment->id),
                'return_number' => $returnShipment->return->return_number,
                'order_number' => $returnShipment->order->order_number,
                'title' => $title,
                'courier_type' => $returnShipment->getCourierType(),
                'courier_name' => $courier_name,
                'tracking_number' => $returnShipment->awb_number,
                'status' => $returnShipment->getShipmentStatus(),
                'order_action_status' => $returnShipment->status,
                'link' => route('product.details', $slug),
                'view_order' => route('view.order', salt_encrypt($returnShipment->id)),
                'view_return' => route('edit.return.order', salt_encrypt($returnShipment->return->id)),
                'tracking_url' =>  str_replace('{awb}', $returnShipment->awb_number, $returnShipment->courier->tracking_url)
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
