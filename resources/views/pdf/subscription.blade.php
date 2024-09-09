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
              <h3 style="font-size: 14px; color: #131A22; font-family: 'Open Sans', sans-serif;margin: 0px 0px 2px 0px">{{ $ekomn }}</h3>
              <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;margin: 0; line-height: 18px;">
              <!-- {{ $ekomn }} <br> -->
                {{ $ekomn_address }} {{$ekomn_pincode}}<br>
                {{ $ekomn_gst }}
              </p>
            </td>
            <td style="width: 50%; vertical-align: top;  text-align: right;">
                @if($date->payment_status == 'success')
            <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif; margin: 0; text-align: right;">
                <strong style="vertical-align: middle;">Invoice Date:</strong>
                <span style="display: inline-block; vertical-align: middle;margin-top:4px;">{{$date->created_at->format('Y-m-d')}}</span>
            </p>
            @endif
              <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;margin: 0px 0px 4px 0px; text-align: right;">
                <strong style="vertical-align: middle;">Invoice No:</strong><span style="display: inline-block;font-size: 12px; vertical-align: middle;margin-top:4px;">{{ $receipt_id }}</span>
              </p>
              
            </td>
          </tr>
          <tr><td height="20"></td><td height="20"></td></tr>
          <tr>
            {{--<td style="width: 50%; vertical-align: top;">
              <h3 style="font-size: 14px; color: #131A22; font-family: 'Open Sans', sans-serif;margin: 0px 0px 2px 0px">Billing Address</h3>
              <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;margin: 0; line-height: 18px;">
              {{ 'full_name' }}<br>
              {{ 'billing_address' }}<br>
              {{ 'mobile_number' }}
              </p>
            </td>--}}
            <td style="width: 50%; vertical-align: top;text-align:">
              <h3 style="font-size: 14px; color: #131A22; font-family: 'Open Sans', sans-serif;margin: 0px 0px 2px 0px">Sold By</h3>
              <p style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;margin: 0; line-height: 18px;">
                {{$first_name}} {{$first_name}}<br>
                {{$city}} {{$pincode}}<br>
                GST No: {{$gst_no}}
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
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 2px;border-bottom: 1px solid #131A22;text-align: left;">Plan Name </th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: left;">HSN</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: center;white-space: nowrap;">Plan Price</th>
             
              
              <!-- <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: center;">Start Date </th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: center;white-space: nowrap;">End Date</th> -->
              

              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: center;">Qty.</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: center;white-space: nowrap;">GST%</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 8px;border-bottom: 1px solid #131A22;text-align: center;white-space: nowrap;">Tax Amt</th>
              <th style="font-size: 13px; color: #131A22; font-family: 'Open Sans', sans-serif;padding: 3px 2px;border-bottom: 1px solid #131A22;text-align: center;white-space: nowrap;">Total Amt</th>
            </tr>
          </thead>
          
          <tbody>
            @php
            $gstAmount = $amount_with_gst - $price;
            @endphp
            <tr>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;">
               {{$plane_name}}
              </td>

              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;">
               {{$hsn}}
              </td>
             
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;"><img src="{{$rupee}}" width="7" height="10">
                {{$price}}
            </td>
              <!-- <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;"><img src="{{$rupee}}" width="7" height="10"> {{ $subscription_start_date}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;">{{$subscription_end_date}}</td> -->
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;">1</td>

              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;">{{$gst}}</td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;">{{$gstAmount}}</td>
              
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;">{{$amount_with_gst}}</td>
            </tr>
            <tr>
              <td colspan="9" height="30"></td>
            </tr>
            <tr>
              <th style="font-size: 14px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;">Total</th>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: left;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"></td>
              <!-- <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"></td> -->
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: right;"></td>
              <td style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 8px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;"><img src="{{$rupee}}" width="7" height="10">{{$gstAmount}}</td>
              <th style="font-size: 14px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;border-bottom: 1px solid #ddd;text-align: center;"><img src="{{$rupee}}" width="7" height="10"> {{$amount_with_gst }}</th>
            </tr>
            <tr>
              <td colspan="9" style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 6px 2px;line-height: 16px;text-align: left;border-bottom: 1px solid #ddd;">
                <strong>Amount in Words:</strong> {{convertNumberToWords($amount_with_gst)}} only
              </td>
            </tr>
            <tr>
               
            {{--<td colspan="9" style="font-size: 13px; color: #424242; font-family: 'Open Sans', sans-serif;padding: 60px 2px 6px 2px;line-height: 18px;text-align: left; font-weight:bold;">
            For, {{'supplier_bussiens_name'}} <br>
            <img src="" width="120" height="50" style="margin:10px 0px;"><br>
            Authorized Signatory
            <div>
            
            </div>
            
            </td>--}}
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
