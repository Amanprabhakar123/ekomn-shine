<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Charges;
use App\Models\OrderRefund;
use App\Events\ExceptionEvent;
use App\Models\OrderItemAndCharges;
use App\Models\SupplierPayment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\OrderPaymentDistribution;
use Illuminate\Support\Facades\DB;

class ProcessSupplierPaymentStatement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-supplier-payment-statement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to process supplier payment statement';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            $start = microtime(true);
            $this->info('Processing Supplier Payment Statement -'.now());
            $supplier_payment = new SupplierPayment();
            $tds_percent = 0;
            $tcs_percent = 0;
            $charges = Charges::whereIn('other_charges', [Charges::TDS, Charges::TCS])->get();
            foreach ($charges as $charge) {
                if ($charge->other_charges == Charges::TDS) {
                    $tds_percent = $charge->value;
                } elseif ($charge->other_charges == Charges::TCS) {
                    $tcs_percent = $charge->value;
                }
            }
            // Get all the orders which are Dispatched, Intransit, Delivered, RTO
            $a = Order::leftJoin('supplier_payments', 'orders.id', '=', 'supplier_payments.order_id')
            ->with('returnOrder')
            ->select('orders.*', 'supplier_payments.payment_status')
            ->whereIn('status', Order::STATUS_ORDER_TRACKING)   
            ->where(function($query) {
                $query->whereNull('supplier_payments.payment_status')->OrwhereIn('supplier_payments.payment_status', SupplierPayment::PaymentStatement);
            })
            // ->orderBy('orders.id', 'desc')
            ->chunk(100, function ($orders) use($supplier_payment, $tds_percent, $tcs_percent) {
                foreach ($orders as $order) {
                    $shipments = $order->shipments()->first();
                    if($shipments){
                        $delivery_date = $shipments->delivery_date;
                    }else{
                        $delivery_date = '';
                    }
                    if(isset($delivery_date) && !empty($delivery_date)){
                        $payment_week = $supplier_payment->getPaymentWeek($order, $delivery_date);
                        $payment_status = $supplier_payment->paymentStatus($order, $delivery_date);
                    }else{
                        $payment_week = null;
                        $payment_status = SupplierPayment::PAYMENT_STATUS_HOLD;
                    }
                    $tds_amount = number_format(($order->total_amount * $tds_percent / 100), 2);
                    $tcs_amount = number_format(($order->total_amount * $tcs_percent / 100), 2);
                    $processing_charges = 0;
                    $payment_gateway_charges = 0;
                    $refund_amount = 0;

                    $order->orderItemsCharges()->get()->each(function($orderItemsCharges) use (&$processing_charges, &$payment_gateway_charges){
                        $processing_charges += $orderItemsCharges->processing_charges;
                        $payment_gateway_charges += $orderItemsCharges->payment_gateway_charges;
                    });
                    $order->orderRefunds()->where('status',OrderRefund::STATUS_COMPLETED)->select('amount')->get()->each(function($refund) use (&$refund_amount){
                        $refund_amount += $refund->amount;
                    });

                    if(!empty($order->returnOrder)){
                        if($order->isReturnFilled() && $order->returnOrder->isApproved() && ($order->returnOrder->isDisputeResolved() || $order->returnOrder->isDisputeNo())){
                            $payment = SupplierPayment::where('order_id', $order->id)->first();
                            if($payment){
                                $payment->tds = $tds_amount;
                                $payment->tcs = $tcs_amount;
                                $payment->disburse_amount = (float) $order->total_amount - ((float) $tds_amount + (float) $tcs_amount + (float) $processing_charges + (float) $payment_gateway_charges + (float) $refund_amount + (float) $payment->adjustment_amount);
                                $payment->payment_status = $payment_status;
                                $payment->statement_date = $payment_week;
                                $payment->save();
                            } else {
                                $orderDistribution = OrderPaymentDistribution::where('order_id', $order->id)->first();
                                // Create new supplier payment
                                $supplier_payment->create([
                                    'distribution_id' => $orderDistribution->id,
                                    'supplier_id' => $order->supplier_id,
                                    'order_id' => $order->id,
                                    'tds' => $tds_amount,
                                    'tcs' => $tcs_amount,
                                    'adjustment_amount' => OrderPaymentDistribution::DEFAULT_ADJUSTMENT_AMOUNT,
                                    'disburse_amount' => (float)  $order->total_amount - ((float) $tds_amount + (float) $tcs_amount + (float) $processing_charges + (float) $payment_gateway_charges + (float) $refund_amount + (float) OrderPaymentDistribution::DEFAULT_ADJUSTMENT_AMOUNT),
                                    'payment_status' => $payment_status,
                                    'statement_date' => $payment_week,
                                    'payment_method' => SupplierPayment::PAYMENT_METHOD_BANK_TRANSFER
                                ]);
                            }
                        }
                    }elseif($order->isDelivered()){
                        $payment = SupplierPayment::where('order_id', $order->id)->first();
                        if($payment){
                            $payment->tds = $tds_amount;
                            $payment->tcs = $tcs_amount;
                            $payment->disburse_amount = (float) $order->total_amount - ((float) $tds_amount + (float) $tcs_amount + (float) $processing_charges + (float) $payment_gateway_charges + (float) $refund_amount + (float) $payment->adjustment_amount);
                            $payment->payment_status = $payment_status;
                            $payment->statement_date = $payment_week;
                            $payment->save();
                        } else {
                            $orderDistribution = OrderPaymentDistribution::where('order_id', $order->id)->first();
                            // Create new supplier payment
                            $supplier_payment->create([
                                'distribution_id' => $orderDistribution->id,
                                'supplier_id' => $order->supplier_id,
                                'order_id' => $order->id,
                                'tds' => $tds_amount,
                                'tcs' => $tcs_amount,
                                'adjustment_amount' => OrderPaymentDistribution::DEFAULT_ADJUSTMENT_AMOUNT,
                                'disburse_amount' => (float)  $order->total_amount - ((float) $tds_amount + (float) $tcs_amount + (float) $processing_charges + (float) $payment_gateway_charges + (float) $refund_amount + (float) OrderPaymentDistribution::DEFAULT_ADJUSTMENT_AMOUNT),
                                'payment_status' => $payment_status,
                                'statement_date' => $payment_week,
                                'payment_method' => SupplierPayment::PAYMENT_METHOD_BANK_TRANSFER
                            ]);
                        }
                    }
                }
            });
            $end = microtime(true);
            $executionTime = round($end - $start, 2);
            $this->info('Processing Supplier Payment Statement Completed -'.$executionTime.' seconds');
        }catch(\Exception $e){
              // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
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
