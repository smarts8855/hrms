<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #0B610B; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .otp-code { 
            font-size: 32px; 
            font-weight: bold; 
            text-align: center; 
            letter-spacing: 8px;
            color: #007bff;
            margin: 20px 0;
            padding: 15px;
            background: white;
            border: 2px dashed #007bff;
        }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
        .info-box { background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>SCN GOVERNMENT RESOURCE PLANNING - File Number Verification</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $name }},</p>
            
            <p>You have requested to verify your file number <strong>{{ $fileNumber }}</strong>. Please use the following One-Time Password (OTP) to complete your verification:</p>
            
            <div class="otp-code">{{ $otp }}</div>
            
            <div class="info-box">
                <p><strong>Important:</strong> This OTP is valid for 10 minutes only. Please do not share this code with anyone.</p>
            </div>
            
            <p>If you did not request this verification, please ignore this email or contact your system administrator.</p>
            
            <p>Best regards,<br>SCN Government Resource Planning Administrator</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} SCN Government Resource Planning. All rights reserved.</p>
        </div>
    </div>
</body>
</html>