@extends('layouts.layout')

@section('pageTitle')
    New Appointment
@endsection

@section('content')

    <div style="padding-bottom: 20px;">
        <div class="box box-default">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">
                    <b>@yield('pageTitle')</b>
                    <i class="fa fa-arrow-right"></i>
                    <span id='processing'>
                        <strong><em>Approve Newly Employed Staff Salary.</em></strong>
                    </span>
                </h3>
            </div>

            @if (session('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span> </button>
                    <strong>Successful!</strong> {{ session('message') }}
                </div>
            @endif
            @if (session('error_message'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span> </button>
                    <strong>Error!</strong> {{ session('error_message') }}
                </div>
            @endif


            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <strong>Error!</strong>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="panel-body">
                <div class="table-responsive" style="font-size: 12px; margin-top:20px;">
                    <div class="text-center" style="font-size: 20px; margin-bottom:20px;">New Employees</div>
                    <table class="table table-bordered table-striped table-highlight">
                        <thead>
                            <tr bgcolor="#c7c7c7">
                                <th width="1%">S/N</th>
                                <th>STAFF</th>
                                <th>FILENO</th>
                                <th>GRADE|STEP</th>
                                <th>DATE OF ASSUMPTION</th>
                                <th>MONTH</th>
                                <th>YEAR</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>

                        @if ($staffForHalfPayList && count($staffForHalfPayList) > 0)
                            @foreach ($staffForHalfPayList as $key => $b)
                                <tr>
                                    <td>{{ $key + 1 }} </td>
                                    <td>{{ $b->surname }} {{ $b->first_name }} {{ $b->othernames }}</td>
                                    <td>{{ $b->fileNo }}</td>
                                    <td>{{ $b->old_grade }}|{{ $b->old_step }}</td>
                                    <td>{{ $b->due_date }}</td>
                                    <td>{{ $b->month_payment }}</td>
                                    <td>{{ $b->year_payment }}</td>
                                    <td>
                                        @if ($b->approvedBy == '')
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-backdrop="false" data-target="#confirmEnable{{ $b->ID }}"><i
                                                    class="fa fa-btn fa-plus"></i>
                                                Approve</button>
                                        @else
                                            Approved
                                        @endif

                                        <!-- Modal to disable -->
                                        <div class="modal fade text-left d-print-none"
                                            id="confirmEnable{{ $b->ID }}" tabindex="-1" role="dialog"
                                            aria-labelledby="confirmToSubmit" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h4 class="modal-title text-white"><i class="ti-save"></i>
                                                            Confirm!</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="{{ route('approveNewStaffSalary') }}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="text-success text-center">
                                                                <h4>Are you sure you want to confirm the new employee
                                                                    {{ $b->surname }} {{ $b->first_name }}
                                                                    {{ $b->othernames }} for salary?
                                                                </h4>
                                                                <input type="hidden" name="staffId"
                                                                    value="{{ $b->staffid }}">
                                                                <div class="panel-body" style="margin-top: 20px;">

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Bank Name <span
                                                                                    class="text-danger"><big>*</big></span></label>
                                                                            <select required type="text" id="bankName"
                                                                                name="bankName"
                                                                                class="form-control input-lg" required>
                                                                                <option value="">Select Bank</option>
                                                                                @foreach ($BankList as $bank)
                                                                                    <option value="{{ $bank->bankID }}"
                                                                                        {{ $b->bankID == $bank->bankID ? 'selected' : '' }}>
                                                                                        {{ $bank->bank }} </option>
                                                                                @endforeach
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Account Number <span
                                                                                    class="text-danger"><big>*</big></span></label>
                                                                            <input type="number" name="accountNumber"
                                                                                class="form-control input-lg" required
                                                                                value="{{ $b->AccNo }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Bank Branch <span
                                                                                    class="text-danger"><big>*</big></span></label>
                                                                            <input type="text" name="bank_branch"
                                                                                class="form-control input-lg"
                                                                                value="{{ $b->bank_branch }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Bank Group <span
                                                                                    class="text-danger"><big>*</big></span></label>
                                                                            <input type="number" name="bankGroup"
                                                                                class="form-control input-lg"
                                                                                value="{{ $b->bankGroup }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Employment Type <span
                                                                                    class="text-danger"><big>*</big></span></label>
                                                                            <select name="employmentType"
                                                                                id="employmentType"
                                                                                class="form-control input-lg" required>
                                                                                <option value="">Select Employment
                                                                                    Type</option>

                                                                                @foreach ($employmentType as $type)
                                                                                    <option value="{{ $type->id }}"
                                                                                        {{ $b->employee_type == $type->id ? 'selected' : '' }}>
                                                                                        {{ $type->employmentType }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-info"
                                                                data-dismiss="modal">
                                                                Cancel </button>
                                                            <button type="submit" class="btn btn-primary"> Confirm
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end Modal-->
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center text-danger"> No Records found...</td>
                            </tr>
                        @endif

                    </table>
                </div>
            </div>
        </div>
    </div>




@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        function StaffSearchReload() {
            document.getElementById('fileNo').value = document.getElementById('userSearch').value;
            // alert(document.getElementById('userSearch').value);
            document.forms["mainform"].submit();
            // alert("jdjdjdeedd");
            return;
        }
    </script>

    <script type="text/javascript">
        $(function() {
            $("#dateofBirth").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#dueDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#incrementalDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@endsection
