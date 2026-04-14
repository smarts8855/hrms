@extends('layouts.loginlayout')
@section('pageTitle')
    Verify OTP
@endsection
@section('content')
    <div class="container">
        <div class="form-container">
            <h2 class="form-header">Verify OTP Code</h2>
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif
            
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Error!</strong>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <div class="info-box">
                <p class="mb-0">A 6-digit verification code has been sent to your registered email address. Please enter it below to continue.</p>
                <p class="mb-0 mt-2"><small><strong>Note:</strong> This code expires in 10 minutes.</small></p>
            </div>
            
            <form method="post" action="{{ route('file.number.verify.otp') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="otp" class="form-label">6-Digit OTP Code</label>
                    <input type="text" 
                           class="form-control file-number-input text-center" 
                           id="otp" 
                           name="otp" 
                           placeholder="Enter 6-digit code"
                           maxlength="6"
                           pattern="[0-9]{6}"
                           required
                           inputmode="numeric">
                    <div class="form-text">Enter the 6-digit code sent to your email.</div>
                </div>
                
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-success submit-btn">Verify OTP</button>
                </div>

                <div class="text-center">
                    <p class="text-muted">Didn't receive the code?</p>
                    <form method="post" action="{{ route('file.number.resend.otp') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm">Resend OTP</button>
                    </form>
                    <a href="{{ route('file.number.search') }}" class="btn btn-outline-secondary btn-sm">Back to Search</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto 80px auto; /* Added bottom margin: 80px */
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .file-number-input {
            font-size: 20px;
            padding: 12px 15px;
            height: auto;
            letter-spacing: 8px;
            font-weight: bold;
        }
        .submit-btn {
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        /* Additional container spacing */
        .container {
            margin-bottom: 40px;
        }

        footer {
            position: static !important;
            margin-top: 50px;
        }

        .footer {
            position: static !important;
            margin-top: 50px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('otp').focus();
            
            // Auto-submit when 6 digits are entered
            document.getElementById('otp').addEventListener('input', function(e) {
                if (this.value.length === 6) {
                    this.form.submit();
                }
            });
        });
    </script>
@endsection