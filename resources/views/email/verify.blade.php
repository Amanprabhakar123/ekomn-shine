
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <h1>Email Verification</h1>

    <p>
        Thank you for registering. Please click the following link to verify your email address:
        <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
    </p>

    <p>
        If you did not create an account, you can safely ignore this email.
    </p>
</body>
</html>