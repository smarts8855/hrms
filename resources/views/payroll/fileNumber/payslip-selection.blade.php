@extends('layouts.loginlayout')

@section('pageTitle')
    Select Month & Year - Payslip
@endsection

@section('content')
<div class="container-fluid" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 30px; background: #f8f9fa;">
    <div class="card" style="width: 100%; max-width: 850px; margin: 0 auto; border: none; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
        <!-- Header -->
        <div class="card-header text-center" style="background: #fff; padding: 30px 20px 20px 20px; border-bottom: 1px solid #eaeaea; border-radius: 8px 8px 0 0;">
            <h4 style="font-weight: 500; color: #2c3e50; margin: 0; font-size: 2.2rem;">Payslip Generation</h4>
            <p style="color: #7f8c8d; margin: 10px 0 0 0; font-size: 1.5rem;">Select period for payslip</p>
        </div>

        <div class="card-body" style="padding: 35px; background: #fff;">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 0 auto 25px auto; border-radius: 6px; border: 1px solid #d4edda; background: #f8fff9; color: #155724;">
                    <div style="font-size: 1.4rem;"><strong>Success:</strong> {{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="border: none; background: none; font-size: 1.8rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('warning_message'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin: 0 auto 25px auto; border-radius: 6px; border: 1px solid #fff3cd; background: #fffef7; color: #856404;">
                    <div style="font-size: 1.4rem;"><strong>Notice:</strong> {{ session('warning_message') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="border: none; background: none; font-size: 1.8rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 0 auto 25px auto; border-radius: 6px; border: 1px solid #f8d7da; background: #fffafa; color: #721c24;">
                    <div style="font-size: 1.4rem;"><strong>Error:</strong> {{ session('error_message') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="border: none; background: none; font-size: 1.8rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Content Row -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 35px; align-items: start;">
                <!-- Staff Information -->
                <div style="background: #f8f9fa; border-radius: 6px; padding: 30px; border-left: 4px solid #0B610B;">
                    <div style="display: flex; align-items: center; margin-bottom: 20px;">
                        <i class="fas fa-user" style="color: #0B610B; margin-right: 15px; font-size: 1.6rem;"></i>
                        <h6 style="margin: 0; color: #2c3e50; font-weight: 500; font-size: 1.6rem;">Staff Information</h6>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 1.3rem; color: #7f8c8d; margin-bottom: 8px; font-weight: 500;">Name</label>
                            <div style="font-weight: 500; color: #2c3e50; font-size: 1.4rem;">{{ $user['title'] }} {{ $user['name'] }}</div>
                        </div>
                        <div>
                            <label style="display: block; font-size: 1.3rem; color: #7f8c8d; margin-bottom: 8px; font-weight: 500;">File Number</label>
                            <div style="font-weight: 500; color: #2c3e50; font-size: 1.4rem;">{{ $user['file_number'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div>
                    <form method="post" action="{{ route('payslip.generate') }}">
                        @csrf
                        
                        <!-- Month and Year Selection -->
                        <div style="margin-bottom: 30px;">
                            <div style="display: flex; flex-direction: column; gap: 22px;">
                                <!-- Month Selection -->
                                <div>
                                    <label for="month" style="display: block; font-size: 1.4rem; color: #2c3e50; margin-bottom: 12px; font-weight: 500;">
                                        SELECT MONTH
                                    </label>
                                    <select name="month" id="month" class="form-control" required 
                                        style="width: 100%; padding: 18px 20px; border: 2px solid #dcdfe6; border-radius: 6px; font-size: 1.4rem; color: #2c3e50; background: #fff; transition: all 0.2s ease; min-height: 65px;">
                                        <option value="">Choose Month</option>
                                        @php
                                            $months = [
                                                'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE',
                                                'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'
                                            ];
                                            $selectedMonth = session('old_month') ?? old('month');
                                        @endphp
                                        @foreach($months as $monthOption)
                                            <option value="{{ $monthOption }}" {{ $selectedMonth == $monthOption ? 'selected' : '' }}>
                                                {{ $monthOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Year Selection -->
                                <div>
                                    <label for="year" style="display: block; font-size: 1.4rem; color: #2c3e50; margin-bottom: 12px; font-weight: 500;">
                                        SELECT YEAR
                                    </label>
                                    <select name="year" id="year" class="form-control" required 
                                        style="width: 100%; padding: 18px 20px; border: 2px solid #dcdfe6; border-radius: 6px; font-size: 1.4rem; color: #2c3e50; background: #fff; transition: all 0.2s ease; min-height: 65px;">
                                        <option value="">Choose Year</option>
                                        @php
                                            $currentYear = date('Y');
                                            $selectedYear = session('old_year') ?? old('year') ?? $currentYear;
                                        @endphp
                                        @for($i = 2025; $i <= 2060; $i++)
                                            <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 18px;">
                            <button type="submit" 
                                style="flex: 1; background: #0B610B; color: white; border: none; padding: 20px; border-radius: 6px; font-size: 1.4rem; font-weight: 500; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center; min-height: 65px;">
                                <i class="fas fa-download" style="margin-right: 12px; font-size: 1.4rem;"></i>
                                Generate Payslip
                            </button>
                            <a href="{{ route('file.number.search') }}" 
                                style="flex: 0.5; background: #6c757d; color: white; border: none; padding: 20px; border-radius: 6px; font-size: 1.4rem; font-weight: 500; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: flex; align-items: center; justify-content: center; min-height: 65px;">
                                <i class="fas fa-arrow-left" style="margin-right: 12px; font-size: 1.4rem;"></i>
                                Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background: #f8f9fa;
        font-size: 20px;
    }
    
    .container-fluid {
        padding: 30px 20px;
    }
    
    .card {
        background: #fff;
        transition: box-shadow 0.2s ease;
    }
    
    .card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .form-control {
        border: 2px solid #dcdfe6;
        transition: all 0.2s ease;
        font-size: 1.4rem;
        padding: 18px 20px;
        border-radius: 6px;
        min-height: 65px;
    }
    
    .form-control:focus {
        border-color: #0B610B;
        box-shadow: 0 0 0 3px rgba(11, 97, 11, 0.15);
        outline: none;
        transform: translateY(-2px);
    }
    
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='%237f8c8d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 20px center;
        background-size: 24px;
        padding-right: 60px;
    }
    
    button[type="submit"] {
        background: #0B610B;
        transition: all 0.2s ease;
        font-size: 1.4rem;
        min-height: 65px;
    }
    
    button[type="submit"]:hover {
        background: #0A4D0A;
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(11, 97, 11, 0.4);
    }
    
    a[href="{{ route('file.number.search') }}"] {
        background: #6c757d;
        transition: all 0.2s ease;
        font-size: 1.4rem;
        min-height: 65px;
    }
    
    a[href="{{ route('file.number.search') }}"]:hover {
        background: #5a6268;
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
        text-decoration: none;
        color: white;
    }
    
    .alert {
        border: 1px solid;
        background: #fff;
        font-size: 1.4rem;
        padding: 20px;
    }
    
    .alert-success {
        border-color: #d4edda;
        color: #155724;
    }
    
    .alert-warning {
        border-color: #fff3cd;
        color: #856404;
    }
    
    .alert-danger {
        border-color: #f8d7da;
        color: #721c24;
    }
    
    .close {
        color: inherit;
        opacity: 0.7;
        transition: opacity 0.2s ease;
        font-size: 1.8rem;
    }
    
    .close:hover {
        opacity: 1;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        body {
            font-size: 18px;
        }
        
        .container-fluid {
            padding: 20px 15px;
        }
        
        .card-body {
            padding: 30px 25px !important;
        }
        
        .content-grid {
            grid-template-columns: 1fr !important;
            gap: 30px !important;
        }
        
        .button-group {
            flex-direction: column;
            gap: 15px !important;
        }
        
        .button-group button,
        .button-group a {
            flex: 1 !important;
            font-size: 1.3rem !important;
            padding: 18px !important;
            min-height: 60px !important;
        }
        
        select.form-control {
            font-size: 1.3rem !important;
            padding: 16px 18px !important;
            min-height: 60px !important;
        }
        
        .card-header h4 {
            font-size: 1.8rem !important;
        }
        
        .card-header p {
            font-size: 1.4rem !important;
        }
        
        .staff-info h6 {
            font-size: 1.4rem !important;
        }
        
        .staff-info label {
            font-size: 1.2rem !important;
        }
        
        .staff-info div {
            font-size: 1.3rem !important;
        }
    }

    @media (max-width: 480px) {
        body {
            font-size: 16px;
        }
        
        .card-body {
            padding: 25px 20px !important;
        }
        
        .staff-info div {
            font-size: 1.2rem !important;
        }
        
        button, a {
            font-size: 1.2rem !important;
            padding: 16px !important;
            min-height: 55px !important;
        }
        
        select.form-control {
            font-size: 1.2rem !important;
            padding: 14px 16px !important;
            min-height: 55px !important;
        }
        
        .form-label {
            font-size: 1.2rem !important;
        }
    }
</style>
@endsection