<?php

namespace App\Transformers;

use App\Models\Order;
use App\Models\Charges;
use App\Models\Pincode;
use App\Models\AddToCart;
use Illuminate\Support\Facades\Log;
use App\Models\CompanyAddressDetail;
use League\Fractal\TransformerAbstract;

class ProductCartListTransformer extends TransformerAbstract
{
    protected $shippingCost = 0;
    protected $shippingCostGst = 0;
    protected $totalCost = 0;
    protected $packingCharges = 0;
    protected $packingChargesGst = 0;
    protected $labourCharges = 0;
    protected $labourChargesGst = 0;
    protected $referalChargesPer = 0;
    protected $referalChargesPerCharges = 0;
    protected $referalChargesPerGst = 0;
    protected $overAllCost = 0;
    protected $processingCost = 0;
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Transform the given Import model into a formatted array.
     *
     * @return array
     */
    public function transform(AddToCart $cartList)
    {
        try {
            $product_variation = $cartList->product;
            // Assuming $cartList is an object containing product details
            $gst = (float) $product_variation->product->gst_percentage; // Assuming GST is in $cartList->gst_percentage
            $priceBeforeTaxPerPiece = $cartList->getPriceBasedOnQuantity($product_variation->tier_rate, $cartList->quantity); // Calculate price before tax
            $priceBeforeTaxWIthQantity = (float) $priceBeforeTaxPerPiece * $cartList->quantity; // Calculate price before tax and format to 2 decimal places
            $gstAmount = (float) number_format((($priceBeforeTaxWIthQantity * $gst) / 100), 2); // Calculate GST amount
            $priceWithGst = $priceBeforeTaxWIthQantity + $gstAmount; // Calculate total price including GST

            // find the zone of the buyer
            $supplierPincode = $product_variation->company->address->where('address_type', CompanyAddressDetail::TYPE_PICKUP_ADDRESS)->first();
            if ($supplierPincode) {
                $supplierPincode = $supplierPincode->pincode;
            }
            $zone = $cartList->getPricesBasedOnQuantity($product_variation->tier_shipping_rate, $cartList->quantity);

            if ($this->request['pincode']) {
                $distance = Pincode::calculateDistance($supplierPincode, $this->request['pincode']);
                $this->shippingCost = $zone[isset($distance['distance']) ? strtolower($distance['zone']) : 'national'];
            } else {
                $this->shippingCost = end($zone);
            }
            if ($this->request['order_type'] == Order::ORDER_TYPE_DROPSHIP) {
                // Shipping Charges GST
                $shipping = Charges::getValueByOrderTypeAndCharge(Charges::DROPSHIP, Charges::SHIPPING_CHARGES)->first();
                if ($shipping) {
                    $this->shippingCostGst = (float) number_format(($this->shippingCost * (int) $shipping->gst_bracket) / 100, 2);
                } else {
                    $this->shippingCostGst = (float) number_format(($this->shippingCost * 18) / 100, 2);
                }
                // Packing Charges
                $packing_charges = Charges::getValueByOrderTypeAndCharge(Charges::DROPSHIP, Charges::PACKING_CHARGES)->get()->toArray();
                $this->packingCharges = Charges::getValueBasedOnAmount($packing_charges, $priceBeforeTaxWIthQantity);
                $this->packingChargesGst = (float) number_format((((float) $this->packingCharges * (int) $packing_charges[0]['gst_bracket']) / 100), 2);
                // Labour Charges
                $labour_charges = Charges::getValueByOrderTypeAndCharge(Charges::DROPSHIP, Charges::LABOUR_CHARGES)->get()->toArray();
                $this->labourCharges = Charges::getValueBasedOnAmount($labour_charges, $priceBeforeTaxWIthQantity);
                $this->labourChargesGst = (float) number_format((((float) $this->labourCharges * (int) $labour_charges[0]['gst_bracket']) / 100), 2);
                // Referal Charges
                $referal_charges = Charges::getValueByOrderTypeAndCharge(Charges::DROPSHIP, Charges::REFERRAL_CHARGES)->get()->toArray();
                $this->referalChargesPer = Charges::getValueBasedOnAmount($referal_charges, $priceBeforeTaxWIthQantity);
                $this->referalChargesPerCharges = (float) number_format(($priceBeforeTaxWIthQantity * (int) $this->referalChargesPer) / 100, 2);
                $this->referalChargesPerGst = (float) number_format(($this->referalChargesPerCharges * (int) $referal_charges[0]['gst_bracket']) / 100, 2);
                $this->totalCost = $priceWithGst + $this->shippingCost + $this->shippingCostGst + (float) $this->packingCharges + $this->packingChargesGst + (float) $this->labourCharges + $this->labourChargesGst + $this->referalChargesPerCharges + $this->referalChargesPerGst;
                // Process Charges
                $process_charges_per = 0;
                $process_charges_amount = 0;
                $process_charges = Charges::getValueByOrderTypeAndCharge(Charges::DROPSHIP, Charges::PROCESSING_CHARGES)->first();
                if ($process_charges) {
                    $process_charges_per = (float) number_format(($this->totalCost * (int) $process_charges->value) / 100, 2);
                    $process_charges_amount = (float) number_format(($process_charges_per * $process_charges->gst_bracket) / 100, 2);
                    $this->processingCost +=  number_format(($process_charges_per + $process_charges_amount), 2);
                } else {
                    $process_charges_per = (float) number_format(($this->totalCost * 2) / 100, 2);
                    $process_charges_amount = (float) number_format(($process_charges_per * 18) / 100, 2);
                    $this->processingCost +=  number_format(($process_charges_per + $process_charges_amount), 2);
                }
            } elseif ($this->request['order_type'] == Order::ORDER_TYPE_BULK) {
                // Shipping Charges GST
                $shipping = Charges::getValueByOrderTypeAndCharge(Charges::BULK, Charges::SHIPPING_CHARGES)->first();
                if ($shipping) {
                    $this->shippingCostGst = (float) number_format(($this->shippingCost * (int) $shipping->gst_bracket) / 100, 2);
                } else {
                    $this->shippingCostGst = (float) number_format(($this->shippingCost * 18) / 100, 2);
                }
                // Packing Charges
                $packing_charges = Charges::getValueByOrderTypeAndCharge(Charges::BULK, Charges::PACKING_CHARGES)->get()->toArray();
                $this->packingCharges = Charges::getValueBasedOnAmount($packing_charges, $priceBeforeTaxWIthQantity);
                $this->packingChargesGst = (float) number_format((((float) $this->packingCharges * (int) $packing_charges[0]['gst_bracket']) / 100), 2);
                // Labour Charges
                $labour_charges = Charges::getValueByOrderTypeAndCharge(Charges::BULK, Charges::LABOUR_CHARGES)->get()->toArray();
                $this->labourCharges = Charges::getValueBasedOnAmount($labour_charges, $priceBeforeTaxWIthQantity);
                $this->labourChargesGst = (float) number_format((((float) $this->labourCharges * (int) $labour_charges[0]['gst_bracket']) / 100), 2);
                // Referal Charges
                $referal_charges = Charges::getValueByOrderTypeAndCharge(Charges::BULK, Charges::REFERRAL_CHARGES)->get()->toArray();
                $this->referalChargesPer = Charges::getValueBasedOnAmount($referal_charges, $priceBeforeTaxWIthQantity);
                $this->referalChargesPerCharges = (float) number_format(($priceBeforeTaxWIthQantity * (int) $this->referalChargesPer) / 100, 2);
                $this->referalChargesPerGst = (float) number_format(($this->referalChargesPerCharges * (int) $referal_charges[0]['gst_bracket']) / 100, 2);
                $this->totalCost = $priceWithGst + $this->shippingCost + $this->shippingCostGst + (float) $this->packingCharges + $this->packingChargesGst + (float) $this->labourCharges + $this->labourChargesGst + $this->referalChargesPerCharges + $this->referalChargesPerGst;
                // Process Charges
                $process_charges_per = 0;
                $process_charges_amount = 0;
                $process_charges = Charges::getValueByOrderTypeAndCharge(Charges::BULK, Charges::PROCESSING_CHARGES)->first();
                if ($process_charges) {
                    $process_charges_per = (float) number_format(($this->totalCost * (int) $process_charges->value) / 100, 2);
                    $process_charges_amount = (float) number_format(($process_charges_per * $process_charges->gst_bracket) / 100, 2);
                    $this->processingCost +=  number_format(($process_charges_per + $process_charges_amount), 2);
                } else {
                    $process_charges_per = (float) number_format(($this->totalCost * 2) / 100, 2);
                    $process_charges_amount = (float) number_format(($process_charges_per * 18) / 100, 2);
                    $this->processingCost +=  number_format(($process_charges_per + $process_charges_amount), 2);
                }
            } elseif ($this->request['order_type'] == Order::ORDER_TYPE_RESELL) {
                // Shipping Charges GST
                $shipping = Charges::getValueByOrderTypeAndCharge(Charges::RESELL, Charges::SHIPPING_CHARGES)->first();
                if ($shipping) {
                    $this->shippingCostGst = (float) number_format(($this->shippingCost * (int) $shipping->gst_bracket) / 100, 2);
                } else {
                    $this->shippingCostGst = (float) number_format(($this->shippingCost * 18) / 100, 2);
                }
                // Packing Charges
                $packing_charges = Charges::getValueByOrderTypeAndCharge(Charges::RESELL, Charges::PACKING_CHARGES)->get()->toArray();
                $this->packingCharges = Charges::getValueBasedOnAmount($packing_charges, $priceBeforeTaxWIthQantity);
                $this->packingChargesGst = (float) number_format((((float) $this->packingCharges * (int) $packing_charges[0]['gst_bracket']) / 100), 2);
                // Labour Charges
                $labour_charges = Charges::getValueByOrderTypeAndCharge(Charges::RESELL, Charges::LABOUR_CHARGES)->get()->toArray();
                $this->labourCharges = Charges::getValueBasedOnAmount($labour_charges, $priceBeforeTaxWIthQantity);
                $this->labourChargesGst = (float) number_format((((float) $this->labourCharges * (int) $labour_charges[0]['gst_bracket']) / 100), 2);
                // Referal Charges
                $referal_charges = Charges::getValueByOrderTypeAndCharge(Charges::RESELL, Charges::REFERRAL_CHARGES)->get()->toArray();
                $this->referalChargesPer = Charges::getValueBasedOnAmount($referal_charges, $priceBeforeTaxWIthQantity);
                $this->referalChargesPerCharges = (float) number_format(($priceBeforeTaxWIthQantity * (int) $this->referalChargesPer) / 100, 2);
                $this->referalChargesPerGst = (float) number_format(($this->referalChargesPerCharges * (int) $referal_charges[0]['gst_bracket']) / 100, 2);
                $this->totalCost = $priceWithGst + $this->shippingCost + $this->shippingCostGst + (float) $this->packingCharges + $this->packingChargesGst + (float) $this->labourCharges + $this->labourChargesGst + $this->referalChargesPerCharges + $this->referalChargesPerGst;
                // Process Charges
                $process_charges_per = 0;
                $process_charges_amount = 0;
                $process_charges = Charges::getValueByOrderTypeAndCharge(Charges::RESELL, Charges::PROCESSING_CHARGES)->first();
                if ($process_charges) {
                    $process_charges_per = (float) number_format(($this->totalCost * (int) $process_charges->value) / 100, 2);
                    $process_charges_amount = (float) number_format(($process_charges_per * $process_charges->gst_bracket) / 100, 2);
                    $this->processingCost +=  number_format(($process_charges_per + $process_charges_amount), 2);
                } else {
                    $process_charges_per = (float) number_format(($this->totalCost * 2) / 100, 2);
                    $process_charges_amount = (float) number_format(($process_charges_per * 18) / 100, 2);
                    $this->processingCost +=  number_format(($process_charges_per + $process_charges_amount), 2);
                }
            }
            // over all cost
            $this->overAllCost += (float) $this->totalCost + $this->processingCost;

            // Return the transformed data
            $data = [
                'id' => salt_encrypt($cartList->id),
                'product_id' => salt_encrypt($product_variation->id),
                'title' => $product_variation->title,
                'stock' => $product_variation->stock,
                'hsn' => $product_variation->product->hsn,
                'sku' => $product_variation->sku,
                'quantity' => $cartList->quantity,
                'price_per_piece' => $priceBeforeTaxPerPiece,
                'gstAmount' => $gstAmount,
                'gst_percentage' => $gst,
                'priceWithGst' => $priceWithGst,
                'shippingCost' => (float) $this->shippingCost + $this->shippingCostGst,
                'otherCost' =>  $this->packingCharges + $this->packingChargesGst + $this->labourCharges + $this->labourChargesGst + $this->referalChargesPerCharges + $this->referalChargesPerGst + $this->processingCost,
                'totalCost' => (float) $this->totalCost, // excluding processing cost  // including shipping and other charges
                'processingCost' => (float) $this->processingCost, // including GST
                'overAllCost' => (float) $this->overAllCost,
            ];
            return $data;
        } catch (\Exception $e) {
            // Handle the exception here
            Log::error('Error transforming Import: ' . $e->getMessage());
        }
    }
}
