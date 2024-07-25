<?php

namespace App\Transformers;

use App\Models\Import;
use App\Models\ProductVariation;
use League\Fractal\TransformerAbstract;

class ProductSkuTransformer extends TransformerAbstract
{
    /**
     * Transform the given Import model into a formatted array.
     *
     * @return array
     */
    public function transform(ProductVariation $product)
    {

        // Assuming $product is an object containing product details
        $gst = (float) $product->product->gst_percentage; // Assuming GST is in $product->gst_percentage
        $priceBeforeTax = (float) $product->price_before_tax; // Convert price to float
        $gstAmount = ($gst / 100) * $priceBeforeTax; // Calculate GST amount
        $priceWithGst = $priceBeforeTax + $gstAmount; // Calculate total price including GST
        // $totalCost += $priceWithGst;
        try {
            $data = [
                'product_id' => $product->product_id,
                'title' => $product->title,
                'stock' => $product->stock,
                'hsn' => $product->product->hsn,
                'sku' => $product->sku,
                'price_before_tax' => $priceBeforeTax,
                'gst_percentage' => $gst,
                'priceWithGst' => $priceWithGst,
                'gstAmount' => $gstAmount,
                'totalCost' => $priceWithGst,

            ];

            return $data;
        } catch (\Exception $e) {
            // Handle the exception here
            // You can log the error, return a default value, or throw a custom exception
            // For example, you can log the error and return an empty array
            \Log::error('Error transforming Import: '.$e->getMessage());

            return [];
        }
    }
}
