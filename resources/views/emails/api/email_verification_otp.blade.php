<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Email Verification OTP</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #3b95b7;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 40px;
            color: #4f5d77;
            line-height: 1.6;
        }
        .content h2 {
            color: #253D4E;
            margin-top: 0;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            background-color: #3b95b7;
            color: #ffffff !important;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #298ea5;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #7e8e9f;
            border-top: 1px solid #edf2f7;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Roster</h1>
        </div>

        <div class="content">
            <h2>Hello {{ $user->first_name }},</h2>

            <p>
                Your email verification OTP is:
            </p>

            <div class="button-container">
                <div class="button" style="cursor: default; font-weight: bold; font-size: 18px;">
                    {{ $otp }}
                </div>
            </div>

            <p>
                This OTP is valid for <strong>5 minutes</strong>.
            </p>

            <p>
                If you did not request this, please ignore this email.
            </p>

            <p>Regards,<br>Roster Team</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Roster. All rights reserved.
        </div>
    </div>
</body>

</html>
