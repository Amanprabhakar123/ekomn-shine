<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Import;
use App\Import\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use Illuminate\Validation\Rule;


class ImportProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $import_id;
    protected $company_id;

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
        $import = Import::where('id', $this->import_id)
        ->where('company_id', $this->company_id)
        ->where('status', Import::STATUS_PENDING)
        ->first();

    if (!is_null($import)) {
        $import->status = Import::STATUS_INPROGRESS;
        $import->save();
        $import->refresh();
        $filePath = storage_path('app/public/'.$import->file_path); // Adjust the file path as needed

        if (!file_exists($filePath)) {
            \Log::error("File path does not exist ". $filePath);
            return;
        }
        $errorCount = 0;
        $successCount = 0;
        $failCount = 0;
        $productsImport = new ProductsImport($import->id);

            Excel::import($productsImport, $filePath);
    }
    }
}
