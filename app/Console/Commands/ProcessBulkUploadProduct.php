<?php

namespace App\Console\Commands;

use App\Models\Import;
use App\Models\QueueName;
use App\Jobs\ImportProductJob;
use Illuminate\Console\Command;

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
        Import::where('status', Import::STATUS_PENDING)
            ->where('type', Import::TYPE_BULK_UPLOAD_INVENTORY)
            ->chunk(100, function ($imports) {
            foreach ($imports as $import) {
                $import->update(['status' => Import::STATUS_QUEUED]);
                ImportProductJob::dispatch($import->id, $import->company_id)->onQueue(QueueName::ProductBulkUpload);
            }
        });
    }
}
