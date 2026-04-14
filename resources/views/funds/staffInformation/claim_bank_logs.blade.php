@extends('layouts.layout')
@section('pageTitle')
    Claim Bank Audit Logs
@endsection
@section('content')
    <div class="box box-default">
        <div class="box-body">
            <div class="box-body">
                <div>
                    <h4 class="text-success text-uppercase">
                        Search Claim Bank Audit Logs
                    </h4>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12"><!--1st col-->
                            <form method="GET" action="{{ route('claim-bank-audit-logs') }}" class="row g-3 mb-4">
                                <div class="col-md-6 form-group">
                                    <label>User</label>
                                    <select name="tblper_id" class="form-control select2">
                                        <option value="">All</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->ID }}"
                                                {{ request('tblper_id') == $user->ID ? 'selected' : '' }}>
                                                {{ $user->surname }} {{ $user->first_name }} {{ $user->othernames }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Bank</label>
                                    <select name="bank_id" class="form-control select2">
                                        <option value="">All</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->bankID }}"
                                                {{ request('bank_id') == $bank->bankID ? 'selected' : '' }}>
                                                {{ $bank->bank }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Account No</label>
                                    <input type="text" name="account_no" class="form-control"
                                        value="{{ request('account_no') }}">
                                </div>


                                <div class="col-md-3 form-group">
                                    <label>Sort Code</label>
                                    <input type="text" name="sort_code" class="form-control"
                                        value="{{ request('sort_code') }}">
                                </div>


                                <div class="col-md-3 form-group">
                                    <label>Date From</label>
                                    <input type="date" name="date_from" class="form-control"
                                        value="{{ request('date_from') }}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Date To</label>
                                    <input type="date" name="date_to" class="form-control"
                                        value="{{ request('date_to') }}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>&nbsp;</label>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary form-control">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('claim-bank-audit-logs') }}"
                                                class="btn btn-danger form-control">
                                                Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="box box-default">
        <div class="box-body">
            <div class="box-body">
                <div>
                    <h4 class="text-success text-uppercase">
                        Claim Bank Audit Logs
                    </h4>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12"><!--1st col-->

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Staff</th>
                                            <th>File No</th>
                                            <th>Old <br> Bank</th>
                                            <th>New <br> Bank</th>
                                            <th>Old <br> Account </th>
                                            <th>New <br> Account </th>
                                            <th>Old <br> Sort Code</th>
                                            <th>New <br> Sort Code</th>
                                            <th>Updated By</th>
                                            <th>Changed At</th>
                                            <th>IP Address</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($logs as $key => $log)
                                            <tr>
                                                <td>{{ $logs->firstItem() + $key }}</td>
                                                <td>
                                                    {{ $log->surname }} {{ $log->first_name }} {{ $log->othernames }}
                                                </td>
                                                <td>
                                                    <span class="label label-{{ $log->fileNo ? 'success' : 'primary' }}">
                                                        {{ $log->fileNo }}
                                                    </span>
                                                </td>
                                                <td>{{ $log->old_bank_name }}</td>
                                                <td>{{ $log->new_bank_name }}</td>
                                                <td>{{ $log->old_claimAccountNo }}</td>
                                                <td>{{ $log->new_claimAccountNo }}</td>
                                                <td>{{ $log->old_claimBankSortCode }}</td>
                                                <td>{{ $log->new_claimBankSortCode }}</td>
                                                <td>{{ $log->updated_by_name ?? 'N/A' }}</td>
                                                <td>{{ $log->changed_at }}</td>
                                                <td>{{ $log->ip_address }}</td>
                                                <td>{{ $log->remarks }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center">No audit logs found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div>
                                {{ $logs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0-beta.10/dist/select2-bootstrap.min.css"
        rel="stylesheet" />

    <style>
        .select2-container--bootstrap .select2-selection {
            height: 34px !important;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .select2-container--bootstrap .select2-selection--single .select2-selection__rendered {
            color: #555;
            line-height: 22px !important;
        }

        .select2-container--bootstrap .select2-selection--single .select2-selection__arrow {
            height: 34px !important;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0-beta.10/dist/select2-bootstrap.min.css"
        rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap',
                placeholder: 'All',
                allowClear: true,
                width: '100%'
            });

            // Focus search input when dropdown opens
            $('.select2').on('select2:open', function() {
                setTimeout(function() {
                    document.querySelector('.select2-container--open .select2-search__field')
                        .focus();
                }, 0);
            });
        });
    </script>
@endsection
