<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty Certificate Ready - Rayzon Solar</title>
    <style>
        :root {
            --primary-color: #095763;
            --secondary-color: #0a7c8c;
            --accent-color: #f8b500;
            --light-bg: #f5f9fa;
            --text-color: #333333;
            --light-text: #6c757d;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 30px 20px;
            text-align: center;
            color: white;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .tagline {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .highlight-card {
            background-color: var(--light-bg);
            border-left: 4px solid var(--primary-color);
            padding: 18px 20px;
            margin: 20px 0;
            border-radius: 0 10px 10px 0;
        }

        .certificate-label {
            font-size: 14px;
            text-transform: uppercase;
            color: var(--light-text);
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .certificate-no {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .btn-primary {
            display: inline-block;
            background-color: var(--accent-color);
            color: #333;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            margin-top: 15px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #e6a400;
            transform: translateY(-2px);
        }

        .info-list {
            margin: 25px 0;
            padding-left: 18px;
            font-size: 14px;
            color: var(--light-text);
        }

        .info-list li {
            margin-bottom: 6px;
        }

        .note-box {
            background-color: #fff9e6;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            font-size: 13px;
            color: var(--light-text);
        }

        .footer {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: var(--light-text);
        }

        .social-links {
            margin: 15px 0;
        }

        .social-link {
            display: inline-block;
            margin: 0 8px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 13px;
        }

        .company-info {
            margin-top: 10px;
            line-height: 1.8;
        }

        @media (max-width: 600px) {
            .content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                RAYZON SOLAR WARRANTY PORTAL
            </div>
            <div class="tagline">Harnessing the Power of the Sun for a Sustainable Future</div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Hi {{ $customer->name }},</div>

            <p>
                We’re happy to inform you that your
                <strong>Rayzon Solar warranty certificate</strong> has been generated successfully.
            </p>

            <div class="highlight-card">
                <div class="certificate-label">Certificate Number</div>
                <div class="certificate-no">{{ $certificateNo }}</div>
            </div>

            <ul class="info-list">
                <li>Please keep this certificate safe for your records.</li>
                <li>You may be asked to share this certificate for future service or warranty claims.</li>
                <li>If you notice any discrepancy in your details or serial numbers, contact our support team.</li>
            </ul>

            <div class="note-box">
                <strong>Note:</strong> This email is an automated confirmation generated by the Rayzon Solar Warranty
                Portal. If you did not request a warranty certificate, please reach out to our support team immediately.
            </div>

            <p>
                Thank you for trusting <strong>Rayzon Solar</strong> to power your journey towards a sustainable future.
            </p>

            <p style="margin-top: 10px;">
                Warm regards,<br>
                <strong>The Rayzon Solar Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="social-links">
                <a href="https://rayzonsolar.com/" target="_blank" class="social-link">Website</a> |
                <a href="https://www.facebook.com/RayzonSolar/" target="_blank" class="social-link">Facebook</a> |
                <a href="https://x.com/rayzonsolar" target="_blank" class="social-link">Twitter</a> |
                <a href="https://www.linkedin.com/company/rayzonsolar" target="_blank" class="social-link">LinkedIn</a>
            </div>

            <div class="company-info">
                <strong>Rayzon Solar Limited</strong><br>
                1104 to 1117, 11th Floor, Millennium Business Hub-1,<br>
                Opp. Sarthana Nature Park, Surat - 395006, Gujarat - India.<br>
                Phone: +91 96380 00461 | Email: contact@rayzonenergies.com
            </div>

            <p style="margin-top: 18px; font-size: 12px;">
                You’re receiving this email because a warranty certificate was generated using your details on the
                Rayzon Solar Warranty Portal.<br>
                © {{ date('Y') }} Rayzon Solar Limited. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>
