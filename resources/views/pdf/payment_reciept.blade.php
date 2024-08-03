<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        .invoice-details,
        .order-details,
        .addresses {
            margin-bottom: 20px;
        }

        .details-title {
            font-weight: bold;
        }

        .address {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>Payment Reciept</h1>

    <div class="invoice-details">
        <div><span class="details-title">Recipet Number:</span> {{ $invoice_number }}</div>
        <div><span class="details-title">Total Amount:</span> {{ $total_amount }}</div>
    </div>

    <div class="order-details">
        <div><span class="details-title">Order Number:</span> {{ $order_number }}</div>
        <div><span class="details-title">Full Name:</span> {{ $full_name }}</div>
        <div><span class="details-title">Email:</span> {{ $email }}</div>
        <div><span class="details-title">Mobile Number:</span> {{ $mobile_number }}</div>
        <div><span class="details-title">Store Order:</span> {{ $store_order }}</div>
        <div><span class="details-title">Status:</span> {{ $status }}</div>
    </div>

    <div class="addresses">
        <div class="address">
            <div class="details-title">Shipping Address:</div>
            <div>{{ $shipping_address }}</div>
        </div>
        <div class="address">
            <div class="details-title">Billing Address:</div>
            <div>{{ $billing_address }}</div>
        </div>
        <div class="address">
            <div class="details-title">Pickup Address:</div>
            <div>{{ $pickup_address }}</div>
        </div>
    </div>
</body>

</html>
