<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\CompanyDetail;
use Illuminate\Bus\Queueable;
use App\Events\ExceptionEvent;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\UserLoginHistory;
use App\Models\CompanyPlanPayment;
use Illuminate\Support\Facades\Log;
use App\Models\CompanyAddressDetail;
use App\Services\ExportFileServices;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\Activitylog\Models\Activity; // Import ProductInventory model

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
                $csvHeaders = ['Title', 'HSN', 'SKU', 'Stock', 'Status',  'Availablity Status', 'Purchase Count', 'Product Click', 'Product View', 'Product Added to Invetory', 'Product Download', 'Product Search', 'Supplier ID'];

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
                            $searchCount = $pro->productMatrics->search_count ?? 0;
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
                                $searchCount,
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
            } elseif ($this->type === 'product_inventory_growth') {
                $fileName = 'MIS_PRODUCT_GROWTH.csv';
                $csvHeaders = ['Title', 'SKU', 'Supplier ID', 'Category Name', 'Sub Category', 'Product Listing Date'];

                // Fetch products with their related models in chunks
                ProductVariation::with(['product', 'company'])
                    ->whereIn('status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK, ProductVariation::STATUS_INACTIVE])
                    ->chunk(100, function ($products) use (&$csvData) {
                        foreach ($products as $pro) {
                            $sku = $pro->sku ?? '';

                            $companySerialId = $pro->company->company_serial_id ?? '';

                            $csvData[] = [
                                $pro->product->title,
                                $sku,
                                $companySerialId,
                                $pro->product->category->name,
                                $pro->product->subCategory->name,
                                $pro->created_at,
                            ];
                        }
                    });

            } elseif ($this->type === 'orders') {
                $fileName = 'MIS_ORDERS.csv';
                $csvHeaders = ['Order ID', 'Order Value', 'Order Date', 'Supplier ID', 'Buyer ID',  'Order Status', 'Order Type', 'Order Channel Type', 'Total Quantity'];

                // Fetch products with their related models in chunks
                Order::with(['orderItemsCharges', 'buyer', 'supplier'])
                    ->chunk(100, function ($orders) use (&$csvData, &$totalQuantity) {
                        foreach ($orders as $ord) {
                            $csvData[] = [
                                $ord->order_number,
                                $ord->total_amount,
                                $ord->order_date,
                                $ord->buyer->companyDetails->company_serial_id,
                                $ord->supplier->companyDetails->company_serial_id,
                                $ord->getStatus(),
                                $ord->getOrderType(),
                                $ord->getOrderChannelType(),
                                // Calculate the sum of orderItemsCharges quantity
                                $totalQuantity = $ord->orderItemsCharges->sum('quantity') ?? 0,
                            ];

                        }
                    });
            } elseif ($this->type === 'supplier_login_history') {
                $fileName = 'MIS_SUPPLIER_LOGIN_HISTORY.csv';
                $csvHeaders = ['User Name', 'Email', 'Supplier ID/ Buyer ID', 'Login Date'];

                // Fetch products with their related models in chunks
                UserLoginHistory::with(['user', 'companyDetail'])
                    ->chunk(100, function ($userLogin) use (&$csvData) {
                        foreach ($userLogin as $user) {
                            $role = $user->user->getRoleNames()->first(); 
                            if($role && ($role == ROLE_SUPPLIER) || ($role == ROLE_BUYER)){
                                $full_name = isset($user->companyDetail->first_name) ? $user->companyDetail->first_name.' '.$user->companyDetail->last_name : '';
                                $company_serial_id = isset($user->companyDetail->company_serial_id) ? $user->companyDetail->company_serial_id : '';
                                $csvData[] = [
                                    $full_name,
                                    $user->user->email,
                                    $company_serial_id,
                                    $user->last_login,
                                ];
                            }
                        }
                    });
            } elseif ($this->type === 'total_supplier') {
                $fileName = 'MIS_TOTAL_SUPPLIER.csv';
                $csvHeaders = ['Company Name', 'Address', 'Company Serial ID', 'User Role', 'GST No', 'Variations', 'Registered Date', 'Last Login'];
                CompanyDetail::with(['address', 'variations', 'products', 'loginHistory', 'user'])
                    ->chunk(100, function ($companyDetails) use (&$csvData) {
                        foreach ($companyDetails as $com) {
                            $role = $com->user->getRoleNames()->first(); 
                            $loginHistory = $com->loginHistory->first();
                            isset($loginHistory) ? $loginHistory = $loginHistory->last_login : $loginHistory = '';
                            if($role && ($role == ROLE_SUPPLIER)){
                                $fullAddress = $com->address->where('address_type', CompanyAddressDetail::TYPE_BILLING_ADDRESS)->first();
                                isset($fullAddress) ? $fullAddress = $fullAddress->getFullAddress() : $fullAddress = '';
                                $csvData[] = [
                                    $com->getFullName(),
                                    $fullAddress,
                                    $com->company_serial_id,
                                    $role,
                                    $com->gst_no,
                                    $com->variations->count(),
                                    $com->created_at,
                                    $loginHistory,
                                ];
                            }elseif($role && ($role == ROLE_BUYER)){
                                $fullAddress = $com->address->where('address_type', CompanyAddressDetail::TYPE_DELIVERY_ADDRESS)->first();
                                isset($fullAddress) ? $fullAddress = $fullAddress->getFullAddress() : $fullAddress = '';
                                $csvData[] = [
                                    $com->getFullName(),
                                    $fullAddress,
                                    $com->company_serial_id,
                                    $role,
                                    $com->gst_no,
                                    $com->variations->count(),
                                    $com->created_at,
                                    $loginHistory,
                                ];
                            }
                        }
                    });
            } elseif ($this->type === 'total_active_buyer') {
                $fileName = 'MIS_TOTAL_ACTIVE_BUYER.csv';
                $csvHeaders = ['Full Name', 'Email', 'Mobile', 'Plan Type', 'Plan Amount', 'Plan Name', 'Transaction ID', 'Subscription Start Date', 'Subscription End Date'];
                CompanyPlanPayment::with(['companyDetails', 'plan'])
                    ->chunk(100, function ($companyPlans) use (&$csvData) {
                        foreach ($companyPlans as $com) {
                                if(!empty($com->companyDetails)){
                                $full_name = isset($com->companyDetails->first_name) ? $com->companyDetails->first_name.' '.$com->companyDetails->last_name : '';
                                $subscription_start_date = isset($com->companyDetails->subscription[0]['subscription_start_date']) ? $com->companyDetails->subscription[0]['subscription_start_date'] : '';
                                $subscription_end_date = isset($com->companyDetails->subscription[0]['subscription_end_date']) ? $com->companyDetails->subscription[0]['subscription_end_date'] : '';
                                $csvData[] = [
                                    $full_name,
                                    $com->email,
                                    $com->mobile,
                                    $com->plan->getPlanType(),
                                    $com->amount,
                                    $com->plan->name,
                                    $com->transaction_id,
                                    $subscription_start_date,
                                    $subscription_end_date,
                                ];
                            }
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
