@if($role == "supplier")
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
                <span style="font-size: 12px; color: #999;">Notification<br><?php echo date('F j, Y'); ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 20px;">
          
                <h1 style="font-size: 18px; color: #333;">Dear {{$user->name}},</h1>
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
                <p>If you have any questions or need assistance, our support team is here to help. Feel free to reach out to us at <a href="mailto:buyer.support@ekomn.com">supplier.support@ekomn.com</a></p>
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
@elseif($role == "buyer")
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
            <td style="padding: 20px;">
                <img src="logo_url_here" alt="eKomn Logo" style="display: block; margin: 0 auto;"/>
            </td>
            <td align="right" style="padding: 20px;">
                <span style="font-size: 12px; color: #999;">Notification<br>March 18, 2024</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 20px;">
                <h1 style="font-size: 18px; color: #333;">Dear {{$user->name}},</h1>
                <p>Welcome to <strong>eKomn</strong>.</p>
                <p>We are thrilled to have you as a part of our growing community of savvy business professionals. Our platform is designed to revolutionize the way you source products at wholesale rates across a wide range of categories, helping you to optimize and expand your online business effortlessly.</p>
                <h2 style="font-size: 16px; color: #333;">What We Offer:</h2>
                <ol style="padding-left: 20px;">
                    <li><strong>Extensive Product Catalog:</strong><br>
                    Explore a vast array of products across multiple categories, ensuring you find exactly what you need to meet your business requirements.</li>
                    <li><strong>Competitive Wholesale Rates:</strong><br>
                    Benefit from unbeatable wholesale prices that maximize your profit margins and give you a competitive edge in the market.</li>
                    <li><strong>Order in small or bulk quantity:</strong><br>
                    We offer various order types tailored to your needs, including:
                    <ul>
                        <li><strong>Dropship:</strong> Efficient and reliable Dropship option. Either it's product samples or testing a product with your customers, Dropship is the best strategy to start with new products</li>
                        <li><strong>Bulk Orders:</strong> Place bulk orders with confidence and buy repeatedly without going out of stock on key products</li>
                        <li><strong>Resell Program:</strong> Now, you can sell B2B as well in wholesale to other businesses and maximize your revenue</li>
                    </ul>
                    </li>
                    <li><strong>Comprehensive Services:</strong><br>
                    We offer a suite of services tailored to your needs, including:
                    <ul>
                        <li><strong>Catalog Solutions:</strong> Get product listing and enhancement done on various platforms *</li>
                        <li><strong>Product Reviews:</strong> Get professional product reviews for your products.</li>
                        <li><strong>Account Management:</strong> Get platform-specific account management services.</li>
                        <li><strong>Expert Support:</strong> Get expert help specific to your business needs</li>
                    </ul>
                    </li>
                    <li><strong>Multichannel Selling Support:</strong><br>
                    Whether you sell through your own website, marketplaces, or social media, our platform helps you reach your customers wherever they are.</li>
                    <li><strong>Market Insights and Trends:</strong><br>
                    Stay ahead of the curve with our insights and trend analyses, helping you make informed business decisions.</li>
                </ol>
                <h2 style="font-size: 16px; color: #333;">Getting Started:</h2>
                <ol style="padding-left: 20px;">
                    <li><strong>Login to Your Account:</strong> Visit <a href="{{ route('buyer.login')}}" target="_blank">login</a> and log in with your credentials.</li>
                    <li><strong>Complete Your Profile:</strong> Ensure your profile is complete to make the most of our features.</li>
                    <li><strong>Explore and Source:</strong> Start browsing our extensive catalog and place your first order.</li>
                    <li><strong>Utilize Our Services:</strong> Take advantage of the services that best suit your business needs.</li>
                </ol>
                <p>If you have any questions or need assistance, our support team is here to help. Feel free to reach out to us at <a href="mailto:seller.support@ekomn.com">seller.support@ekomn.com</a></p>
                <p>Once again, welcome to eKomn. We look forward to supporting your business growth and success!</p>
                <p style="text-align: center;">
                    <a href="{{ route('buyer.login')}}" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 5px;">Login</a>
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

@endif