<?php

namespace App\Console\Commands;

use Razorpay\Api\Api;
use App\Services\OrderService;
use Illuminate\Console\Command;
use App\Models\OrderTransaction;
use App\Events\ExceptionEvent;
use Illuminate\Support\Facades\Log;

class ChangePaymentRefundStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-payment-refund-status';

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
            $this->info('Image Compression started at: ' . now());
            // Initialize the Razorpay API
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $orderService = new OrderService();
            // Retrieve data from the OrderTransaction model
            OrderTransaction::where('status', OrderTransaction::STATUS_PENDING)
                ->where('transaction_type', OrderTransaction::TRANSACTION_TYPE_REFUND)
                ->orderBy('id', 'desc')
                ->chunk(100, function ($transactions) use ($api, $orderService) {
                    // Process each chunk of transactions
                    foreach ($transactions as $transaction) {
                        // Fetch the refund details
                        $paymentId = $transaction->orderPayment->razorpay_payment_id;
                        $refundId = $transaction->razorpay_transaction_id;
                        $refund = $api->payment->fetch($paymentId)->fetchRefund($refundId);
                        if ($refund->status) {
                            $orderService->changePaymentRefundStatus($transaction);
                            $transaction->status = OrderTransaction::STATUS_SUCCESS;
                            $transaction->save();
                        }
                    }
                });
            $end = microtime(true);
            $executionTime = round($end - $start, 2);
            $this->info('Payment Refund Status Update. Total execution time: ' . $executionTime . ' seconds.');
        } catch (\Exception $e) {
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            // Log the error
            Log::error(json_encode($exceptionDetails));
        }
    }
}
