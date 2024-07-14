<?php

namespace App\Jobs;

use Storage;
use App\Models\Import;
use Illuminate\Bus\Queueable;
use App\Import\ProductsImport;
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
            $productsImport = new ProductsImport($this->import_id, $this->company_id);
            $productsImport->sheetName = 'Listing Data';
            $productsImport->headerRows = 2;
            $productsImport->selectedColumns = [
                'product_name',
                'description',
                'product_keywords',
                'product_features1',
                'product_features2',
                'product_features3',
                'model',
                'product_hsn',
                'gst_bracket',
                'availability',
                'upc',
                'isbn',
                'mpn',
                'length',
                'width',
                'height',
                'product_dimension_unit',
                'weight',
                'product_weight_unit',
                'package_length',
                'package_width',
                'package_height',
                'package_weight',
                'package_dimension_unit',
                'package_weight_unit',
                'per_piecedropship_rate',
                'potential_mrp',
                'bulk_rate1_quantity_upto',
                'bulk_rate1_price_per_piece',
                'bulk_rate2_quantity_upto',
                'bulk_rate2_price_per_piece',
                'bulk_rate3_quantity_upto',
                'bulk_rate3_price_per_piece',
                'shipping_rate1_quantity_upto',
                'shipping_rate1_local',
                'shipping_rate1_regional',
                'shipping_rate1_national',
                'shipping_rate2_quantity_upto',
                'shipping_rate2_local',
                'shipping_rate2_regional',
                'shipping_rate2_national',
                'shipping_rate3_quantity_upto',
                'shipping_rate3_local',
                'shipping_rate3_regional',
                'shipping_rate3_national',
                'color',
                'size',
                'product_stock'
            ]; // Include only specified columns
            Excel::import($productsImport, $filePath, null, \Maatwebsite\Excel\Excel::XLSX);
        }
    }
}
