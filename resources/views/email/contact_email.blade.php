<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your eKomn.com password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f7f7f7;">
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="border: 1px solid #ddd; background-color: #fff; margin-top: 20px;">
        <tr>
            <td style="padding: 20px;">
                @include('auth.layout.logo')
            </td>
            <td align="right" style="padding: 20px;">
                <span style="font-size: 12px; color: #999;">Notification<br><?php echo date('F j, Y'); ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 20px;">
                <h1 style="font-size: 18px; color: #333;">Hi {{$data['first_name']}},</h1>
                <p>Thank you for contacting us. We have received your query and will get back to you as soon as possible.</p>
                <p>In the meantime, if you have any urgent concerns, please feel free to reach out to us at the contact details provided below:</p>
                <p>Email: info@ekomn.com</p>
                <p>Phone: +91 9810164845</p>
                <p>Thank you again for reaching out to us. We appreciate your interest in our company.</p>
                <p>Best regards,</p>
                <p>The eKomn Team</p>
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
