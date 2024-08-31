<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderRefund;
use App\Models\ReturnOrder;
use App\Models\OrderInvoice;
use App\Models\OrderPayment;
use App\Events\ExceptionEvent;
use App\Services\OrderService;
use Illuminate\Console\Command;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\OrderPaymentDistribution;

class ProcessReturnOrderPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-return-order-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    try {
        $start = microtime(true);
        $this->info('Processing Supplier Payment Statement -'.now());
        $orderService = new OrderService();
        // need to add condtion get records where update_at is less then 2 days
        ReturnOrder::leftJoin('order_refunds', 'return_orders.order_id', '=', 'order_refunds.order_id')
        ->select('return_orders.*')
        ->with('order')
        ->whereNull('order_refunds.order_id')  // Ensures the record does not exist in order_refunds
        ->where('return_orders.status', ReturnOrder::STATUS_APPROVED)
        // ->where('return_orders.updated_at', '<', now()->subDays(2))
        ->where('return_orders.updated_at', '<', now()->addMinutes(20))
        ->whereIn('return_orders.dispute', ReturnOrder::DISPUTE_ARRAY)
        ->chunk(100, function ($returnOrders) use ($orderService) {
            foreach ($returnOrders as $returnOrder) {
                DB::beginTransaction();
                if($returnOrder->amount == $returnOrder->order->total_amount){
                    $orderPaymentDistributionStatus = OrderPaymentDistribution::STATUS_NA;
                    $orderInvoiceStatus = OrderInvoice::STATUS_REFUNDED;
                    $orderPaymentStatus = OrderPayment::STATUS_REFUNDED;
                }elseif($returnOrder->amount < $returnOrder->order->total_amount){
                    $orderPaymentDistributionStatus = OrderPaymentDistribution::STATUS_HOLD;
                    $orderInvoiceStatus = OrderInvoice::STATUS_PAID;
                    $orderPaymentStatus = OrderPayment::STATUS_CAPTURED;
                }else{
                    continue;
                }
                // Process the return order payment
                OrderPaymentDistribution::where('order_id', $returnOrder->order_id)->update([
                    'status' => $orderPaymentDistributionStatus,
                    'is_refunded' => true,
                    'refund_type' => OrderPaymentDistribution::REFUND_TYPE_RETURN,
                    'refund_status' => OrderPaymentDistribution::REFUND_STATUS_DUE,
                    'refunded_amount' => $returnOrder->amount,
                    'refund_initiated_at' => now(),
                ]);

                $orderPayment = OrderPayment::where('order_id', $returnOrder->order_id)->where('status', OrderPayment::STATUS_CAPTURED)->first();
                // create entry order refunds
                $orderRefund = OrderRefund::create([
                    'order_id' => $returnOrder->order_id,
                    'order_payment_id' => $orderPayment->id,
                    'buyer_id' => $returnOrder->order->buyer_id,
                    'amount' => $returnOrder->amount,
                    'refund_type' => OrderPaymentDistribution::REFUND_TYPE_RETURN,
                    'currency' => OrderRefund::CURRENCY_INR,
                    'status' => OrderRefund::STATUS_INITIATED,
                    'reason' => 'Customer return refund by system',
                    'initiated_by' => OrderRefund::INITIATED_BY_SYSTEM,
                    'refund_method' => OrderRefund::REFUND_METHOD_RAZORPAY,
                ]);

                // update return order status
                $orderInvoice = OrderInvoice::where('order_id', $returnOrder->order_id)->first();
                $orderInvoice->status = $orderInvoiceStatus;
                $orderInvoice->refund_amount = $returnOrder->amount;
                $orderInvoice->refund_status = OrderInvoice::REFUND_STATUS_INITIATED;
                $orderInvoice->save();
                $refund_amount = (int) round($returnOrder->amount) * 100;
                $refund = $orderService->intiateRefund($orderPayment->razorpay_payment_id, $orderRefund->reason,  $refund_amount, $orderInvoice->invoice_number);

                if (isset($refund['error'])) {
                    $orderRefund->status = OrderRefund::STATUS_FAILED;
                    $orderRefund->completed_at = now();
                    $orderRefund->save();
                    $orderInvoice->refund_status = OrderInvoice::REFUND_STATUS_FAILED;
                    $orderInvoice->save();
                    $transaction = OrderTransaction::create([
                        'order_id' => $returnOrder->order_id,
                        'order_payment_id' => $orderPayment->id,
                        'transaction_date' => now(),
                        'transaction_type' => OrderTransaction::TRANSACTION_TYPE_REFUND,
                        'transaction_amount' => $returnOrder->amount,
                        'transaction_currency' => OrderTransaction::CURRENCY_INR,
                        'razorpay_transaction_id' => $refund->id,
                        'status' => OrderTransaction::STATUS_FAILED,
                    ]);
                    $orderRefund->transaction_id = $transaction->id;
                    $orderRefund->save();
                }
                if ($refund->status == 'processed' || $refund->status == 'pending') {
                    $orderRefund->status = OrderRefund::STATUS_COMPLETED;
                    $orderRefund->completed_at = now();
                    $orderRefund->refund_date = now();
                    $orderRefund->save();

                    // update order payment distribution
                    OrderPaymentDistribution::where('order_id', $returnOrder->order_id)->update([
                        'refund_status' => OrderPaymentDistribution::REFUND_STATUS_PAID,
                        'refund_completed_at' => now(),
                    ]);

                    // update order payment status
                    $orderPayment->status = $orderPaymentStatus;
                    $orderPayment->save();
                    // update order invoice
                    $orderInvoice->refund_status = OrderInvoice::REFUND_STATUS_COMPLETED;
                    $orderInvoice->save();

                    $transaction = OrderTransaction::create([
                        'order_id' => $returnOrder->order_id,
                        'order_payment_id' => $orderPayment->id,
                        'transaction_date' => now(),
                        'transaction_type' => OrderTransaction::TRANSACTION_TYPE_REFUND,
                        'transaction_amount' => $returnOrder->amount,
                        'transaction_currency' => OrderTransaction::CURRENCY_INR,
                        'razorpay_transaction_id' => $refund->id,
                        'status' => OrderTransaction::STATUS_SUCCESS,
                    ]);
                    $orderRefund->transaction_id = $transaction->id;
                    $orderRefund->save();
                }
                DB::commit();
            }
        });
        $end = microtime(true);
        $executionTime = round($end - $start, 2);
        $this->info('Processing Buyer Payment Refund -'.$executionTime.' seconds');
        }catch (\Exception $e) {
            DB::rollBack();

            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            Log::error($e->getMessage(), $e->getTrace(), $e->getLine());
        }
    }
}
