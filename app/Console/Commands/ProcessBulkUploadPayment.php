<?php

namespace App\Console\Commands;

use App\Models\Import;
use App\Models\QueueName;
use App\Events\ExceptionEvent;
use Illuminate\Console\Command;
use App\Jobs\UpdatePaymentStatus;
use Illuminate\Support\Facades\Log;

class ProcessBulkUploadPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-bulk-upload-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command update payment status for bulk upload payment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            Import::where('status', Import::STATUS_PENDING)
                ->where('type', Import::TYPE_BULK_UPLOAD_PAYMENT)
                ->chunk(100, function ($imports) {
                    foreach ($imports as $import) {
                        $import->update(['status' => Import::STATUS_QUEUED]);
                        UpdatePaymentStatus::dispatch($import->id, $import->company_id)->onQueue(QueueName::PaymentBulkUpload);
                    }
                });
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
            // event(new ExceptionEvent($exceptionDetails));

            Log::error($e->getMessage(), $e->getTrace(), $e->getLine());
        }
    }
}
