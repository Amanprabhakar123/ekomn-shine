<?php
namespace App\Transformers;

use App\Models\ReturnOrder;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;
use PhpParser\Node\Stmt\Return_;

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
                "return_date" => $returnOrder->return_date,
                'qnty' => $quantity,
                'reason' => $returnOrder->reason,
                'total_amount'=> $returnOrder->order->total_amount,
                'status' => $returnOrder->status,
                'dispute' => $returnOrder->dispute,
                // 'link' => route('return.order.details', salt_encrypt($returnOrder->id)),
            ];
        //    dd($returnOrder->order);
            return $data;
        } catch (\Exception $e) {
            Log::error('Error in CategoryManagementTransform: ' . $e->getMessage());
            throw $e;
        }
    }
}
