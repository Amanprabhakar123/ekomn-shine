<?php

namespace App\Import;

use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\ProductFeature;
use App\Models\ProductKeyword;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Storage;
use App\Models\Import;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Validator;

class ProductsImport implements ToCollection, WithHeadingRow, WithValidation,SkipsOnFailure,SkipsEmptyRows
{
    use Importable,SkipsFailures;

    private $successCount = 0;
    private $errorCount = 0;

    private $import_id;

    public function __construct($import_id)
    {
        $this->import_id = $import_id;
    }
    

    public function collection(Collection $rows)
    {
      //  DB::beginTransaction();
                      //$company_id = auth()->user()->companyDetails->id;
               // $user_id = auth()->user()->id;
    
               $company_id = 1;
               $user_id = 1;
        $is_error_heading = false;
        $errorFilePath = storage_path('app/public/product_import_error/errors_' . $this->import_id . '.csv');
        $errorFile = fopen($errorFilePath, 'w');
        $import = Import::where('id', $this->import_id)->first();

        foreach ($rows->toArray() as $key => $row) {
            try {
               $validator =  Validator::make($row, $this->myCustomValidationRule());
               if($validator->fails()){
                   if(!$is_error_heading){
                    $errorFile = fopen($errorFilePath, 'w');
                    fputcsv($errorFile,array_merge(array_keys($row, ['error'])));
                    $is_error_heading = true;
                   }
                   fputcsv($errorFile,array_merge(array_values($row), [$validator->errors()->first()]));
                   $this->errorCount++;
                   continue;

               }

    
                $row['listing_status'] = $this->getListingStatus($row['listing_status']);
                $tags = explode(",", $row['product_keywords']);
                $tagData = fetchCategoryFromProductTags($tags);
                $product = ProductInventory::create([
                    'company_id' => $company_id,
                    'title' => $row['product_name'],
                    'description' => $row['description'],
                    'model' => $row['model'],
                    'sku' => 'rg',
                    'hsn' => $row['product_hsn'],
                    'gst_percentage' => $row['gst_bracket'],
                    'availability_status' => $this->availabilityArray($row['availability']),
                    'upc' => $row['upc'],
                    'isbn' => $row['isbn'],
                    'mpin' => $row['mpn'],
                    'status' => $row['listing_status'],
                    'product_category' => $tagData['main_category_id'],
                    'product_subcategory' => $tagData['sub_category_id'],
                    'user_id' => $user_id,
                ]);
    
    
                $tier_rate = [];
                if(!empty($row['bulk_rate1_quantity_upto']) && !empty($row['bulk_rate1_price_per_piece'])){
                    $tier_rate[$row['bulk_rate1_quantity_upto']] = [
                        'quantity' => $row['bulk_rate1_quantity_upto'],
                        'price' => $row['bulk_rate1_price_per_piece']
                    ];
                }
                if(!empty($row['bulk_rate2_quantity_upto']) && !empty($row['bulk_rate2_price_per_piece'])){
                    $tier_rate[$row['bulk_rate2_quantity_upto']] = [
                        'quantity' => $row['bulk_rate2_quantity_upto'],
                        'price' => $row['bulk_rate2_price_per_piece']
                    ];
                }
                if(!empty($row['bulk_rate3_quantity_upto']) && !empty($row['bulk_rate3_price_per_piece'])){
                    $tier_rate[$row['bulk_rate3_quantity_upto']] = [
                        'quantity' => $row['bulk_rate3_quantity_upto'],
                        'price' => $row['bulk_rate3_price_per_piece']
                    ];
                }
    
                $tierRate = [];
    
                if(count($tier_rate) > 0){
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
                if(!empty($row['shipping_rate1_quantity_upto']) && !empty($row['shipping_rate1_local']) &&
                 !empty($row['shipping_rate1_regional']) && !empty($row['shipping_rate1_national'])){
                    $shippingRateArray[$row['shipping_rate1_quantity_upto']] = [
                        'quantity' => $row['shipping_rate1_quantity_upto'],
                        'local' => $row['shipping_rate1_local'],
                        'regional' => $row['shipping_rate1_regional'],
                        'national' => $row['shipping_rate1_national']
                    ];
                }
    
                if(!empty($row['shipping_rate2_quantity_upto']) && !empty($row['shipping_rate2_local']) &&
                !empty($row['shipping_rate2_regional']) && !empty($row['shipping_rate2_national'])){
                   $shippingRateArray[$row['shipping_rate2_quantity_upto']] = [
                       'quantity' => $row['shipping_rate2_quantity_upto'],
                       'local' => $row['shipping_rate2_local'],
                       'regional' => $row['shipping_rate2_regional'],
                       'national' => $row['shipping_rate2_national']
                   ];
               }
    
               if(!empty($row['shipping_rate3_quantity_upto']) && !empty($row['shipping_rate3_local']) &&
               !empty($row['shipping_rate3_regional']) && !empty($row['shipping_rate3_national'])){
                  $shippingRateArray[$row['shipping_rate3_quantity_upto']] = [
                      'quantity' => $row['shipping_rate3_quantity_upto'],
                      'local' => $row['shipping_rate3_local'],
                      'regional' => $row['shipping_rate3_regional'],
                      'national' => $row['shipping_rate3_national']
                  ];
              }
    
    
                $tierShippingRate = [];
                $minRange = 1;
                if(count($shippingRateArray) > 0){
    
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
               $getPackageVolumetricWeight = convertKg($calPackageWeightInKgusingDimesnsion, $row['package_weight_unit']);
    
                $productVariation = ProductVariation::create([
                    'product_id' => $product->id,
                    'company_id' => $company_id,
                    'title' => $row['product_name'],
                    'description' => $row['description'],
                    'model' => $row['model'],
                    'sku' => '',
                    'dropship_rate' => $row['per_piecedropship_rate'],
                    'potential_mrp' => $row['potential_mrp'],
                    'product_slug_id' => '',
                    'slug' => '',
                    'availability_status' => $this->availabilityArray($row['availability']),
                    'size' => $row['size'],
                    'color' => $row['color'],
                    'length' => $row['length'],
                    'width' => $row['width'],
                    'height' => $row['height'],
                    'dimension_class' => $row['product_dimension_unit'],
                    'weight' => $row['weight'],
                    'weight_class' => $row['product_weight_unit'],
                    'package_volumetric_weight' => $getPackageVolumetricWeight,
                    'package_length' => $row['package_length'],
                    'package_width' => $row['package_width'],
                    'package_height' => $row['package_height'],
                    'package_dimension_class' => $row['package_dimension_unit'],
                    'package_weight' => $row['package_weight'],
                    'package_weight_class' => $row['package_weight_unit'],
                    'allow_editable' => 1,
                    'stock' => (int)$row['product_stock'],
                    'status' => $row['listing_status'],
                    'tier_rate' => json_encode($tierRate),
                    'tier_shipping_rate' => json_encode($tierShippingRate),
                    'allow_editable' => 1
                ]);
    
                $generateProductID = generateProductID($row['product_name'], $productVariation->id);
                $productVariation->sku = generateSku($row['product_name'], $generateProductID);
                $productVariation->product_slug_id = $generateProductID;
                $productVariation->slug = generateSlug($row['product_name'], $generateProductID);
                $productVariation->save();
    
                $this->createFeatures($product->id, $company_id, $row['product_features1']);
                $this->createFeatures($product->id, $company_id, $row['product_features2']);
                $this->createFeatures($product->id, $company_id, $row['product_features3']);
    
                if (!empty($row['product_keywords'])) {
                    foreach ($tags as $key => $value) {
                        ProductKeyword::create([
                            'product_id' => $product->id,
                            'company_id' => $company_id,
                            'keyword' => $value
                        ]);
                    }
                }
    
                $this->successCount++;
               // DB::commit();
    
            } catch (\Exception $e) {
                $this->errorCount++;
                \Log::info($e->getMessage());
                           // DB::rollBack();
                // Handle the exception, log it, etc.
            }
        }

        fclose($errorFile);
        if (file_exists($errorFilePath) && !$is_error_heading) {
            unlink($errorFilePath);
        } 
        $import->error_file = $is_error_heading ? 'product_import_error/errors_' . $this->import_id . '.csv' : null;
        $import->status = Import::STATUS_SUCCESS;
        $import->fail_count = $this->errorCount;
        $import->success_count = $this->successCount;
        $import->save();
    
    }

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

    public function rules(): array
    {
        return [
       
        ];
    }

    private function myCustomValidationRule() {
       return  [
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_keywords' => 'required|string',
            'product_features1' => 'required|string',
            'product_features2' => 'nullable|string',
            'product_features3' => 'nullable|string',
            'model' => 'nullable|string',
            'product_hsn' => 'required|digits_between:6,8|regex:/^\d{6,8}$/',
            'gst_bracket' => 'required|numeric|in:0,5,12,18,28',
            'availability' => 'required|in:Till Stock Last,Regular Available',
            'upc' => 'nullable|numeric',
            'isbn' => 'nullable|string|regex:/^\d{10}(\d{3})?$/',
            'mpn' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9- ]+$/',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'product_dimension_unit' => 'required|in:mm,cm,inch',
            'weight' => 'required|numeric',
            'product_weight_unit' => 'required|in:mg,gm,kg,ml,ltr',
            'package_length' => 'required|numeric',
            'package_width' => 'required|numeric',
            'package_height' => 'required|numeric',
            'package_weight' => 'required|numeric',
            'package_dimension_unit' => 'required|in:mm,cm,inch',
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
            'size' => 'required|string',
            'product_stock' => 'required|integer|min:1',
            'listing_status' => 'required|in:Active,Inactive,Out of Stock,Draft',
        ];
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }

    private function availabilityArray($availibity){
        $availabilityArray = ['Till Stock Last' => 1,
                            'Regular Available' => 2
    ];
    return $availabilityArray[$availibity];

    }
    

    private function getListingStatus($listingStatus){
        $listingStatusArray = [
            'Active' => ProductInventory::STATUS_ACTIVE,
            'Inactive' =>  ProductInventory::STATUS_INACTIVE,
            'Out of Stock' =>  ProductInventory::STATUS_OUT_OF_STOCK,
            'Draft' =>  ProductInventory::STATUS_DRAFT
    ];
    return $listingStatusArray[$listingStatus];
    } 
}
