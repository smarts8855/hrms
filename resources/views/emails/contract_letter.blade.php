{{-- resources/views/emails/contract_letter.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($letterType) }} Letter - {{ $contractName }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #00a65a;
            color: white;
            padding: 30px 20px;
            text-align: center;
            /* border-radius: 10px 10px 0 0; */
        }
        .logo {
            margin-bottom: 15px;
        }
        .logo img {
            max-width: 80px;
            height: auto;
            background: white;
            /* border-radius: 50%; */
            padding: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .header h1 {
            margin: 10px 0 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            background: white;
            padding: 30px;
        }
        .contract-details {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .contract-details h3 {
            margin-top: 0;
            color: #00a65a;
            border-bottom: 2px solid #00a65a;
            padding-bottom: 10px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }
        .detail-label {
            font-weight: bold;
            width: 40%;
            color: #555;
        }
        .detail-value {
            width: 60%;
            color: #333;
        }
        .amount {
            font-size: 20px;
            font-weight: bold;
            color: #00a65a;
        }
        .attachment-section {
            background: #e8f4fd;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #2196F3;
            text-align: center;
        }
        .attachment-icon {
            font-size: 48px;
            color: #2196F3;
            margin-bottom: 15px;
        }
        .attachment-title {
            font-size: 18px;
            font-weight: bold;
            color: #2196F3;
            margin-bottom: 10px;
        }
        .file-name {
            background: #fff;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 14px;
            word-break: break-all;
            border: 1px solid #ddd;
        }
        .button-container {
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: transform 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-download {
            background: #00a65a;
            color: white;
        }
        .btn-download:hover {
            background: #008d4c;
        }
        .btn-view {
            background: #007bff;
            color: white;
        }
        .btn-view:hover {
            background: #0069d9;
        }
        .attachment-info {
            font-size: 14px;
            color: #666;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #444;
        }
        .message {
            margin-bottom: 30px;
        }
        .signature {
            margin-top: 30px;
            font-style: italic;
            color: #888;
        }
        .alert {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .footer {
            background-color: #00a65a;
            color: white;
            padding: 25px 20px;
            text-align: center;
            /* border-radius: 0 0 10px 10px; */
            font-size: 14px;
        }
        .footer p {
            margin: 5px 0;
            color: white;
        }
        .footer a {
            color: #fff;
            text-decoration: underline;
        }
        .footer a:hover {
            text-decoration: none;
            color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ ucfirst($letterType) }} Letter</h1>
            <p>Contract: {{ $contractName }}</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Dear <strong>{{ $contractorName }}</strong>,
            </div>
            
            <div class="message">
                @if($letterType == 'recommendation')
                    <p>We are pleased to inform you that your company has been recommended for the contract below. Please find attached the <strong>Recommendation Letter</strong> for your review.</p>
                @else
                    <p>Congratulations! We are pleased to inform you that your company has been awarded the contract below. Please find attached the <strong>Award Letter</strong> for your records.</p>
                @endif
            </div>
            
            <div class="contract-details">
                <h3>Contract Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Contract Name:</span>
                    <span class="detail-value">{{ $contractName }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Lot Number:</span>
                    <span class="detail-value">{{ $lotNumber ?? 'N/A' }}</span>
                </div>
                @if(isset($awardedAmount) && $awardedAmount > 0)
                <div class="detail-row">
                    <span class="detail-label">Awarded Amount:</span>
                    <span class="detail-value amount">₦{{ number_format($awardedAmount, 2) }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ $date }}</span>
                </div>
            </div>
            
            <!-- ATTACHMENT SECTION WITH DOWNLOAD/VIEW BUTTONS -->
            <div class="attachment-section">
                <div class="attachment-icon">📎</div>
                <div class="attachment-title">{{ ucfirst($letterType) }} Letter</div>
                
                <div class="button-container">
                    @if(isset($letter) && $letter->letter_id)
                        <!-- Download Button with #00a65a color -->
                        <a href="{{ url('/upload-letters/download/' . $letter->letter_id) }}" 
                           class="btn btn-download" 
                           style="background: #00a65a; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 5px;">
                            📥 Download {{ ucfirst($letterType) }} Letter
                        </a>
                        
                        <!-- View Online Button -->
                        <a href="{{ url('/upload-letters/view/' . $letter->letter_id) }}" 
                           target="_blank" 
                           class="btn btn-view" 
                           style="background: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 5px;">
                            👁️ View Online
                        </a>
                    @endif
                </div>
                
                <div class="attachment-info">
                    <i class="fa fa-info-circle"></i> 
                    <small>The file is attached to this email. If you don't see the attachment, please use the buttons above.</small>
                </div>
            </div>
            
            @if($letterType == 'award')
            <div class="alert">
                <strong>Important:</strong> Please review the award letter carefully and contact the procurement department if you have any questions regarding the contract terms and conditions.
            </div>
            @endif
            
            <div class="signature">
                <p>Best Regards,</p>
                <p><strong>Procurement Department</strong><br>
                {{ config('app.name') }}</p>
            </div>
        </div>
        
        <!-- FOOTER WITH #00a65a BACKGROUND AND WHITE TEXT -->
        <div class="footer">
            <p>This is an automated message from the Procurement System. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p style="font-size: 12px; margin-top: 10px;">
                <a href="{{ url('/') }}" style="color: white; text-decoration: underline;">Visit our website</a> | 
                <a href="#" style="color: white; text-decoration: underline;">Contact Support</a>
            </p>
        </div>
    </div>
</body>
</html>