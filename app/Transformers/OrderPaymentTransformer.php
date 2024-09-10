<?php
namespace App\Transformers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderRefund;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class OrderPaymentTransformer extends TransformerAbstract
{
    protected $total_balance_due = 0;
    protected $total_payment_due = 0;
    protected $total_statement_amount = 0;
    protected $statement_date = null;
    
    public function __construct($statement_date = null)
    {
        $this->statement_date = $statement_date;
    }
    /**
     * Transform the given Order model into a formatted array.
     *
     * @param  Order  $order
     * @return array
     */
    public function transform(Order $order)
    {
        try {
            $orderItem = $order->orderItemsCharges()->get();
            $product_cost_exc_gst = 0;
            $product_cost_inc_gst = 0;
            $shipping_charges = 0;
            $shipping_charges_gst_amount = 0;
            $packing_charges = 0;
            $packing_charges_gst_amount = 0;
            $labour_charges = 0;
            $labour_charges_gst_amount = 0;
            $processing_charges = 0;
            $processing_charges_gst_amount = 0;
            $payment_gateway_charges = 0;
            $payment_gateway_charges_gst_amount = 0;
            $gst_percentage = 0;
            $product_applied_gst_amount = 0;
            $refund_amount = 0;
            $adjustment_amount = 0;
            $payment_status = '';
            $tds_amount = 0;
            $tcs_amount = 0;
            $disburse_amount = 0;
            $invoice_generated = false;
            $statement_date = '';
            
            if($orderItem->isNotEmpty()){
                $product_cost_exc_gst = $orderItem->sum('total_price_exc_gst');
                $product_cost_inc_gst = $orderItem->sum('total_price_inc_gst');
                $product_applied_gst_amount = $product_cost_inc_gst - $product_cost_exc_gst;
                $shipping_charges = $orderItem->sum('shipping_charges');
                $shipping_charges_gst_amount = $shipping_charges / (1 + ($orderItem->avg('shipping_gst_percent')/100));
                $packing_charges = $orderItem->sum('packing_charges');
                $packing_charges_gst_amount = $packing_charges / (1 + ($orderItem->avg('packaging_gst_percent')/100));
                $labour_charges = $orderItem->sum('labour_charges');
                $labour_charges_gst_amount = $labour_charges / (1 + ($orderItem->avg('labour_gst_percent')/100));
                $processing_charges = $orderItem->sum('processing_charges');
                $processing_charges_gst_amount = $processing_charges / (1 + ($orderItem->avg('processing_gst_percent')/100));
                $payment_gateway_charges = $orderItem->sum('payment_gateway_charges');
                $payment_gateway_charges_gst_amount = $payment_gateway_charges / (1 + ($orderItem->avg('payment_gateway_gst_percent')/100));
                $gst_percentage = $orderItem->avg('gst_percentage');
                $other_charges_gst = ($shipping_charges + $packing_charges + $labour_charges + $processing_charges + $payment_gateway_charges) - 
                ($shipping_charges_gst_amount + $packing_charges_gst_amount + $labour_charges_gst_amount + $processing_charges_gst_amount + $payment_gateway_charges_gst_amount);
            }
            $order->orderRefunds()->where('status',OrderRefund::STATUS_COMPLETED)->select('amount')->get()->each(function($refund) use (&$refund_amount){
                $refund_amount += $refund->amount;
            });
            $order->supplierPayments()->get()->each(function($payment) use (&$adjustment_amount, &$payment_status, &$tds_amount, &$tcs_amount, &$disburse_amount, &$invoice_generated, &$statement_date){
                $adjustment_amount += $payment->adjustment_amount;
                $payment_status = $payment->getPaymentStatus();
                $tds_amount += $payment->tds;
                $tcs_amount += $payment->tcs;
                $disburse_amount += $payment->disburse_amount;
                $invoice_generated = $payment->invoice_generated;
                $statement_date = $payment->statement_date;
                if($payment->isPaymentStatusHold() || $payment->isPaymentStatusAccured() || $payment->isPaymentStatusDue()){
                    $this->total_balance_due += $payment->disburse_amount;
                }
                if($payment->isPaymentStatusDue()){
                    $this->total_payment_due += $payment->disburse_amount;
                }

                if(!is_null($this->statement_date)) {
                    $this->total_statement_amount += $payment->disburse_amount;
                }else{
                    if(!is_null($payment->statement_date)){
                        // check next thurday date
                        $next_thursday = Carbon::parse('next thursday')->format('Y-m-d');
                        if($payment->statement_date->format('Y-m-d') == $next_thursday){
                            $this->total_statement_amount += $payment->disburse_amount;
                        } else{
                            $this->total_balance_due += 0;
                        }
                    }
                    else{
                        $this->total_balance_due += 0;
                    }
                }
            });
            $data = [
                'id' => salt_encrypt($order->id),
                'order_no' => $order->order_number,
                'store_order' => !is_null($order->store_order) ? $order->store_order : '' ,
                'order_date' => $order->order_date->format('d-m-Y'),
                'product_cost_exc_gst' => $product_cost_exc_gst,
                'product_cost_inc_gst' => $product_cost_inc_gst,
                'discount' => $order->discount,
                'shipping_charges' => number_format($shipping_charges, 2),
                'shipping_charges_gst_exc_amount' => number_format($shipping_charges_gst_amount, 2),
                'packing_charges' => number_format($packing_charges, 2),
                'packing_charges_gst_exc_amount' => number_format($packing_charges_gst_amount, 2),
                'labour_charges' => number_format($labour_charges, 2),
                'labour_charges_gst_exc_amount' => number_format($labour_charges_gst_amount, 2),
                'payment_gateway_charges' => number_format($payment_gateway_charges, 2),
                'payment_gateway_charges_gst_exc_amount' => number_format($payment_gateway_charges_gst_amount, 2),
                'processing_charges' => number_format($processing_charges, 2), // SERVICE CHARGES // Referal Fee
                'processing_charges_gst_exc_amount' => number_format($processing_charges_gst_amount, 2),
                'other_charges_gst' => number_format($other_charges_gst, 2),
                'product_gst_percentage' => $gst_percentage,
                'total_gst_amount' => number_format(($other_charges_gst + $product_applied_gst_amount),2),
                'order_total' => $order->total_amount,
                'status' => $order->getStatus(),
                'order_status' => $order->getStatus(),
                'order_type' => $order->getOrderType(),
                'refund_amount' => number_format($refund_amount, 2),
                'adjustment_amount' => number_format($adjustment_amount, 2),
                'tds_amount' => number_format($tds_amount, 2),
                'tcs_amount' => number_format($tcs_amount, 2),
                'disburse_amount' => number_format($disburse_amount, 2),
                'payment_status' => $payment_status,
                'statement_date' => is_null($statement_date) ? 'NA' : Carbon::parse($statement_date)->format('d-m-Y'),
                'invoice_generated' => $invoice_generated,
                'order_channel_type' => $order->getOrderChannelType(),
                'view_order' => route('view.order', salt_encrypt($order->id)),
                'created_at' => $order->created_at->toDateTimeString(),
                'updated_at' => $order->updated_at->toDateTimeString(),
                'total_statement_amount' => number_format($this->total_statement_amount, 2),
            ];
            
            if(auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN)){
                $data['supplier_id'] = $order->supplier->CompanyDetails->company_serial_id;
                $data['bank_name'] = $order->supplier->CompanyDetails->bank_name;
                $data['bank_account_no'] = $order->supplier->CompanyDetails->bank_account_no;
                $data['ifsc_code'] = $order->supplier->CompanyDetails->ifsc_code;
                $data['swift_code'] = $order->supplier->CompanyDetails->swift_code;
            }
            return $data;
        } catch (\Exception $e) {
            throw $e;
            // Handle the exception here
            // You can log the error, return a default value, or throw a custom exception
            // For example, you can log the error and return an empty array
            Log::error('Error transforming Order: ' . $e->getMessage());
            return [];
        }
    }
}