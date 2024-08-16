<?php

namespace App\Jobs;

use App\Events\ExceptionEvent;
use App\Models\ProductInventory; // Import ProductInventory model
use App\Services\ExportServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class ExportMisReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;

    protected $email;

    /**
     * Create a new job instance.
     *
     * @param  string  $type
     * @param  string  $email
     */
    public function __construct($type, $email)
    {
        $this->type = $type;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $fileName = '';
            $csvData = [];
            $csvHeaders = [];
            $email = $this->email;

            // Determine the report type and set up file name and headers accordingly
            if ($this->type === 'in_demand') {
                $fileName = 'MIS_In_Demand.csv';
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status', 'Purchase Count', 'Company Serial ID'];

                // Fetch products with their related models in chunks
                ProductInventory::with(['variations', 'productMatrics', 'company'])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            $sku = $product->variations->sku ?? '';
                            $stock = $product->variations->stock ?? '';
                            $status = $product->variations->status ?? '';
                            $purchaseCount = $product->productMatrics->purchase_count ?? 0;
                            $companySerialId = $product->company->company_serial_id ?? '';

                            $csvData[] = [
                                $product->title,
                                $product->hsn,
                                $sku,
                                $stock,
                                $status,
                                $purchaseCount,
                                $companySerialId,
                            ];
                        }
                    });
            } elseif ($this->type === 'out_of_stock') {
                $fileName = 'MIS_Out_Of_Stock.csv';
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status', 'Company Serial ID'];

                // Fetch products with their related models in chunks
                ProductInventory::with(['variations', 'productMatrics', 'company'])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            $sku = $product->variations->sku ?? '';
                            $stock = $product->variations->stock ?? '';
                            $status = $product->variations->status ?? '';
                            $companySerialId = $product->company->company_serial_id ?? '';

                            $csvData[] = [
                                $product->title,
                                $product->hsn,
                                $sku,
                                $stock,
                                $status,
                                $companySerialId,
                            ];
                        }
                    });
            } elseif ($this->type === 'product_events') {
                $fileName = 'MIS_PRODUCT_EVENTS.csv';
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status', 'Purchase Count', 'Product Click', 'Product View', 'Product Add', 'Product Download', 'Company Serial ID'];

                // Fetch products with their related models in chunks
                ProductInventory::with(['variations', 'productMatrics', 'company'])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            $sku = $product->variations->sku ?? '';
                            $stock = $product->variations->stock ?? '';
                            $status = $product->variations->status ?? '';
                            $purchaseCount = $product->productMatrics->purchase_count ?? 0;
                            $clickCount = $product->productMatrics->click_count ?? 0;
                            $viewCount = $product->productMatrics->view_count ?? 0;
                            $addToInventoryCount = $product->productMatrics->add_to_inventory_count ?? 0;
                            $downloadCount = $product->productMatrics->download_count ?? 0;
                            $companySerialId = $product->company->company_serial_id ?? '';

                            $csvData[] = [
                                $product->title,
                                $product->hsn,
                                $sku,
                                $stock,
                                $status,
                                $purchaseCount,
                                $clickCount,
                                $viewCount,
                                $addToInventoryCount,
                                $downloadCount,
                                $companySerialId,
                            ];
                        }
                    });
            } elseif ($this->type === 'product_inventory_stock') {
                $fileName = 'MIS_PRODUCT_INVENTORY_STOCK.csv';
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status', 'Company Serial ID', 'Updated Stocks'];

                // Fetch products with their related models in chunks
                ProductInventory::with(['variations', 'company'])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            $sku = $product->variations->sku ?? '';
                            $stock = $product->variations->stock ?? '';
                            $status = $product->variations->status ?? '';
                            $companySerialId = $product->company->company_serial_id ?? '';

                            // Retrieve updated stock values from the activity log
                            $updatedStocks = Activity::where('subject_type', 'App\\Models\\ProductVariation')
                                ->where('subject_id', $product->variations->id)
                                ->where(function ($query) {
                                    $query->whereNotNull('properties->old->stock')
                                        ->whereColumn('properties->attributes->stock', '!=', 'properties->old->stock');
                                })
                                ->pluck('properties->attributes->stock')
                                ->toArray();

                            $updatedStocksString = implode(', ', $updatedStocks);

                            $csvData[] = [
                                $product->title,
                                $product->hsn,
                                $sku,
                                $stock,
                                $status,
                                $companySerialId,
                                $updatedStocksString,
                            ];
                        }
                    });
            } elseif ($this->type === 'product_inventory_price') {
                $fileName = 'MIS_PRODUCT_INVENTORY_PRICE.csv';
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Price', 'Status', 'Company Serial ID', 'Updated Prices'];

                // Fetch products with their related models in chunks
                ProductInventory::with(['variations', 'company'])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            $sku = $product->variations->sku ?? '';
                            $stock = $product->variations->stock ?? '';
                            $status = $product->variations->status ?? '';
                            $companySerialId = $product->company->company_serial_id ?? '';

                            // Retrieve updated price values from the activity log
                            $updatedPrices = Activity::where('subject_type', 'App\\Models\\ProductVariation')
                                ->where('subject_id', $product->variations->id)
                                ->where(function ($query) {
                                    $query->whereNotNull('properties->old->price_after_tax')
                                        ->whereColumn('properties->attributes->price_after_tax', '!=', 'properties->old->price_after_tax');
                                })
                                ->pluck('properties->attributes->price_after_tax')
                                ->toArray();

                            $updatedPricesString = implode(', ', $updatedPrices);

                            $csvData[] = [
                                $product->title,
                                $product->hsn,
                                $sku,
                                $stock,
                                $status,
                                $companySerialId,
                                $updatedPricesString,
                            ];
                        }
                    });
            }

            // Use ExportServices to generate and send the CSV file via email
            $exportFileService = new ExportServices;
            $exportFileService->sendCSVByEmail($csvHeaders, $csvData, $fileName, $email, $this->type);

        } catch (\Exception $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger an event and log the error if an exception occurs
            event(new ExceptionEvent($exceptionDetails));
            Log::error('ExportMisReport Job Error: '.$e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
