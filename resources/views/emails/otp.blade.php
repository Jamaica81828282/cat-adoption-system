<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #fce4ec 0%, #e1bee7 50%, #bbdefb 100%);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            font-size: 28px;
            margin: 0 0 10px 0;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        .otp-box {
            background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 8px;
            margin: 10px 0;
        }
        .content {
            color: #555;
            line-height: 1.6;
            font-size: 15px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #999;
            font-size: 13px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐾 Password Reset Request</h1>
            <p>Hello, {{ $userName }}! 🐱</p>
        </div>

        <div class="content">
            <p>You are receiving this email because we received a password reset request for your account.</p>
            
            <p><strong>Your One-Time Password (OTP) is:</strong></p>
        </div>

        <div class="otp-box">
            <div>🔑 Verification Code</div>
            <div class="otp-code">{{ $otp }}</div>
            <div>⏰ Valid for 10 minutes</div>
        </div>

        <div class="content">
            <p>Please enter this code on the password reset page to continue.</p>
            
            <p style="color: #e91e63;"><strong>⚠️ Important:</strong> Do not share this code with anyone!</p>
            
            <p>If you did not request a password reset, please ignore this email or contact support if you have concerns.</p>
        </div>

        <div class="footer">
            <p>Regards,<br>{{ config('app.name') }} Team 🐾</p>
            <p style="margin-top: 15px;">This is an automated message, please do not reply.</p>
        </div>
    </div>
</body>
</html>