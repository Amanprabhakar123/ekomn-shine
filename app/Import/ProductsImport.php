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

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        DB::beginTransaction();

        try {

            $product = ProductInventory::create([
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

            $product = ProductInventory::create([
                'product_name' => $row['Product Name'],
                'description' => $row['Description'],
                'product_keywords' => $row['Product Keywords'],
                'product_features1' => $row['Product Features1'],
                'product_features2' => $row['Product Features2'],
                'product_features3' => $row['Product Features3'],
                'model' => $row['Model'],
                'sku' => $row['SKU'],
                'product_hsn' => $row['Product HSN'],
                'gst_bracket' => $row['GST Bracket'],
                'availability' => $row['Availability'],
                'upc' => $row['UPC'],
                'isbn' => $row['ISBN'],
                'mpn' => $row['MPN'],
                'length' => $row['Length'],
                'width' => $row['Width'],
                'height' => $row['Height'],
                'product_dimension_unit' => $row['Product Dimension Unit'],
                'weight' => $row['Weight'],
                'product_weight_unit' => $row['Product Weight Unit'],
            ]);

            // Insert related data into other tables, use the $product->id for foreign key reference
            OtherModel::create([
                'product_id' => $product->id,
                'other_field' => $row['Other Field'],
                // Add other fields as necessary
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception, log it, etc.
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
