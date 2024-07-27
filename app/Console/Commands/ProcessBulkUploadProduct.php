<?php

namespace App\Console\Commands;

use App\Events\ExceptionEvent;
use App\Jobs\ImportProductJob;
use App\Models\Import;
use App\Models\QueueName;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessBulkUploadProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:bulk-upload-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process bulk upload product';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            Import::where('status', Import::STATUS_PENDING)
                ->where('type', Import::TYPE_BULK_UPLOAD_INVENTORY)
                ->chunk(100, function ($imports) {
                    foreach ($imports as $import) {
                        $import->update(['status' => Import::STATUS_QUEUED]);
                        ImportProductJob::dispatch($import->id, $import->company_id)->onQueue(QueueName::ProductBulkUpload);
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
            event(new ExceptionEvent($exceptionDetails));

            Log::error($e->getMessage(), $e->getTrace(), $e->getLine());
        }

    }
}
