<?php

namespace App\Jobs;

use Storage;
use App\Models\Import;
use Illuminate\Bus\Queueable;
use App\Import\ProductsImport;
use Illuminate\Validation\Rule;
use App\Models\ImportErrorMessage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class ImportProductJob implements ShouldQueue
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
            $productsImport = new ProductsImport($import->id);
            Excel::import($productsImport, $filePath);
        }
    }
}
