<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Import;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $import_id;
    /**
     * Create a new job instance.
     */
    public function __construct($import_id)
    {
        $this->import_id = $import_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $import = Import::where('id', $this->import_id)
        ->where('status', Import::STATUS_PENDING)
        ->first();

    if (!is_null($import)) {
        $filePath = storage_path('app/' . $import->file_path); // Adjust the file path as needed

        if (!file_exists($filePath)) {
            // Handle file not found error
            return;
        }

        try {
            Excel::import(new ProductsImport, $filePath);
            // Update import status to completed
            $import->status = Import::STATUS_COMPLETED;
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errorFilePath = storage_path('app/errors_' . $this->import_id . '.csv');
            $errorFile = fopen($errorFilePath, 'w');
            fputcsv($errorFile, ['row', 'attribute', 'errors', 'values']);

            foreach ($failures as $failure) {
                fputcsv($errorFile, [
                    $failure->row(), 
                    $failure->attribute(), 
                    implode(', ', $failure->errors()), 
                    json_encode($failure->values())
                ]);
            }

            fclose($errorFile);

            // Update import status to failed
            $import->status = Import::STATUS_FAILED;
        }

        $import->save();
    }
    }
}
