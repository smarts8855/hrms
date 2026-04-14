@extends('layouts.layout')

@section('pageTitle')
    PERSONAL EMOLUMENT RECORDS
@endsection

@section('content')
    <div class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:0 5px;">
            <form class="form-horizontal" method="post" action="{{ url('/add-staff/create') }}">
                {{ csrf_field() }}


                <div class="col-md-12 hidden-print">
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

                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> {{ session('msg') }}
                        </div>
                    @endif
                    @if (session('err'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Operation Error !<br></strong> {{ session('err') }}
                        </div>
                    @endif
                </div>

                <p>
                <div class="row">

                    <div align="right" class="col-xs-6">
                        <table>
                            <tr>
                                <td>
                                    <img src="{{ asset('Images/avatarNoImg3.jpg') }}" height="100">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                </p>

                <p>
                <h4 class="text-success text-center">
                    <strong>Add New Staff</strong>
                </h4>
                </p>



                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">

                        <div style="margin: 0px  5%;">

                            <div class="form-group">
                                {{-- <label class="control-label col-sm-2" for="grade">Division</label>
                                <div class="col-sm-10">
                                    <select name="divisionID" class="form-control">
                                        @foreach ($divisionType as $div)
                                            <option value="{{ $div->divisionID }}">{{ $div->division }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <label class="control-label col-sm-2" for="grade">Division</label>
                                <div class="col-sm-10">
                                    @if (session('is_global') == 0)
                                        <input type="hidden" name="" id="statusChecker" value="0">
                                    @else
                                        <input type="hidden" name="" id="statusChecker" value="1">
                                    @endif


                                    @if ($User->is_global == 1)
                                        <select name="divisionID" id="divisionID" class="form-control">
                                            {{-- <option selected disabled>Division</option> --}}
                                            @foreach ($divisionType as $division)
                                                <option value="{{ $division->divisionID }}">{{ $division->division }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="divisionName"
                                                    name="divisionName" value="{{ $curDivision->division }}" readonly>
                                            </div>
                                        </div>
                                        <input type="hidden" id="divisionID" name="divisionID"
                                            value="{{ Auth::user()->divisionID }}">
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="grade">File Number</label>
                                <div class="col-sm-10">
                                    <input type="text" name="fileNo" id="fileNo" value="{{ old('fileNo') }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                
                            </div>
                             <div class="form-group">
                                <label class="control-label col-sm-2" for="fullName">Name:</label>
                                <div class="col-sm-10 row">
                                    <div class="col-sm-4">
                                        <input type="text" name="surname" id="surname"
                                            value="{{ old('surname') }}" class="form-control" placeholder="Surname">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="firstName" id="firstName"
                                            value="{{ old('firstName') }}" required class="form-control"
                                            placeholder="First Name">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="otherNames" id="otherNames"
                                            value="{{ old('otherNames') }}" class="form-control"
                                            placeholder="Other Names">
                                    </div>
                                </div>
                                <!--//for update-->
                                <div class="col-sm-4">

                                </div>
                            </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="grade">Employment Type</label>
                                <div class="col-sm-3">
                                    <select name="employmentType" class="form-control">
                                        @foreach ($empType as $list)
                                            <option value="{{ $list->id }}">{{ $list->employmentType }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="control-label col-sm-2" for="grade">Grade Level:</label>
                                <div class="col-sm-2">
                                    <input type="number" name="grade" id="grade" value="{{ old('grade') }}"
                                        class="form-control" required>
                                </div>

                                <label class="control-label col-sm-1" for="grade">Step:</label>
                                <div class="col-sm-2">
                                    <input type="number" name="step" id="step" value="{{ old('grade') }}"
                                        class="form-control" required>
                                </div>

                                
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="bank">Bank:</label>
                                <div class="col-sm-10">
                                    <select name="bank" id="bank" class="form-control">
                                        @foreach ($tblbanklists as $tblbanklist)
                                            <option value="{{ $tblbanklist->bankID }}">{{ $tblbanklist->bank }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

							<div class="form-group">
                                <label class="control-label col-sm-2" for="bank">Bank Group:</label>
                                <div class="col-sm-10">
                                     <input type="number" name="bankGroup" id="bankGroup" value="{{ old('bankGroup') }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="account_no">Account No:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="account_no" id="account_no" value="{{ old('account_no') }}"
                                        class="form-control" placeholder="Account No">
                                </div>
                            </div>

                           
                            <div class="form-group">

                                <div class="col-sm-10">
                                    <input type="submit" name="submit" id="fileNo" value="Submit"
                                        class="btn btn-success">
                                </div>
                            </div>


                        </div>
                        <hr />
                        <p>
                        <div class="row" align="center">
                            <div class="col-sm-12">

                            </div>
                        </div>
                        </p>
                    </div>
                    <div class="col-sm-2"></div>
                </div>

                <!-- Modal Dialog for UPDATE RECORD-->
                <div class="modal fade" id="confirmUpdate" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                                <h4 class="modal-title">PERSONAL EMOLUMENT RECORDS FOR {{ date('Y') }}</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to perform this operation?
                                    <br />
                                    &nbsp; <b>Continue</b> - this will save/update your record <br />
                                    &nbsp; <b>Cancel</b> - this will return you back to the same page
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <input type="submit" name="button" class="btn btn-info" value="Continue">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //Modal Dialog -->


            </form>
        </div>
    </div>
@stop

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript">
        if (fileNo == "") {
            $('#saveUpdate').attr("disabled", true);
        } else {
            $('#saveUpdate').attr("disabled", false);
        }
        (function() {
            $('#getStaff').change(function() {
                var fileNo = $('#getStaff').val();
                //alert(fileNo);
                $('#processing').text('Processing. Please wait...');
                $.ajax({
                    url: murl + '/personal-emolument/findStaff',
                    type: "post",
                    data: {
                        'getStaff': $('#getStaff').val(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        console.log(data);
                        $('#saveUpdate').attr("disabled", false);
                        $('#processing').text('');
                        $('#surname').val(data.surname);
                        $('#fileNo').val(data.fileNo);
                        $('#firstName').val(data.first_name);
                        $('#otherNames').val(data.othernames);
                        $('#grade').val(data.grade);
                        $('#step').val(data.step);
                        $('#division').val(data.division);
                        $('#bank').append('<option value="' + data.bankID + '" selected>' + data
                            .bank + '</option>');
                        $('#branch').val(data.bank_branch);
                        $('#accountNo').val(data.AccNo);
                        $('#section').append('<option value="' + data.id + '" selected>' + data
                            .depart + '</option>');
                        $('#appointmentDate').val(data.appointment_date);
                        $('#incrementalDate').val(data.incremental_date);
                        $('#dateOfBirth').val(data.dob);
                        $('#residentialAddress').val(data.home_address);
                        $('#qurter').val(data.government_qtr);
                        $('#phoneNumber').val(data.phone);
                        $('#leaveAddress').val(data.leaveaddress);
                    }
                })
            });
        })();
        ////////////////////////////////////////////////////////
        $(function() {
            $("#appointmentDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#incrementalDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#dateOfBirth").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#returnBefore").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#failureReturn").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@stop
