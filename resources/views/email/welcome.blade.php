<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to eKomn</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="border: 1px solid #ddd;">
        <tr>
            @include('auth.layout.logo')
            <td align="right" style="padding: 20px;">
                <span style="font-size: 12px; color: #999;">Notification<br>March 18, 2024</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 20px;">
            @if($role == "buyer")
                <h1 style="font-size: 18px; color: #333;">Dear {{auth()->user()->name}},</h1>
            @elseif($role == "supplier")
                <h1 style="font-size: 18px; color: #333;">Dear {{auth()->user()->name}},</h1>
            @endif
                <p>Welcome to <strong>eKomn</strong>.</p>
                <p>We are thrilled to have you as a part of our growing community of savvy business professionals. Our platform is designed to revolutionize the way you sell products at wholesale rates across a wide range of categories, helping you to optimize and expand your sales channels effortlessly.</p>
                <h2 style="font-size: 16px; color: #333;">What We Offer:</h2>
                <ol style="padding-left: 20px;">
                    <li><strong>Reach to more than 20000 Online sellers in India:</strong><br>
                    Now, reach out to more than 20000 active online sellers who are constantly looking for products in various categories. eKomn is exponentially growing and becoming a key sales channel for Wholesalers, Manufacturers, Bulk distributor/Traders across various product categories in India.</li>
                    <li><strong>Verified business buyers who love to buy at speed:</strong><br>
                    Maintain a healthy product catalog with rich content, Keep product prices competitive, ensure good product quality and keep your stock status updated.</li>
                    <li><strong>Market Insights and Trends:</strong><br>
                    Stay ahead of the curve with our insights and trend analyses, helping you make informed business decisions.</li>
                </ol>
                <h2 style="font-size: 16px; color: #333;">Getting Started:</h2>
                <ol style="padding-left: 20px;">
                    <li><strong>Login to Your Account:</strong> Visit <a href="{{ route('supplier.login')}}" target="_blank">Login</a> and log in with your credentials.</li>
                    <li><strong>Complete Your Profile:</strong> Ensure your profile is complete to make the most of our features.</li>
                    <li><strong>Upload your products:</strong> Start uploading product catalog and maintain stock.</li>
                    <li><strong>Dispatch Orders:</strong> Keep a check on incoming orders and process orders same day.</li>
                </ol>
                <p>If you have any questions or need assistance, our support team is here to help. Feel free to reach out to us at <a href="mailto:supplier.support@ekomn.com">supplier.support@ekomn.com</a></p>
                <p>Once again, welcome to eKomn. We look forward to supporting your business growth and success!</p>
                <p style="text-align: center;">
                    <a href="{{ route('supplier.login')}}" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 5px;">Login</a>
                </p>
                <p style="font-size: 12px; color: #999; text-align: center;">© 2024 eKomn India Private Limited. All Rights Reserved.</p>
                <p style="font-size: 12px; color: #999; text-align: center;">
                    <a href="unsubscribe_url_here" style="color: #007BFF; text-decoration: none;">Unsubscribe</a> | <a href="support_url_here" style="color: #007BFF; text-decoration: none;">Get Support</a>
                </p>
                <p style="font-size: 12px; color: #999; text-align: center;">Add eKomn to your email contacts to ensure all our content goes straight to your inbox.</p>
            </td>
        </tr>
    </table>
</body>
</html>