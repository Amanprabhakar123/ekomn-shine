<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eKomn – Order {{ $order_number }} Payment Received. </title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f7f7f7;">
    <div style="background-color: #f5f5f5; padding: 20px;">
        <h2 style="color: #333;">Hello {{ $name }},</h2>
        <br>
        <p>A new <strong>{{ $order_type }}</strong> order is received. Please log in to your Supplier Profile and
            process the order as per timelines.</p>
        <br>
        <br>
        <p><em>This is a system generated notification. Please do not reply to this email.</em></p>
    </div>
</body>

</html>
