<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Our Community!</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      max-width: 600px;
      margin: 20px auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1 {
      color: #333333;
    }
    p {
      color: #666666;
    }
    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: #ffffff;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>
<div class="container">
    <h1>Welcome to Buyer</h1>
    <p>Dear {{auth()->user()->name}},</p>
    <p>We're thrilled to have you join us! Here at [Your Company/Community Name], we're dedicated to [briefly mention your mission or purpose].</p>
    <p>Feel free to explore our website and get involved in our community discussions. If you have any questions or need assistance, don't hesitate to reach out to us.</p>
    <p>Once again, welcome aboard!</p>
    <p>Sincerely,</p>
    <p>[Your Name or Company/Community Name]</p>
    <a href="{{ env('APP_URL') }}" class="button">Visit Our Website</a>
</div>
  </div>
</body>
</html>
