@extends('layouts.loginlayout')
@section('pageTitle')
    File Number Search
@endsection
@section('content')
    <div class="container">
        <div class="form-container">
            <h2 class="form-header">Enter Your File Number</h2>
            
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
            
            @if (session('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Success!</strong>
                    {{ session('message') }}
                </div>
            @endif
            
            <div class="info-box">
                <p class="mb-0"><strong>Note:</strong> Please enter your file number to receive a verification code via email.</p>
            </div>
            
            <form method="post" action="{{ route('file.number.search.submit') }}">
                @csrf
                
                <div class="input-container"> <!-- Changed class -->
                    <label for="fileNumber" class="form-label">File Number</label>
                    <input type="text" 
                           class="form-control file-number-input" 
                           id="fileNumber" 
                           name="fileNumber" 
                           placeholder="Enter your file number"
                           value="{{ old('fileNumber') }}"
                           required
                           min="1">
                </div>
                
                <div class="button-container"> <!-- Changed class -->
                    <button type="submit" class="btn btn-primary submit-btn">Search & Send OTP</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto 80px auto;
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
            font-size: 18px;
            padding: 12px 15px;
            height: auto;
        }
        .submit-btn {
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        /* Custom spacing between input and button */
        .input-container {
            margin-bottom: 40px !important; /* Large bottom margin */
        }
        
        .button-container {
            margin-top: 20px !important; /* Additional top margin */
        }
        
        /* Additional spacing for the main container */
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
            document.getElementById('fileNumber').focus();
        });
    </script>
@endsection