<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Import;
use Illuminate\Bus\Queueable;
use App\Events\ExceptionEvent;
use App\Models\SupplierPayment;
use App\Models\ImportErrorMessage;
use Illuminate\Support\Facades\Log;
use App\Models\SupplierPaymentInvoice;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdatePaymentStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $import_id;
    protected $company_id;

    // Maximum number of attempts
    public $tries = 3;

    // Retry after 60 seconds (optional)
    public $retryAfter = 60;

    /**
     * Create a new job instance.
     */
    public function __construct($import_id, $company_id)
    {
        $this->import_id = $import_id;
        $this->company_id = $company_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $import = Import::where('id', $this->import_id)
                ->where('company_id', $this->company_id)
                ->where('status', Import::STATUS_QUEUED)
                ->first();

            if (!is_null($import)) {
                $import->status = Import::STATUS_INPROGRESS;
                $import->save();
                $import->refresh();
                $filePath = storage_path('app/public/' . $import->file_path); // Adjust the file path as needed
                if (!file_exists($filePath)) {
                    ImportErrorMessage::create([
                        'import_id' => $import->id,
                        'row_number' => 'File Path',
                        'error_message' => 'File path does not exist : ' . $filePath,
                    ]);
                    return;
                }
                //
                $file = fopen($filePath, 'r');
                $header = fgetcsv($file);

                // Read the file line by line
                while (($data = fgetcsv($file)) !== false) {
                    // Process the data here
                    // For example, update the payment status
                    // Update the payment status for the record
                    $order = Order::where('order_number', $data[0])->first();
                    $supplier_payment = new SupplierPayment();
                    if ($order) {   
                        $payment = SupplierPayment::where('order_id', $order->id)->first();
                        if ($payment) {
                            $payment->payment_status = $supplier_payment->setPaymentStatus($data[1]);
                            $payment->payment_date = Carbon::parse($data[2])->toDateTimeString();
                            $payment->transaction_id = $data[3];
                            $payment->invoice_generated = true;
                            $payment->save();
                        } else {
                            ImportErrorMessage::create([
                                'import_id' => $import->id,
                                'row_number' => $data[0],
                                'error_message' => 'Payment not found',
                            ]);
                        }

                        $invoice_number = new SupplierPaymentInvoice();
                        // generate invoice
                        SupplierPaymentInvoice::create([
                            'supplier_payments_id' => $payment->id,
                            'invoice_number' => $invoice_number->generateInvoiceNumber(),
                            'invoice_date' => Carbon::now(),
                            'total_amount' => $payment->disburse_amount,
                            'status' => SupplierPaymentInvoice::STATUS_PAID,
                        ]);
                        
                    } else {
                        ImportErrorMessage::create([
                            'import_id' => $import->id,
                            'row_number' => $data[0],
                            'error_message' => 'Order not found',
                        ]);
                    }
                }
                fclose($file);
                $import->status = Import::STATUS_SUCCESS;
                $import->save();
            } else {
                // Handle the case when the import is not found
                ImportErrorMessage::create([
                    'import_id' => $this->import_id,
                    'row_number' => 'Import ID',
                    'error_message' => 'Import not found',
                ]);
                return;
            }
        } catch (\Exception $e) {
            // Handle the exception here
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
