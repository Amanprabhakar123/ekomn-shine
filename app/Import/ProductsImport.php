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

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    private $successCount = 0;
    private $errorCount = 0;


    public function model(array $row)
    {
       // DB::beginTransaction();
 
       if(!empty($row)){

        try {
            $company_id = auth()->user()->companyDetails->id;
            $user_id = auth()->user()->id;

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

           // DB::commit();
            $this->successCount++;

        } catch (\Exception $e) {
            $this->errorCount++;
            dd($e->getMessage());
           // DB::rollBack();
            // Handle the exception, log it, etc.
        }
    }
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
           /* '*.Product Name' => 'required|string|max:255',
            '*.Description' => 'nullable|string',
            '*.Product Keywords' => 'nullable|string',
            '*.Product Features1' => 'nullable|string',
            '*.Product Features2' => 'nullable|string',
            '*.Product Features3' => 'nullable|string',
            '*.Model' => 'nullable|string',
            '*.SKU' => 'nullable|string',
            '*.Product HSN' => 'nullable|string',
            '*.GST Bracket' => 'nullable|string',
            '*.Availability' => 'nullable|string',
            '*.UPC' => 'nullable|string',
            '*.ISBN' => 'nullable|string',
            '*.MPN' => 'nullable|string',
            '*.Length' => 'nullable|numeric',
            '*.Width' => 'nullable|numeric',
            '*.Height' => 'nullable|numeric',
            '*.Product Dimension Unit' => 'nullable|string',
            '*.Weight' => 'nullable|numeric',
            '*.Product Weight Unit' => 'nullable|string',
            '*.Package Length' => 'nullable|numeric',
            '*.Package Width' => 'nullable|numeric',
            '*.Package Height' => 'nullable|numeric',
            '*.Package Weight' => 'nullable|numeric',
            '*.Package Dimension Unit' => 'nullable|string',
            '*.Package Weight Unit' => 'nullable|string',
            '*.Per piece/Dropship rate' => 'nullable|numeric',
            '*.Potential MRP' => 'nullable|numeric',
            '*.Bulk Rate1 - Quantity Upto' => 'nullable|numeric',
            '*.Bulk Rate1 - Price per piece' => 'nullable|numeric',
            '*.Bulk Rate2 - Quantity Upto' => 'nullable|numeric',
            '*.Bulk Rate2 - Price per piece' => 'nullable|numeric',
            '*.Bulk Rate3 - Quantity Upto' => 'nullable|numeric',
            '*.Bulk Rate3 - Price per piece' => 'nullable|numeric',
            '*.Shipping Rate1 - Quantity Upto' => 'nullable|numeric',
            '*.Shipping Rate1 - Local' => 'nullable|numeric',
            '*.Shipping Rate1 - Regional' => 'nullable|numeric',
            '*.Shipping Rate1 - National' => 'nullable|numeric',
            '*.Shipping Rate2 - Quantity Upto' => 'nullable|numeric',
            '*.Shipping Rate2 - Local' => 'nullable|numeric',
            '*.Shipping Rate2 - Regional' => 'nullable|numeric',
            '*.Shipping Rate2 - National' => 'nullable|numeric',
            '*.Shipping Rate3 - Quantity Upto' => 'nullable|numeric',
            '*.Shipping Rate3 - Local' => 'nullable|numeric',
            '*.Shipping Rate3 - Regional' => 'nullable|numeric',
            '*.Shipping Rate3 - National' => 'nullable|numeric',
            '*.Color' => 'nullable|string',
            '*.Size' => 'nullable|string',
            '*.Product Stock' => 'nullable|integer',
            '*.Listing Status' => 'nullable|string',*/
        ];
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getErrorCount()
    {
        return $this->getErrorCount;
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
