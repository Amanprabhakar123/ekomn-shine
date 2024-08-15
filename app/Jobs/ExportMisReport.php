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

            if ($this->type === 'in_demand') {
                $fileName = 'MIS_In_Demand.csv';
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status', 'Purchase Count', 'Company Serial ID'];

                // Fetch products in chunks
                ProductInventory::with(['variations', 'ProductMatrics', 'company'])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            // Check if the relationships exist before accessing them
                            $sku = $product->variations->sku ?? '';
                            $stock = $product->variations->stock ?? '';
                            $status = $product->variations->status ?? '';
                            $purchaseCount = $product->ProductMatrics->purchase_count ?? 0;
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

                // Fetch products in chunks
                ProductInventory::with(['variations', 'ProductMatrics', 'company'])

                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            // Check if the relationships exist before accessing them
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

                // Fetch products in chunks
                ProductInventory::with(['variations', 'ProductMatrics', 'company'])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            // Check if the relationships exist before accessing them
                            $sku = $product->variations->sku ?? '';
                            $stock = $product->variations->stock ?? '';
                            $status = $product->variations->status ?? '';
                            $purchaseCount = $product->ProductMatrics->purchase_count ?? 0;
                            $clickCount = $product->ProductMatrics->click_count ?? 0;
                            $viewCount = $product->ProductMatrics->view_count ?? 0;
                            $addToInventoryCount = $product->ProductMatrics->add_to_inventory_count ?? 0;
                            $downloadCount = $product->ProductMatrics->download_count ?? 0;
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

                // Fetch products in chunks
                ProductInventory::with(['variations', 'company'])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            // Check if the relationships exist before accessing them
                            $sku = $product->variations->sku ?? '';
                            $stock = $product->variations->stock ?? '';
                            $status = $product->variations->status ?? '';
                            $companySerialId = $product->company->company_serial_id ?? '';

                            // Fetch the updated stock values from the activity log
                            $updatedStocks = Activity::where('subject_type', 'App\\Models\\ProductVariation')
                                ->where('subject_id', $product->variations->id)
                                ->where(function ($query) {
                                    $query->whereNotNull('properties->old->stock')
                                        ->whereColumn('properties->attributes->stock', '!=', 'properties->old->stock');
                                })
                                ->pluck('properties->attributes->stock')
                                ->toArray(); // Get the updated stock values

                            // Convert the updated stock values to a comma-separated string
                            $updatedStocksString = implode(', ', $updatedStocks);

                            $csvData[] = [
                                $product->title,
                                $product->hsn,
                                $sku,
                                $stock,
                                $status,
                                $companySerialId,
                                $updatedStocksString, // Add the updated stock values
                            ];
                        }
                    });
            } elseif ($this->type === 'product_inventory_price') {
                $fileName = 'MIS_PRODUCT_INVENTORY_PRICE.csv';
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Price', 'Status', 'Company Serial ID', 'Updated Prices'];

                // Fetch products in chunks
                ProductInventory::with(['variations', 'company'])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $product) {
                            // Check if the relationships exist before accessing them
                            $sku = $product->variations->sku ?? '';
                            $stock = $product->variations->stock ?? '';
                            $status = $product->variations->status ?? '';
                            $companySerialId = $product->company->company_serial_id ?? '';

                            // Fetch the updated stock values from the activity log
                            $updatedPrices = Activity::where('subject_type', 'App\\Models\\ProductVariation')
                                ->where('subject_id', $product->variations->id)
                                ->where(function ($query) {
                                    $query->whereNotNull('properties->old->price_after_tax')
                                        ->whereColumn('properties->attributes->price_after_tax', '!=', 'properties->old->price_after_tax');
                                })
                                ->pluck('properties->attributes->price_after_tax')
                                ->toArray(); // Get the updated price_after_tax values

                            // Convert the updated price_after_tax values to a comma-separated string
                            $updatedPricesString = implode(', ', $updatedPrices);

                            $csvData[] = [
                                $product->title,
                                $product->hsn,
                                $sku,
                                $stock,
                                $status,
                                $companySerialId,
                                $updatedPricesString, // Add the updated stock values
                            ];
                        }
                    });
            }

            // Call the ExportFileService and pass the $csvData and $this->email as parameters
            $exportFileService = new ExportServices;
            $exportFileService->sendCSVByEmail($csvHeaders, $csvData, $fileName, $email);

        } catch (\Exception $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger an event or just log the error
            event(new ExceptionEvent($exceptionDetails));
            // Log the error details
            Log::error('ExportMisReport Job Error: '.$e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
