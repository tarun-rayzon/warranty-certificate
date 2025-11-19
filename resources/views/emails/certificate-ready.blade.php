<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty Certificate Ready - Rayzon Solar</title>
</head>

<body>
    <table class="body-wrap"
        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
        <tbody>
            <tr>
                <td></td>

                <td class="container" width="600"
                    style="display: block !important; max-width: 600px !important; margin: 0 auto;">
                    <div class="content" style="max-width: 600px; display: block; margin: 0 auto; padding: 20px;">

                        <table class="main" width="100%" cellpadding="0" cellspacing="0"
                            style="border-radius: 7px; margin: 0; border: none;">
                            <tbody>
                                <tr>
                                    <td class="content-wrap"
                                        style="background-color: #fff; padding: 30px; border-radius: 7px; box-shadow: 0 3px 15px rgba(30,32,37,.06); color: #495057;">

                                        <!-- Logo -->
                                        <table width="100%">
                                            <tr>
                                                <td style="padding-bottom: 20px;">
                                                    <img src="https://rayzonsolar.com/img/header-logo.png"
                                                        alt="Rayzon Solar" height="28">
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Greeting -->
                                        <table width="100%">
                                            <tr>
                                                <td style="font-size: 20px; font-weight: 500; padding-bottom: 10px;">
                                                    Hi {{ $customer->name }},
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Message -->
                                        <table width="100%">
                                            <tr>
                                                <td
                                                    style="color: #878a99; font-size: 15px; line-height: 1.6; padding-bottom: 15px;">
                                                    Your <strong>Rayzon Solar Warranty Certificate</strong> has been
                                                    successfully generated.
                                                    A copy of your certificate is attached with this email.
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Certificate Box -->
                                        <table width="100%"
                                            style="background: #f5f7f9; border-radius: 6px; margin: 15px 0; padding: 15px;">
                                            <tr>
                                                <td
                                                    style="font-size: 13px; text-transform: uppercase; color: #6c757d; letter-spacing: 0.5px; padding-bottom: 5px;">
                                                    Certificate Number
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="font-size: 20px; font-weight: 600; color: #0a7c8c;">
                                                    {{ $certificateNo }}
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Info -->
                                        <table width="100%">
                                            <tr>
                                                <td
                                                    style="color: #878a99; font-size: 14px; line-height: 1.6; padding-bottom: 18px;">
                                                    • Please download and store the attached certificate safely.<br>
                                                    • Keep it handy for future service or warranty-related queries.<br>
                                                    • If any details or serial numbers appear incorrect, kindly reach
                                                    out to our support team.
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Note -->
                                        <table width="100%"
                                            style="background: #fff9e6; border: 1px solid #ffe9b3; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                                            <tr>
                                                <td style="color: #856404; font-size: 13px; line-height: 1.5;">
                                                    <strong>Note:</strong> This is an automated confirmation email from
                                                    the Rayzon Solar Warranty Portal.
                                                    If you did not request this certificate, please contact our support
                                                    team immediately.
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Signoff -->
                                        <table width="100%">
                                            <tr>
                                                <td style="font-size: 14px; color: #495057; line-height: 1.6;">
                                                    Warm regards,<br>
                                                    <strong>Rayzon Solar Team</strong>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Footer -->
                        <div style="text-align: center; margin: 25px auto 0;">
                            <ul
                                style="list-style: none; display: flex; justify-content: space-evenly; padding-left: 0; margin-bottom: 18px;">
                                <li><a href="https://rayzonsolar.com" style="color: #495057;">Website</a></li>
                                <li><a href="mailto:contact@rayzonenergies.com" style="color: #495057;">Support</a></li>
                                <li><a href="https://www.linkedin.com/company/rayzonsolar"
                                        style="color: #495057;">LinkedIn</a></li>
                            </ul>

                            <p style="font-size: 13px; color: #98a6ad; margin: 0;">
                                © {{ date('Y') }} Rayzon Solar Limited. All rights reserved.
                            </p>
                        </div>

                    </div>
                </td>

                <td></td>
            </tr>
        </tbody>
    </table>

</body>

</html>
