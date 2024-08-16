<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Events\ExceptionEvent;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Log;
use App\Services\ExportFileServices;
use Illuminate\Queue\SerializesModels;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\ProductInventory; // Import ProductInventory model

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
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status', 'Purchase Count', 'Availablity Status', 'Supplier ID'];

                // Fetch products with their related models in chunks
                ProductVariation::with(['product', 'productMatrics', 'company'])
                ->whereIn('status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK])
                ->whereHas('productMatrics', function ($query) {
                    $query->where('purchase_count', '>', 0);
                })->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $pro) {
                            $sku = $pro->sku ?? '';
                            $stock = $pro->stock ?? '';
                            $status = $pro->status ?? '';
                            $purchaseCount = $pro->productMatrics->purchase_count ?? 0;
                            $companySerialId = $pro->company->company_serial_id ?? '';

                            $csvData[] = [
                                $pro->title,
                                $pro->product->hsn,
                                $sku,
                                $stock,
                                getStatusName($status),
                                $purchaseCount,
                                getAvailablityStatusName($pro->availability_status),
                                $companySerialId,
                            ];
                        }
                    });
            } elseif ($this->type === 'product_master') {
                $fileName = 'MIS_Master.csv';
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status', 'Availablity Status',  'Supplier ID'];

                // Fetch products with their related models in chunks
                ProductVariation::with(['product', 'productMatrics', 'company'])
                ->whereIn('status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK, ProductVariation::STATUS_INACTIVE])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $pro) {
                            $sku = $pro->sku ?? '';
                            $stock = $pro->stock ?? '';
                            $status = $pro->status ?? '';
                            $companySerialId = $pro->company->company_serial_id ?? '';

                            $csvData[] = [
                                $pro->title,
                                $pro->product->hsn,
                                $sku,
                                $stock,
                                getStatusName($status),
                                getAvailablityStatusName($pro->availability_status),
                                $companySerialId,
                            ];
                        }
                    });
            } elseif ($this->type === 'product_events') {
                $fileName = 'MIS_PRODUCT_EVENTS.csv';
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status',  'Availablity Status', 'Purchase Count', 'Product Click', 'Product View', 'Product Added to Invetory', 'Product Download', 'Supplier ID'];

                // Fetch products with their related models in chunks
                ProductVariation::with(['product', 'productMatrics', 'company'])
                ->whereIn('status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK, ProductVariation::STATUS_INACTIVE])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $pro) {
                            $sku = $pro->sku ?? '';
                            $stock = $pro->stock ?? '';
                            $status = $pro->status ?? '';
                            $purchaseCount = $pro->productMatrics->purchase_count ?? 0;
                            $clickCount = $pro->productMatrics->click_count ?? 0;
                            $viewCount = $pro->productMatrics->view_count ?? 0;
                            $addToInventoryCount = $pro->productMatrics->add_to_inventory_count ?? 0;
                            $downloadCount = $pro->productMatrics->download_count ?? 0;
                            $companySerialId = $pro->company->company_serial_id ?? '';

                            $csvData[] = [
                                $pro->product->title,
                                $pro->product->hsn,
                                $sku,
                                $stock,
                                getStatusName($status),
                                getAvailablityStatusName($pro->availability_status),
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
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status', 'Supplier ID', 'Updated Stocks'];

                // Fetch products with their related models in chunks
                ProductVariation::with(['product', 'productMatrics', 'company'])
                ->whereIn('status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK, ProductVariation::STATUS_INACTIVE])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $pro) {
                            $sku = $pro->sku ?? '';
                            $stock = $pro->stock ?? '';
                            $status = $pro->status ?? '';
                            $companySerialId = $pro->company->company_serial_id ?? '';

                            // Retrieve updated stock values from the activity log
                            $updatedStocks = Activity::where('subject_type', 'App\\Models\\ProductVariation')
                            ->where('subject_id', $pro->id)
                            ->whereNotNull('properties->old->stock')
                            ->whereRaw("json_extract(properties, '$.attributes.stock') != json_extract(properties, '$.old.stock')")
                            ->get()
                            ->map(function ($activity) {
                                return data_get($activity->properties, 'attributes.stock');
                            })
                            ->filter()
                            ->toArray();

                            $updatedStocksString = implode(', ', $updatedStocks);

                            $csvData[] = [
                                $pro->title,
                                $pro->hsn,
                                $sku,
                                $stock,
                                getStatusName($status),
                                $companySerialId,
                                $updatedStocksString,
                            ];
                        }
                    });
            } elseif ($this->type === 'product_inventory_price') {
                $fileName = 'MIS_PRODUCT_INVENTORY_PRICE.csv';
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Price', 'Status', 'Supplier ID', 'Updated Prices'];

                // Fetch products with their related models in chunks
                ProductVariation::with(['product', 'productMatrics', 'company'])
                ->whereIn('status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK, ProductVariation::STATUS_INACTIVE])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $pro) {
                            $sku = $pro->sku ?? '';
                            $price_before_tax = $pro->price_before_tax ?? '';
                            $status = $pro->status ?? '';
                            $companySerialId = $pro->company->company_serial_id ?? '';

                            // Retrieve updated price values from the activity log
                            $updatedPrices = Activity::where('subject_type', 'App\\Models\\ProductVariation')
                            ->where('subject_id', $pro->id)
                            ->whereNotNull('properties->old->price_before_tax')
                            ->whereRaw("json_extract(properties, '$.attributes.price_before_tax') != json_extract(properties, '$.old.price_before_tax')")
                            ->get()
                            ->map(function ($activity) {
                                return data_get($activity->properties, 'attributes.price_before_tax');
                            })
                            ->filter()
                            ->toArray();

                            $updatedPricesString = implode(', ', $updatedPrices);

                            $csvData[] = [
                                $pro->title,
                                $pro->hsn,
                                $sku,
                                $price_before_tax,
                                getStatusName($status),
                                $companySerialId,
                                $updatedPricesString,
                            ];
                        }
                    });
            }

            // Use ExportServices to generate and send the CSV file via email
            $exportFileService = new ExportFileServices;
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
