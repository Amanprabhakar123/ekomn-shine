<?php
namespace App\Imports;

use App\Models\ProductInventory;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use App\Models\ProductVariation;
use App\Models\ProductFeature;
use App\Models\ProductKeyword;



class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        DB::beginTransaction();

        try {
            $company_id = auth()->user()->companyDetails->id;
            $product = ProductInventory::create([
                'company_id' => $company_id,
                'title' => $row['Product Name'],
                'description' => $row['Description'],
                'model' => $row['Model'],
                'sku' => $row['SKU'],
                'hsn' => $row['Product HSN'],
                'gst_percentage' => $row['GST Bracket'],
                'availability_status' => $row['Availability'],
                'upc' => $row['UPC'],
                'isbn' => $row['ISBN'],
                'mpin' => $row['MPN'],
                'status' => $row['Listing Status']
            ]);

            $tier_rate = [];

            $tier_rate[$row['Bulk Rate1 - Quantity Upto']] =['quantity' => $row['Bulk Rate1 - Quantity Upto'],
             'price' =>  $row['Bulk Rate1 - Price per piece']];
             $tier_rate[$row['Bulk Rate2 - Quantity Upto']] =['quantity' => $row['Bulk Rate2 - Quantity Upto'],
             'price' =>  $row['Bulk Rate2 - Price per piece']];
             $tier_rate[$row['Bulk Rate3 - Quantity Upto']] =['quantity' => $row['Bulk Rate3 - Quantity Upto'],
             'price' =>  $row['Bulk Rate3 - Price per piece']];

            $shippingRateArray =[];
            $shippingRateArray[$row['Shipping Rate1 - Quantity Upto']] = ['quantity' => $row['Shipping Rate1 - Quantity Upto'],
            'local' =>  $row['Shipping Rate1 - Local'], 'regional' =>  $row['Shipping Rate1 - Regional'],
            'national' =>  $row['Shipping Rate1 - National']];

            $shippingRateArray[$row['Shipping Rate2 - Quantity Upto']] = ['quantity' => $row['Shipping Rate2 - Quantity Upto'],
            'local' =>  $row['Shipping Rate2 - Local'], 'regional' =>  $row['Shipping Rate2 - Regional'],
            'national' =>  $row['Shipping Rate2 - National']];

            $shippingRateArray[$row['Shipping Rate3 - Quantity Upto']] =['quantity' => $row['Shipping Rate3 - Quantity Upto'],
            'local' =>  $row['Shipping Rate3 - Local'], 'regional' =>  $row['Shipping Rate3 - Regional'],
            'national' =>  $row['Shipping Rate3 - National']];

            $productVariation = ProductVariation::create([
                'product_id' => $product->id,
                'company_id' => $company_id,
                'title' => $row['Product Name'],
                'description' => $row['Description'],
                'model' => $row['Model'],
                'sku' => $row['SKU'],
                'dropship_rate' => $row['Per piece/Dropship rate'],
                'potential_mrp' => $row['Potential MRP'],
                'product_slug_id' => '',
                'slug' => '',
                'availability_status' => $row['Availability'],
                'size' => $row['Size'],
                'color' => $row['Color'],
                'length' => $row['Length'],
                'width' => $row['Width'],
                'height' => $row['Height'],
                'dimension_class' => $row['Product Dimension Unit'],
                'weight' => $row['Weight'],
                'weight_class' => $row['Product Weight Unit'],
                'package_length' => $row['Package Length'],
                'package_width' => $row['Package Width'],
                'package_height' => $row['Package Height'],
                'package_dimension_class' => $row['Package Dimension Unit'],
                'package_weight' => $row['Package Weight'],
                'package_weight_class' => $row['Package Weight Unit'],
                'allow_editable' => 1,
                'stock' => (int) $row['Product Stock'],
                'status' => $row['Listing Status']
            ]);

            $generateProductID = generateProductID($row['Product Name'], $productVariation->id);
            $productVariation->product_slug_id = $generateProductID;
            $productVariation->slug = generateSlug($row['Product Name'], $generateProductID);
            $productVariation->save();

            $this->createFeatures($product->id, $company_id, $row['Product Features1']);
            $this->createFeatures($product->id, $company_id, $row['Product Features2']);
            $this->createFeatures($product->id, $company_id, $row['Product Features3']);



        if(!empty($row['Product Keywords'])){
                foreach (explode(",", $row['Product Keywords']) as $key => $value) {
                    ProductKeyword::create([
                        'product_id' => $product->id,
                        'company_id' => $company_id,
                        'keyword' => $value
                    ]);
                }
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception, log it, etc.
        }
    }

    private function createFeatures($product_id, $company_id, $feature){
        if(!empty($feature)){
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
            '*.Product Name' => 'required|string|max:255',
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
            '*.Listing Status' => 'nullable|string',
        ];
    }
}
