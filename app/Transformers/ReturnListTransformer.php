<?php
namespace App\Transformers;

use App\Models\ReturnOrder;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class ReturnListTransformer extends TransformerAbstract
{
    /**
     * Transform the given Category model into a formatted array.
     *
     * @param  ReturnOrder  $category
     * @return array
     */
    public function transform(ReturnOrder $returnOrder)
    {
        try {
            $quantity = 0;
            $title = '';
            $slug = '';
            foreach($returnOrder->order->orderItemsCharges as $orderItemsCharges){
                $quantity += $orderItemsCharges->quantity;
                $title = $orderItemsCharges->product->title;
                $slug = $orderItemsCharges->product->slug;
            }
            
            $data = [
                "id" => $returnOrder->id,
                'title' => $title,
                "order_number" => $returnOrder->order->order_number,
                'order_type' => $returnOrder->order->getOrderType(),
                "return_number" => $returnOrder->return_number,
                "return_date" => $returnOrder->return_date->toDateString(),
                'qnty' => $quantity,
                'reason' => $returnOrder->reason,
                'total_amount'=> $returnOrder->order->total_amount,
                'status' => $returnOrder->status,
                'dispute' => $returnOrder->dispute,
                'link' => route('product.details', $slug),
                'view_return' => route('edit.return.order', salt_encrypt($returnOrder->id)),
                'view_order' => route('view.order', salt_encrypt($returnOrder->order_id)),
            ];
            
            return $data;
        } catch (\Exception $e) {
            Log::error('Error in CategoryManagementTransform: ' . $e->getMessage());
            throw $e;
        }
    }
}
