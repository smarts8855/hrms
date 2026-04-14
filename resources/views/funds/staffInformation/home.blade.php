@extends('layouts.layout')
@section('pageTitle')
    STAFF INFORMATION
@endsection
@section('content')

    <div class="box-body hidden-print ">
        <div class="box box-default">
            <div>
                <div class="box-body">
                    <div>
                        <h5> @yield('pageTitle') </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-body">
            <div class="box-body">
                <div>
                    <h4 class="text-success">Enter Staff Details </h4>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-body">
                    {{-- <div class="col-sm-12">
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

                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                                </button>
                                <strong>Success!</strong>
                                {{ session('message') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                                </button>
                                <strong>Input Error !</strong>
                                {{ session('error') }}
                            </div>
                        @endif
                    </div> --}}
                    <div class="row">
                        <div class="col-md-12"><!--1st col-->
                            @include('funds.Share.message')
                            <form method="post" action="{{ route('processStaffInfo') }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="file">Staff File No.</label>
                                            <input type="text" name="staffFileNo" class="form-control"
                                                value="{{ old('staffFileNo') }}" placeholder ="Staff ID(Optional)" />
                                        </div><br />
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name">Surname <i class="text-danger">*</i></label>
                                            <input type="text" name="surname" class="form-control"
                                                value="{{ old('surname') }}" placeholder ="Enter surname" required />
                                        </div><br />
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name">Firstname <i class="text-danger">*</i> </label>
                                            <input type="text" name="firstname" class="form-control"
                                                value="{{ old('firstname') }}" placeholder ="Enter firstname" required />
                                        </div><br />
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name">Middle Name</label>
                                            <input type="text" name="othernames" class="form-control"
                                                value="{{ old('othernames') }}" placeholder ="Enter othernames" />
                                        </div><br />
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="account">Account Number <i class="text-danger">*</i></label>
                                            <input type="text" name="accountNumber" size="11" class="form-control"
                                                value="{{ old('accountNumber') }}" placeholder ="Account Number"
                                                id="account_number" />
                                        </div><br />
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bank">Bank Name <i class="text-danger">*</i></label>
                                            <select name="bankName" class="form-control" id="bank_id">
                                                <option value="" selected>Select</option>
                                                @forelse($bank as $bkList)
                                                    <option value="{{ $bkList->bankID }}"
                                                        data-code="{{ $bkList->sortcode }}"
                                                        {{ old('bankName') == $bkList->bankID ? 'selected' : '' }}>
                                                        {{ $bkList->bank }}</option>
                                                @empty
                                                    <option value="" selected>No Bank Available</option>
                                                @endforelse
                                            </select>
                                        </div><br />
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sort">Sort Code</label>
                                            <input type="text" name="sortCode" class="form-control"
                                                value="{{ old('sortCode') }}" placeholder ="Optional-Sort Code" />
                                        </div><br />
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">&nbsp;</label>
                                            <button type="submit" name="processSubmit"
                                                class="btn btn-success w-100 form-control">Submit</button>
                                        </div>
                                    </div>
                                </div><!--//row-->
                                {{-- <div align="center" class="col-md-12">
                                    <button type="submit" name="processSubmit" class="btn btn-success">Submit</button>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ========================= TABLE CARD ========================= -->
            <div class="box box-primary">

                <div class="box-body">
                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <div class="table-responsive col-md-12">
                            <table class="table table-responsive table-hover table-stripped table-bordered table-condensed">
                                <thead style="background: green; color:white;">
                                    <tr class="text-uppercase text-center">
                                        <th>S/N</th>
                                        <th>File&nbsp;No.</th>
                                        <th>Full Name</th>
                                        <th>Bank</th>
                                        <th>Account&nbsp;No.</th>
                                        <th>Sort&nbsp;Code</th>
                                        <th>Department</th>
                                        <th>Created</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $key = 1; @endphp
                                    @forelse($allStaffDetails as $list)
                                        <tr>
                                            <td>{{ ($allStaffDetails->currentpage() - 1) * $allStaffDetails->perpage() + $key++ }}
                                            </td>
                                            <td>
                                                <span class="label label-primary">
                                                    {{ $list->StaffFileNo ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <td class="text-uppercase">
                                                {{ $list->surname ?? '' }} {{ $list->first_name ?? '' }}
                                                {{ $list->othernames ?? '' }}
                                            </td>
                                            <td>{{ $list->bank }}</td>
                                            <td>{{ $list->claimAccountNo }}</td>
                                            <td>{{ $list->claimBankSortCode }}</td>
                                            <td class="text-uppercase">{{ $list->department }}</td>
                                            <td>{{ $list->created_at }}</td>
                                            <td> <a href="#" title="Update Record" class="btn btn-sm btn-info"
                                                    data-toggle="modal" data-target="#update{{ $list->ID }}">Update</a>
                                            </td>
                                        </tr>
                                        <!-- Modal Dialog for CONFIRMATION-->
                                        <div class="modal fade" id="update{{ $list->ID }}" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header"
                                                        style="background: darkseagreen; color: white; border: 1px solid white;">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-hidden="true"></button>
                                                        <h4 class="modal-title"> Update Staff Details </h4>
                                                    </div>
                                                    <form method="post" action="{{ route('processStaffInfoUpdate') }}">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body col-sm-12" style="padding: 10px;">
                                                            <input type="hidden" name="recordID"
                                                                value="{{ $list->ID }}">

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="file">Staff File No.</label>
                                                                        <input type="text" name="staffFileNo"
                                                                            class="form-control"
                                                                            value="{{ $list->StaffFileNo }}"
                                                                            placeholder ="Staff ID(Optional)" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="name">Surname</label>
                                                                        <input type="text" name="surname"
                                                                            class="form-control"
                                                                            value="{{ $list->surname }}"
                                                                            placeholder ="Required-Staff Name" required />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="name">Firstname</label>
                                                                        <input type="text" name="firstname"
                                                                            class="form-control"
                                                                            value="{{ $list->first_name }}"
                                                                            placeholder ="Required-Staff Name" required />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="name">Middle Name</label>
                                                                        <input type="text" name="othernames"
                                                                            class="form-control"
                                                                            value="{{ $list->othernames }}"
                                                                            placeholder ="Required-Staff Name" required />
                                                                    </div>
                                                                </div>

                                                                {{-- <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="bank">Bank Name</label>
                                                                        <select name="bankName" class="form-control">
                                                                            <option
                                                                                value="{{ $list->staffBankID ? $list->staffBankID : 'selected' }}">
                                                                                {{ $list->bank ? $list->bank : 'Select' }}
                                                                            </option>
                                                                            @forelse($bank as $bkList)
                                                                                <option value="{{ $bkList->bankID }}"
                                                                                    {{ old('bankName') == $bkList->bankID ? 'selected' : '' }}>
                                                                                    {{ $bkList->bank }}</option>
                                                                            @empty
                                                                                <option value="" selected>No Bank
                                                                                    Available
                                                                                </option>
                                                                            @endforelse
                                                                        </select>
                                                                    </div>
                                                                </div> --}}


                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="bank">Bank Name</label>
                                                                        <select name="bankName" class="form-control">
                                                                            <!-- Placeholder / default -->
                                                                            <option value="" disabled
                                                                                {{ !$list->claimBankId ? 'selected' : '' }}>
                                                                                Select Bank</option>

                                                                            <!-- Loop through banks -->
                                                                            @forelse($bank as $bkList)
                                                                                <option value="{{ $bkList->bankID }}"
                                                                                    {{ $list->claimBankId == $bkList->bankID || old('bankName') == $bkList->bankID ? 'selected' : '' }}>
                                                                                    {{ $bkList->bank }}
                                                                                </option>
                                                                            @empty
                                                                                <option value="" selected>No Bank
                                                                                    Available</option>
                                                                            @endforelse
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="account">Account Number</label>
                                                                        <input type="text" name="accountNumber"
                                                                            size="11" class="form-control"
                                                                            value="{{ $list->claimAccountNo }}"
                                                                            placeholder ="Required-Account Number" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="sort">Sort Code</label>
                                                                        <input type="text" name="sortCode"
                                                                            class="form-control"
                                                                            value="{{ $list->claimBankSortCode }}"
                                                                            placeholder ="Optional-Sort Code" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="department">Department</label>
                                                                        <select name="department" class="form-control"
                                                                            required>
                                                                            <option
                                                                                value="{{ $list->staffDepartmentID ? $list->staffDepartmentID : '' }}">
                                                                                {{ $list->department ? $list->department : 'Select' }}
                                                                            </option>
                                                                            @forelse($department as $deptList)
                                                                                <option value="{{ $deptList->id }}"
                                                                                    {{ old('department') == $deptList->id ? 'selected' : '' }}>
                                                                                    {{ $deptList->department }}</option>
                                                                            @empty
                                                                                <option value="" selected>No
                                                                                    Department
                                                                                    Available</option>
                                                                            @endforelse
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div><!--//row-->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
                                                                <i class="fa fa-crosshairs"></i> Cancel
                                                            </button>
                                                            <button type="submit" name="processUpdate"
                                                                class="btn btn-success">
                                                                <i class="fa fa-save"></i> Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- //DELETE Modal Dialog -->
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-danger text-center"> No record found yet !</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div align="right">
                                Showing {{ ($allStaffDetails->currentpage() - 1) * $allStaffDetails->perpage() + 1 }}
                                to {{ $allStaffDetails->currentpage() * $allStaffDetails->perpage() }}
                                of {{ $allStaffDetails->total() }} entries
                            </div>
                            <div class="hidden-print">{{ $allStaffDetails->links() }}</div>
                            <br><br><br>
                        </div>
                    </div>
                </div>
                <br><br><br><br>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript"></script>
@endsection
