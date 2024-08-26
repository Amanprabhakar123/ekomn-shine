
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eKomn – New Return &lt;{{$return_number}}&gt; is created</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f7f7f7;">
    <div style="background-color: #f5f5f5; padding: 20px;">
    <p>Notification <?php echo date('F j, Y'); ?></p>
        <h2 style="color: #333;">Hello {{ $name }},</h2>
        <br>
        <p>A new Return request has been declined. Please login to <a href="{{route('buyer.login')}}">eKomn</a> and take action.</p>

        <p><em>This is a system generated notification. Please do not reply to this email.</em></p>
        <br>
    </div>
</body>

</html>