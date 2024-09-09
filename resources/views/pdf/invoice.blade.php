<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body style="padding: 0;margin: 0;">
  <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border-radius: 10px 10px 10px 10px; width: 100%;">
    <tr>
      <td style="padding: 0px 0px 20px 0px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td align="left"><img src="{{$logo}}" width="140" alt="logo" border="0" /></td>
            <td style="font-size: 21px; color: #131A22; font-weight: bold; font-family: 'Open Sans', sans-serif; line-height: 1.5; vertical-align: top; text-align: right;">
              Tax Invoice
            </td>
          </tr>
          <tr><td height="20"></td><td height="20"></td></tr>
          <tr>
            <td style="width: 50%; vertical-align: top;">
              <h3 style="font-size: 14px; color: #131A22; font-family: 'Open Sans', sans-serif;margin: 0px 0px 2px 0px">Shipping Address</h3>
              <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;margin: 0; line-height: 18px;">
              {{ $full_name }} <br>
              {{ $billing_address }}<br>
                {{ $mobile_number }}
              </p>
            </td>
            <td style="width: 50%; vertical-align: top;">
            <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif; margin: 0; text-align: right;">
                <strong style="vertical-align: middle;">Invoice Date:</strong>
                <span style="display: inline-block; width: 120px; vertical-align: middle;margin-top:4px;">{{$invoice_date}}</span>
            </p>

              <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;margin: 0px 0px 4px 0px; text-align: right;">
                <strong style="vertical-align: middle;">Invoice No:</strong><span style="display: inline-block;width:120px;font-size: 12px; vertical-align: middle;margin-top:4px;">{{ $invoice_number }}</span>
              </p>
              <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;margin: 0px 0px 4px 0px; text-align: right;">
                <strong  style="vertical-align: middle;">Order Ref No:</strong><span style="display: inline-block;width:120px;font-size: 12px; vertical-align: middle;margin-top:4px;">{{ $order_number }}</span>
              </p>
            </td>
          </tr>
          <tr><td height="20"></td><td height="20"></td></tr>
          <tr>
            <td style="width: 50%; vertical-align: top;">
              <h3 style="font-size: 14px; color: #131A22; font-family: 'Open Sans', sans-serif;margin: 0px 0px 2px 0px">Billing Address</h3>
              <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;margin: 0; line-height: 18px;">
              {{ $full_name }}<br>
              {{ $shipping_address }}<br>
              {{ $mobile_number }}
              </p>
            </td>
            <td style="width: 50%; vertical-align: top;text-align: right;">
              <h3 style="font-size: 14px; color: #131A22; font-family: 'Open Sans', sans-serif;margin: 0px 0px 2px 0px">Sold By</h3>
              <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;margin: 0; line-height: 18px;">
                {{$supplier_bussiens_name}}<br>
                Delhi 122001<br>
                GST No: {{$supplier_gst}}
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 20px 0px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 2px;border-bottom: 1px solid #131A22;width: 250px;text-align: left;">Details</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: left;">HSN</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: right;white-space: nowrap;">Unit Price</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: center;">Qty.</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: right;">Discount</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: right;white-space: nowrap;">GST %</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: right;white-space: nowrap;">Tax Amt</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 2px;border-bottom: 1px solid #131A22;text-align: right;white-space: nowrap;">Total Amt</th>
            </tr>
          </thead>
          <tbody>
        @php 
        $shipping_charges = 0;
        $shipping_gst_percent = 0;
        $shiping_gst_amount = 0;
        $shipping_cost = 0;
        $other_charges = 0;
        $labour_gst = 0;
        $gstTotalAmount = 0;
        $packing_charges = 0;
        $packing_charges_gst_amount = 0;
        $labour_charges = 0;
        $labour_charges_gst_amount = 0;
        $processing_charges = 0;
        $processing_charges_gst_amount = 0;
        $payment_gateway_charges = 0;
        $payment_gateway_charges_gst_amount = 0;
        $other_charges_gst = 0;
        $labour_gst = 0;
        $produc_gst = 0;
        $total_gst_amount = 0;
       
        if($order_items->isNotEmpty()){
            $packing_charges = $order_items->sum('packing_charges');
            $packing_charges_gst_amount = $packing_charges / (1 + ($order_items->avg('packaging_gst_percent')/100));
            $labour_charges = $order_items->sum('labour_charges');
            $labour_charges_gst_amount = $labour_charges / (1 + ($order_items->avg('labour_gst_percent')/100));
            $processing_charges = $order_items->sum('processing_charges');
            $processing_charges_gst_amount = $processing_charges / (1 + ($order_items->avg('processing_gst_percent')/100));
            $payment_gateway_charges = $order_items->sum('payment_gateway_charges');
            $payment_gateway_charges_gst_amount = $payment_gateway_charges / (1 + ($order_items->avg('payment_gateway_gst_percent')/100));
            $other_charges = $packing_charges_gst_amount + $labour_charges_gst_amount + $processing_charges_gst_amount + $payment_gateway_charges_gst_amount;
            $other_charges_gst = $packing_charges + $labour_charges + $processing_charges + $payment_gateway_charges;
            $labour_gst = ($order_items->avg('packaging_gst_percent') + $order_items->avg('labour_gst_percent') + $order_items->avg('processing_gst_percent') + $order_items->avg('payment_gateway_gst_percent'))/4;
            $total_gst_amount = ($other_charges_gst - $other_charges);
        }
        @endphp
          @foreach($order_items as $orderItem)
            @php
            $produc_gst += $orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst;
            $shipping_charges += $orderItem->shipping_charges;
            $shipping_gst_percent = $orderItem->shipping_gst_percent;
            $shiping_gst_amount = ($shipping_charges * $shipping_gst_percent / 100);
            $shipping_cost = $shipping_charges + $shiping_gst_amount;
            @endphp
            <tr>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;width: 250px;">
               {{$orderItem->product->title}}
              </td>
             
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;">
                {{$orderItem->product->product->hsn}}
              </td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10">
                {{$orderItem->total_price_exc_gst}}
            </td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;">{{$orderItem->quantity}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10"> {{ $discount }}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;">{{$orderItem->gst_percentage}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10"> {{number_format(($orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst),2)}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10"> {{number_format($orderItem->total_price_inc_gst,2)}}</td>
            </tr>
            @endforeach
            <tr>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;width: 250px;">
                Shipping
              </td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;">{{$shippingChargesHsn}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10">  {{$shipping_charges}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10"> {{ $discount }}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"> {{number_format($shipping_gst_percent, 2)}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10">  {{number_format($shiping_gst_amount, 2)}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10"> {{$shipping_cost}}</td>
            </tr>
            <tr>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;width: 250px;">
                Packing & Other charges <br>(HSN: {{$packingChargesHsn}})
              </td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10"> {{number_format($other_charges, 2)}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10"> {{ $discount }}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;">{{number_format($labour_gst,2)}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10"> {{number_format(($other_charges_gst - $other_charges),2)}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10"> {{number_format($other_charges_gst, 2)}}</td>
            </tr>
            <tr>
              <td colspan="8" height="30"></td>
            </tr>
            <tr>
              <th style="font-size: 14px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;width: 250px;">Total</th>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10">{{number_format(($total_gst_amount+$produc_gst+$shiping_gst_amount), 2)}}</td>
              <th style="font-size: 14px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"><img src="{{$rupee}}" width="7" height="10"> {{ $total_amount }}</th>
            </tr>
            <tr>
              <td colspan="8" style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;text-align: left;border-bottom: 1px solid #ddd;">
                <strong>Amount in Words:</strong> {{convertNumberToWords($total_amount)}} only
              </td>
            </tr>
            <tr>
               
              <td colspan="8" style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 60px 2px 6px 2px;line-height: 18px;text-align: left; font-weight:bold;">
                For, {{$supplier_bussiens_name}} <br>
                <img src="{{$signature}}" width="120" height="50" style="margin:10px 0px;"><br>
                Authorized Signatory
                <div>
              
                </div>
                
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
