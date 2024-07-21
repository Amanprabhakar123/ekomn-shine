<?php

namespace App\Import;

use Storage;
use App\Models\Import;
use App\Models\ProductFeature;
use App\Models\ProductKeyword;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Services\CategoryService;
use App\Models\ImportErrorMessage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToModel, WithHeadingRow, WithChunkReading, WithStartRow
{
     /**
     * The ID of the import.
     *
     * @var int
     */
    private $import_id;
    private $company_id;
    public $sheetName;
    public $headerRows;
    public $selectedColumns;
    protected $categoryService;
    protected $loop = 1;
    private $successCount = 0;
    private $errorCount = 0;


   /**
     * Create a new instance of the import.
     *
     * @param int $import_id The ID of the import.
     * @param int $company_id The ID of the company.
     */
    public function __construct($import_id, $company_id)
    {
        $this->import_id = $import_id;
        $this->company_id = $company_id;
        $this->categoryService = new CategoryService();
    }

    /**
     * Define the model for the import.
     *
     * @param array $row The row data to import.
     * @return void
     */
    public function model(array $row)
    {
       // Only include selected columns and remove null values
        $filteredRow = array_intersect_key($row, array_flip($this->selectedColumns));

        // Check if the row is empty (i.e., all values are null)
        if (count(array_filter($filteredRow, function ($value) {
            return !is_null($value);
        })) === 0) {
            return null;
        }
        // Ignore rows where all the selected columns are null or empty
        if (!empty($filteredRow) && count($filteredRow) > 1) {
            $this->collection(collect([$filteredRow]));
        }

        return null;
       
    }

    /**
     * Get the chunk size for the import.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000; // Adjust the chunk size as needed
    }

    /**
     * Get the starting row for the import.
     *
     * @return int
     */
    public function startRow(): int
    {
        return $this->headerRows + 1; // Skip the header rows
    }

    public function headingRow(): int
    {
        return $this->headerRows; // Specify the header row
    }

    public function sheets(): array
    {
        return [
            $this->sheetName => $this
        ];
    }

    /**
     * Import the collection of rows.
     *
     * @param \Illuminate\Support\Collection $rows The collection of rows to import.
     * @return void
     */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        $import = Import::where('id', $this->import_id)->first();
        $company_id = $this->company_id;
        $user_id = $import->companyDetails->user_id;

        $isValidationFailed = false;
        
        foreach ($rows->toArray() as $key => $row) {
            try {
                $validator =  Validator::make($row, $this->myCustomValidationRule(), $this->myValidationMessage());
                if ($validator->fails()) {
                    $isValidationFailed = true;
                    if ($validator->errors()->count() > 0) {
                        foreach ($validator->errors()->toArray() as $key => $value) {
                            ImportErrorMessage::create([
                                'import_id' => $import->id,
                                'field_name' => $key,
                                'row_number' => $this->loop,
                                'error_message' => $value[0]
                            ]);
                            DB::commit();   
                        }
                    }
                    $this->errorCount++;
                    $this->loop++;
                    continue;
                }

                // Check if the product validation failed
                if($isValidationFailed){
                    $import->status = Import::STATUS_VALIDATION;
                    $import->fail_count = $this->errorCount;
                    $import->success_count = $this->successCount;
                    $import->save();
                    DB::commit();
                    return;
                }
                
                $tags = explode(",", $row['product_keywords']);
                if(!empty($tags)){
                    $tags = array_map('trim', $tags); // Trim whitespace from each tag
                    $tags = array_map('strtolower', $tags); // Convert tags to lowercase
                    $tags = array_map(function($tag) {
                        return str_replace(' ', '-', $tag); 
                    }, $tags); // Replace spaces with hyphens
                }
                $tagData = $this->categoryService->searchCategory($tags);
                if(isset($tagData['result'])){
                    $main_category_id = salt_decrypt($tagData['result']['main_category_id']);
                    $sub_category_id = salt_decrypt($tagData['result']['sub_category_id']);
                }else{
                    $main_category_id = 1;
                    $sub_category_id = 1;
                }

                $product = ProductInventory::create([
                    'company_id' => $company_id,
                    'title' => $row['product_name'],
                    'description' => $row['description'],
                    'model' => $row['model'],
                    'hsn' => $row['product_hsn'],
                    'gst_percentage' => $row['gst_bracket'],
                    'availability_status' => $this->availabilityArray($row['availability']),
                    'upc' => $row['upc'],
                    'isbn' => $row['isbn'],
                    'mpin' => $row['mpn'],
                    'status' => ProductInventory::STATUS_DRAFT,
                    'product_category' => $main_category_id,
                    'product_subcategory' => $sub_category_id,
                    'user_id' => $user_id,
                ]);

                $tier_rate = [];
                if (!empty($row['bulk_rate1_quantity_upto']) && !empty($row['bulk_rate1_price_per_piece'])) {
                    $tier_rate[$row['bulk_rate1_quantity_upto']] = [
                        'quantity' => $row['bulk_rate1_quantity_upto'],
                        'price' => $row['bulk_rate1_price_per_piece']
                    ];
                }
                if (!empty($row['bulk_rate2_quantity_upto']) && !empty($row['bulk_rate2_price_per_piece'])) {
                    $tier_rate[$row['bulk_rate2_quantity_upto']] = [
                        'quantity' => $row['bulk_rate2_quantity_upto'],
                        'price' => $row['bulk_rate2_price_per_piece']
                    ];
                }
                if (!empty($row['bulk_rate3_quantity_upto']) && !empty($row['bulk_rate3_price_per_piece'])) {
                    $tier_rate[$row['bulk_rate3_quantity_upto']] = [
                        'quantity' => $row['bulk_rate3_quantity_upto'],
                        'price' => $row['bulk_rate3_price_per_piece']
                    ];
                }

                $tierRate = [];

                if (count($tier_rate) > 0) {
                    $min = 1;
                    foreach ($tier_rate as $bulk) {
                        $tierRate[] = [
                            'range' => [
                                'min' => $min, // You might want to adjust this according to your logic
                                'max' => (int) $bulk['quantity']
                            ],
                            'price' => $bulk['price']
                        ];
                        $min = (int) $bulk['quantity'] + 1;
                    }
                }

                $shippingRateArray = [];
                if (
                    !empty($row['shipping_rate1_quantity_upto']) && !empty($row['shipping_rate1_local']) &&
                    !empty($row['shipping_rate1_regional']) && !empty($row['shipping_rate1_national'])
                ) {
                    $shippingRateArray[$row['shipping_rate1_quantity_upto']] = [
                        'quantity' => $row['shipping_rate1_quantity_upto'],
                        'local' => $row['shipping_rate1_local'],
                        'regional' => $row['shipping_rate1_regional'],
                        'national' => $row['shipping_rate1_national']
                    ];
                }

                if (
                    !empty($row['shipping_rate2_quantity_upto']) && !empty($row['shipping_rate2_local']) &&
                    !empty($row['shipping_rate2_regional']) && !empty($row['shipping_rate2_national'])
                ) {
                    $shippingRateArray[$row['shipping_rate2_quantity_upto']] = [
                        'quantity' => $row['shipping_rate2_quantity_upto'],
                        'local' => $row['shipping_rate2_local'],
                        'regional' => $row['shipping_rate2_regional'],
                        'national' => $row['shipping_rate2_national']
                    ];
                }

                if (
                    !empty($row['shipping_rate3_quantity_upto']) && !empty($row['shipping_rate3_local']) &&
                    !empty($row['shipping_rate3_regional']) && !empty($row['shipping_rate3_national'])
                ) {
                    $shippingRateArray[$row['shipping_rate3_quantity_upto']] = [
                        'quantity' => $row['shipping_rate3_quantity_upto'],
                        'local' => $row['shipping_rate3_local'],
                        'regional' => $row['shipping_rate3_regional'],
                        'national' => $row['shipping_rate3_national']
                    ];
                }


                $tierShippingRate = [];
                $minRange = 1;
                if (count($shippingRateArray) > 0) {

                    foreach ($shippingRateArray as $shipping) {
                        $tierShippingRate[] = [
                            'range' => [
                                'min' => $minRange, // You might want to adjust this according to your logic
                                'max' => (int) $shipping['quantity']
                            ],
                            'local' => $shipping['local'],
                            'regional' => $shipping['regional'],
                            'national' => $shipping['national']
                        ];
                        $minRange = (int) $shipping['quantity'] + 1;
                    }
                }
                $calPackageWeightInKgusingDimesnsion =  calculateVolumetricWeight($row['package_length'], $row['package_width'], $row['package_height'], $row['package_dimension_unit']);
                $price = calculateInclusivePriceAndTax($row['per_piecedropship_rate'],$row['gst_bracket']);

                $productVariation = ProductVariation::create([
                    'product_id' => $product->id,
                    'company_id' => $company_id,
                    'title' => $row['product_name'],
                    'description' => $row['description'],
                    'model' => $row['model'],
                    'sku' => $row['sku'],
                    'dropship_rate' => $row['per_piecedropship_rate'],
                    'potential_mrp' => $row['potential_mrp'],
                    'product_slug_id' => '',
                    'slug' => '',
                    'availability_status' => $this->availabilityArray($row['availability']),
                    'size' => $row['size'],
                    'color' => strtolower($row['color']),
                    'length' => $row['length'],
                    'width' => $row['width'],
                    'height' => $row['height'],
                    'dimension_class' => $row['product_dimension_unit'],
                    'weight' => $row['weight'],
                    'weight_class' => $row['product_weight_unit'],
                    'package_volumetric_weight' => $calPackageWeightInKgusingDimesnsion,
                    'price_before_tax' =>  (float) $price['price_before_tax'],
                    'price_after_tax' =>   (float) $price['price_after_tax'],
                    'package_length' => $row['package_length'],
                    'package_width' => $row['package_width'],
                    'package_height' => $row['package_height'],
                    'package_dimension_class' => $row['package_dimension_unit'],
                    'package_weight' => $row['package_weight'],
                    'package_weight_class' => $row['package_weight_unit'],
                    'allow_editable' => 1,
                    'stock' => (int)$row['product_stock'],
                    'status' => ProductVariation::STATUS_DRAFT,
                    'tier_rate' => json_encode($tierRate),
                    'tier_shipping_rate' => json_encode($tierShippingRate),
                    'allow_editable' => ProductVariation::ALLOW_EDITABLE_TRUE,
                ]);

                $generateProductID = generateProductID($row['product_name'], $productVariation->id);
                // $productVariation->sku = generateSku($row['product_name'], $generateProductID);
                $productVariation->product_slug_id = $generateProductID;
                $productVariation->slug = generateSlug($row['product_name'], $generateProductID);
                $productVariation->save();

                // Add product features
                if(isset($row['product_features1'])){
                    $this->createFeatures($product->id, $company_id, $row['product_features1']);
                }
                if(isset($row['product_features2'])){
                    $this->createFeatures($product->id, $company_id, $row['product_features2']);
                }
                if($row['product_features3']){
                    $this->createFeatures($product->id, $company_id, $row['product_features3']);
                }

                // Add product keywords
                if (!empty($row['product_keywords'])) {
                    foreach ($tags as $key => $value) {
                        ProductKeyword::create([
                            'product_id' => $product->id,
                            'company_id' => $company_id,
                            'keyword' => $value
                        ]);
                    }
                }
                $this->loop++;
                $this->successCount++;
                DB::commit();

            } catch (\Exception $e) {
                $this->errorCount++;
                // dd(e->getMessage());
                \Log::error($e->getMessage());
                DB::rollBack();
                ImportErrorMessage::create([
                    'import_id' => $import->id,
                    'error_message' => $e->getMessage(),
                    'field_name' => $row['product_name'],
                    'row_number' => $this->loop,
                ]);
                $this->loop++;
                DB::commit();
                // Handle the exception, log it, etc.
            }
        }

        if($this->errorCount > 0 && $this->successCount == 0){
            $import->status = Import::STATUS_FAILED;
        }else{
            $import->status = Import::STATUS_SUCCESS;
        }
        $import->fail_count = $this->errorCount;
        $import->success_count = $this->successCount;
        $import->save();
        DB::commit();
    }

    /**
     * Create a new product feature.
     *
     * @param int $product_id The ID of the product.
     * @param int $company_id The ID of the company.
     * @param string $feature The feature name and value.
     * @return void
     */
    private function createFeatures($product_id, $company_id, $feature)
    {
        if (!empty($feature)) {
            ProductFeature::create([
                'product_id' => $product_id,
                'company_id' => $company_id,
                'feature_name' => $feature,
                'value' => $feature
            ]);
        }
    }

    /**
     * Returns the custom validation rules for the product import.
     *
     * @return array The custom validation rules.
     */
    private function myCustomValidationRule()
    {
        return  [
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_keywords' => 'required|string',
            'product_features1' => 'required|string',
            'product_features2' => 'nullable|string',
            'product_features3' => 'nullable|string',
            'sku' => 'required|string|min:3|max:10|unique:product_variations,sku|regex:/^[a-zA-Z0-9_-]+$/',
            'model' => 'nullable|string',
            'product_hsn' => 'required|digits_between:6,8|regex:/^\d{6,8}$/',
            'gst_bracket' => 'required|numeric|in:0,5,12,18,28',
            'availability' => 'required|in:Till Stock Last,Regular Available',
            'upc' => 'nullable|numeric',
            'isbn' => 'nullable|string',
            'mpn' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9- ]+$/',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'product_dimension_unit' => 'required|in:mm,cm,inch,m,in',
            'weight' => 'required|numeric',
            'product_weight_unit' => 'required|in:mg,gm,kg,ml,ltr',
            'package_length' => 'required|numeric',
            'package_width' => 'required|numeric',
            'package_height' => 'required|numeric',
            'package_weight' => 'required|numeric',
            'package_dimension_unit' => 'required|in:mm,cm,inch,m,in',
            'package_weight_unit' => 'required|in:mg,gm,kg,ml,ltr',
            'per_piecedropship_rate' => 'required|numeric|min:1',
            'potential_mrp' => 'required|numeric|min:1',
            'bulk_rate1_price_per_piece' => 'nullable|numeric',
            'bulk_rate1_quantity_upto' => 'nullable|numeric',
            'bulk_rate2_price_per_piece' => 'nullable|numeric',
            'bulk_rate2_quantity_upto' => 'nullable|numeric',
            'bulk_rate3_price_per_piece' => 'nullable|numeric',
            'bulk_rate3_quantity_upto' => 'nullable|numeric',
            'shipping_rate1_quantity_upto' => 'nullable|numeric',
            'shipping_rate1_local' => 'nullable|numeric',
            'shipping_rate1_regional' => 'nullable|numeric',
            'shipping_rate1_national' => 'nullable|numeric',
            'shipping_rate2_quantity_upto' => 'nullable|numeric',
            'shipping_rate2_local' => 'nullable|numeric',
            'shipping_rate2_regional' => 'nullable|numeric',
            'shipping_rate2_national' => 'nullable|numeric',
            'shipping_rate3_quantity_upto' => 'nullable|numeric',
            'shipping_rate3_local' => 'nullable|numeric',
            'shipping_rate3_regional' => 'nullable|numeric',
            'shipping_rate3_national' => 'nullable|numeric',
            'color' => 'required|string',
            'size' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'product_stock' => 'required|integer|min:1'
        ];
    }

    /**
     * Returns an array of validation messages for the import process.
     *
     * @return array
     */
    private function myValidationMessage(){
        return [
            "feature" => "The feature list field is required",
            "sku" => "The sku field is required and must be unique.",
            "sku.regex" => "The sku field must be alphanumeric and may contain dashes and underscores.",
            "*.stock.required" => "The stock field is required when no variant is present.",
            "*.stock.array" => "The stock must be an array.",
            "*.stock.min" => "The stock must have at least one entry.",
            "*.stock.*.required" => "Each stock entry is required and must be numeric.",
            "*.stock.*.numeric" => "Each stock entry must be a number.",
            "*.size.required" => "The size field is required when no variant is present.",
            "*.size.array" => "The size must be an array.",
            "*.size.min" => "The size must have at least one entry.",
            "*.size.*.required" => "Each size entry is required.",
            "*.size.*.string" => "Each size entry must be a string.",
            "*.media.required" => "The media field is required when no variant is present.",
            "*.media.array" => "The media must be an array.",
            "*.media.min" => "The media must have at least 5 images including main image.",
            "*.media.*.required" => "Each media entry is required.",
            "*.media.*.mimes" => "Each media entry must be an image or video (png, jpeg, jpg, mp4).",
            "*.color.required" => "The color field is required when no variant is present.",
            "*.color.string" => "The color must be a string.",
        ];
    }

    /**
     * Get the availability value based on the given availability string.
     *
     * @param string $availability The availability string.
     * @return int The availability value.
     */
    private function availabilityArray($availability)
    {
        $availabilityArray = [
            'Till Stock Last' => ProductInventory::TILL_STOCK_LAST,
            'Regular Available' => ProductInventory::REGULAR_AVAILABLE
        ];
        return $availabilityArray[$availability];
    }
}
