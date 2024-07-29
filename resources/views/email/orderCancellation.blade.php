<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eKomn – Order Cancellation - {{ $Order_number }}</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f7f7f7;">
    <div style="background-color: #f5f5f5; padding: 20px;">
        <h2 style="color: #333;">Hello {{ $name }},</h2>
        <br>
        <p>Order ID <strong>{{ $Order_number }}</strong> is cancelled.</p>
        <br>
        <p>If already processed, kindly ignore it.</p>
        <br>
        <p><em>This is a system generated notification. Please do not reply to this email.</em></p>
    </div>
</body>

</html>
