<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty Certificate OTP - Rayzon Solar</title>
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
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff
        }

        .logo-icon {
            margin-right: 10px;
            font-size: 32px;
        }

        .tagline {
            font-size: 16px;
            opacity: 0.9;
            margin-top: 5px;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .otp-container {
            background-color: var(--light-bg);
            border-left: 4px solid var(--primary-color);
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }

        .otp-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            text-align: center;
            color: var(--primary-color);
            padding: 10px;
            background: white;
            border-radius: 6px;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
        }

        .expiry-notice {
            color: #d9534f;
            font-weight: 500;
            text-align: center;
            margin: 15px 0;
        }

        .security-notice {
            background-color: #fff9e6;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            margin: 30px 0;
            gap: 15px;
        }

        .feature {
            flex: 1;
            min-width: 150px;
            text-align: center;
            padding: 15px;
            background-color: var(--light-bg);
            border-radius: 8px;
        }

        .feature-icon {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .cta-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 8px;
            color: white;
        }

        .cta-button {
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

        .cta-button:hover {
            background-color: #e6a400;
            transform: translateY(-2px);
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
            margin: 0 10px;
            color: var(--primary-color);
            text-decoration: none;
        }

        .company-info {
            margin-top: 15px;
            line-height: 1.8;
        }

        @media (max-width: 600px) {
            .content {
                padding: 20px;
            }

            .features {
                flex-direction: column;
            }

            .otp-code {
                font-size: 26px;
                letter-spacing: 6px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="header">
            <div class="logo">
                {{-- <span class="logo-icon">☀️</span> --}}
                RAYZON SOLAR WARRANTY PORTAL
            </div>
            <div class="tagline">Harnessing the Power of the Sun for a Sustainable Future</div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">Hello Valued Customer,</div>

            <p>Thank you for using the Rayzon Solar Warranty Portal. To complete your warranty certificate verification,
                please use the One-Time Password (OTP) below:</p>

            <div class="otp-container">
                <p style="text-align: center; margin: 0; font-weight: 500;">Your Verification Code</p>
                <div class="otp-code">{{ $code }}</div>
                <p class="expiry-notice">This code will expire in 10 minutes</p>
            </div>

            <div class="security-notice">
                <strong>Security Notice:</strong> For your protection, please do not share this OTP with anyone. Rayzon
                Solar representatives will never ask for your OTP.
            </div>

            <h3 style="color: var(--primary-color); text-align: center;">Why Choose Rayzon Solar?</h3>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">🔋</div>
                    <div>25-Year Performance Warranty</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">🌍</div>
                    <div>Eco-Friendly Solutions</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">💰</div>
                    <div>Significant Energy Savings</div>
                </div>
            </div>

            <div class="cta-section">
                <h3 style="margin-top: 0; color: white;">Explore Our Solar Solutions</h3>
                <p>Discover how our advanced solar technology can power your home or business while reducing your carbon
                    footprint.</p>
                <a href="https://rayzonsolar.com/" target="_blank" class="cta-button">Visit Our Website</a>
            </div>

            <p>If you did not request this OTP, please ignore this email or contact our support team immediately.</p>

            <p>Best regards,<br>
                <strong>The Rayzon Solar Team</strong>
            </p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <div class="social-links">
                <a href="https://rayzonsolar.com/" target="_blank" class="social-link">Website</a> |
                <a href="https://www.facebook.com/RayzonSolar/" target="_blank" class="social-link">Facebook</a> |
                <a href="https://x.com/rayzonsolar" target="_blank" class="social-link">Twitter</a> |
                <a href="https://www.linkedin.com/company/rayzonsolar" target="_blank" class="social-link">LinkedIn</a>
            </div>

            <div class="company-info">
                <strong>Rayzon Solar Limited</strong><br>
                1104 to 1117, 11th Floor, Millennium Business Hub-1, <br>
                Opp. Sarthana Nature Park, Surat - 395006, Gujarat - India.<br>
                Phone: +91 96380 00461 | Email: contact@rayzonenergies.com
            </div>

            <p style="margin-top: 20px; font-size: 12px;">
                You're receiving this email because you requested a warranty certificate OTP from Rayzon Solar.<br>
                © 2025 Rayzon Solar Limited. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>
