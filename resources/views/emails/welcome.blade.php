<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Rayzon CRM</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>

    <p>Welcome to Rayzon CRM! We are excited to have you on board and look forward to helping you manage your projects efficiently.</p>

    <p>Here are your login details to access your account:</p>
    <ul>
        <li><strong>Login Email:</strong> {{ $user->email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li> <!-- It is not secure to include the password here, consider using a temporary password link instead -->
        <li><strong>Login Link:</strong> <a href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a></li>
    </ul>

    <p>To get started, please follow these steps:</p>
    <ol>
        <li>Click on the login link above or copy and paste it into your web browser.</li>
        <li>Enter your login email and password.</li>
        <li>Once logged in, you will be able to explore and use all the features available.</li>
    </ol>

    <p>Important: For security reasons, we recommend changing your password after your first login. You can do this by navigating to your account settings.</p>

    <p>If you have any questions or need assistance, please do not hesitate to reach out to our support team.</p>

    <p>Thank you for choosing Rayzon CRM. We are committed to providing you with the best possible experience.</p>

    <p>Best regards,<br>The Rayzon CRM Team</p>
</body>
</html>
