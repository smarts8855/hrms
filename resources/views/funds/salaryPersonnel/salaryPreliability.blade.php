@extends('layouts.layout')
@section('pageTitle')
    Personnel Funds Clearance
@endsection

@section('content')

    <div id="vim" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">All Minutes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12" id="z-space">

                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <!--<button type="Submit" class="btn btn-success" id="putedit"></button>-->
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>


            </div>

        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"> @yield('pageTitle') <span id='processing'></span></h3>
        </div>
        <div class="box box-success">

            <div class="box-body box-profile">
                <div class="col-md-12">
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
                    @if ($error != '')
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong>
                            <p>{{ $error }}</p>
                        </div>
                    @endif
                    @if ($success != '')
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> <br />
                            {{ $success }}
                        </div>
                    @endif
                    @if (session('err'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Warning!</strong> <br />
                            {{ session('err') }}
                        </div>
                    @endif
                </div>

                <form class="form-horizontal" role="form" id="form1" method="post" action="">
                     {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12"><!--1st col-->
                                @include('funds.Share.message')

                                <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                                    <table id="res_tab" class="table table-bordered table-striped table-highlight">
                                        <thead>
                                            <tr bgcolor="#c7c7c7">
                                                <th>S/N</th>
                                                <th>Action</th>

                                                <th>Beneficiary</th>
                                                <th>Total Amount</th>
                                                <th>Contract/Claim Description</th>
                                                <th>Payment Description</th>
                                                <th>Vote Description</th>
                                                <th>Vote Balance</th>
                                                <th>Uncleared Liability</th>
                                                <th>Designated Staff</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        @php $i = 1; @endphp
                                        <tbody>
                                            @if ($tablecontent)
                                                @foreach ($tablecontent as $list)
                                                    <tr
                                                        @if ($list->isrejected == 1) style="background-color: red; color:#FFF;" @endif>
                                                        <td>{{ $i++ }}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-danger btn-xs dropdown-toggle"
                                                                    type="button" id="dropdownMenu1" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="true">
                                                                    Action
                                                                    <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                                    <li><a target= "_blank"
                                                                            href="/display/voucher/{{ $list->ID }}">Preview</a>
                                                                    </li>
                                                                    <li>
                                                                        <a onclick="accept('{{ $list->ID }}','{{ $list->economicCodeID }}', '{{ $list->contractTypeID }}')"
                                                                            href="#">Process</a>
                                                                    </li>
                                                                    @if ($list->is_salary == 2)
                                                                    @else
                                                                        <li>
                                                                            <a href="/display/comment/{{ $list->conID }}"
                                                                                target="_blank">View Comment</a>
                                                                        </li>
                                                                    @endif


                                                                    <li>
                                                                        <a onclick="Switch_Code('{{ $list->ID }}')">Switch
                                                                            Vote</a>
                                                                    </li>
                                                                    {{-- <li>
                                                                        <a onclick="decline('{{ $list->ID }}')"
                                                                            href="#">Decline</a>
                                                                    </li> --}}
                                                                </ul>
                                                            </div>
                                                        </td>

                                                        @if ($list->voucherType == '1')
                                                            <td>{{ $list->contractor }} <br> {{$list->voucherFileNo}} </td>
                                                        @else
                                                            <td>{{ $list->payment_beneficiary }} <br> {{$list->voucherFileNo}}</td>
                                                        @endif

                                                        <td>{{ number_format($list->totalPayment, 2) }}</td>
                                                        <td>{{ $list->ContractDescriptions }}</td>
                                                        <td>{{ $list->paymentDescription }}</td>
                                                        <td>{{ $list->economicCode }}:{{ $list->voteinfo }}-{{ $list->contractType }}
                                                        </td>
                                                        <td>{{ number_format($list->votebal, 2) }}</td>
                                                        <td>{{ number_format($list->OutstandingLiability, 2) }}</td>
                                                        <td>
                                                            <select class="form-control" id="staff{{ $list->ID }}">
                                                                <option value="">-Select Staff-</option>
                                                                @foreach ($UnitStaff as $list2)
                                                                    <option value="{{ $list2->user_id }}"
                                                                        {{ $list->liabilityBy == $list2->user_id ? 'selected' : '' }}>
                                                                        {{ $list2->Names }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-xs btn-success" style="cursor: pointer;"
                                                                onclick="return AssignStaff('{{ $list->ID }}')">Assign</a>

                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="100%">
                                                        <center>No Record</center>
                                                    </td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                    <br><br><br><br><br><br>
                                </div>
                                <hr />
                            </div>

                        </div>
                    </div>
                    <input type="hidden" id="assvid" name="vid">
                    <input type="hidden" id="as_user" name="as_user">
                </form>


                <div id="approveindex" class="modal fade">
                    <form class="form-horizontal" role="form" method="post" action="">
                        {{ csrf_field() }}
                        <div class="modal-dialog box-default" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title"> Clearance Comfirmation </h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5> You are about to clear this voucher for further processing! Do you still want to
                                        continue?</h5>
                                    <div id="uncleared_liability"> </div>
                                    <div class="form-group" style="margin: 0 10px;">
                                        <input type="hidden" id="ctType" name="ctType">

                                        <div class="col-sm-12" style="display:none;">
                                            <select name="year" id="year" class="form-control">
                                                <option value="">Select Year</option>
                                                
                                            </select>
                                        </div>

                                        <div class="col-sm-12">
                                            <label class="control-label"><b>Enter comment if any(optional)</b></label>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="comment" class="form-control"> </textarea>
                                        </div>
                                        <input type="hidden" id="vaid" name="vid">
                                        <input type="hidden" id="lid" name="lid">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="Submit" name="process" class="btn btn-success">Continue</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="switchcode" class="modal fade">
                    <form class="form-horizontal" role="form" method="post" action="">
                        {{ csrf_field() }}
                        <div class="modal-dialog box-default" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title"> Change Economics vote </h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group" style="margin: 0 10px;">
                                        <div class="col-sm-12">
                                            <label class="control-label"><b>Select Economic code</b></label>
                                        </div>
                                        <div class="col-sm-12">
                                            <select name="economiccode" id="economiccode"
                                                class="select_picker form-control" data-live-search="true" required>
                                                <option value="">Select Economic Code</option>
                                                @foreach ($econocodeList as $list)
                                                    <option value="{{ $list->ID }}">{{ $list->economicCode }}:
                                                        {{ $list->description }}-{{ $list->contractType }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" id="switchid" name="vid">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="Submit" name="switch" class="btn btn-success">Continue</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!--decline modal-->
                <div id="declineModal" class="modal fade">
                    <form class="form-horizontal" role="form" method="post" action="">
                        {{ csrf_field() }}
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Clearance Rejection</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5> You are about to reject this voucher for further processing! Do you still want to
                                        continue?</h5>
                                    <div class="form-group" style="margin: 0 10px;">
                                        <div class="col-sm-12">
                                            <label class="control-label"><b>Enter Reason for Decline</b></label>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea name="comment" class="form-control" required> </textarea>
                                        </div>
                                        <input type="hidden" id="vdid" name="vid">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="Submit" name="decline" class="btn btn-success">Continue</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <!--end of decline modal-->
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <!-- Include Required Prerequisites -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
    <!-- Include Date Range Picker -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endsection


@section('styles')
    <style type="text/css">
        .modal-dialog {
            width: 13cm
        }

        .modal-header {

            background-color: #006600;

            color: #FFF;

        }

        #partStatus {
            width: 2.5cm
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        function accept(a, eco, contractType) {
            document.getElementById('vaid').value = a;
            document.getElementById('ctType').value = contractType;
            Find_existing_liability(eco);
            if(contractType == 4){
                Find_last_period_capital(contractType)
            }
            $("#approveindex").modal('show');
        }

        function Switch_Code(a) {
            document.getElementById('switchid').value = a;
            $("#switchcode").modal('show');
        }

        function decline(a = "") {
            document.getElementById('vdid').value = a;
            $("#declineModal").modal('show')
            return false;
        }

        function AssignStaff(id) {
            //alert(id);
            document.getElementById('assvid').value = id;
            document.getElementById('as_user').value = document.getElementById("staff" + id).value;
            if (document.getElementById('as_user').value !== "") {
                document.getElementById('form1').submit();
                return;
            }
        }

        function tableCreate(data) {
            //alert();
            var tbl = '<div class="table-responsive" style="padding:10px;">';
            tbl += '<table id="mytable" class="table table-bordered table-striped table-highlight">';
            tbl += '<tr bgcolor="#c7c7c7">';
            tbl += '<th>S/N </th>';
            tbl += '<th>Contract details</th>';
            tbl += '<th>Amount</th>';
            tbl += '<th>Check</th>';
            tbl += '</tr>';
            tbl += '<tbody>';
            $.each(data, function(index, obj) {
                tbl += '<tr><td> </td>';
                tbl += '<td>' + obj.decription + '</td>';
                tbl += '<td>' + obj.amount + '</td>';
                tbl += '<td> <input type="checkbox" id="checkbox' + obj.id + '" onclick="toggle_this(' + obj.id +
                    ')" value="0"> </td> </tr>';
            });
            tbl += '</tbody>';
            tbl += '</table>';
            tbl += '</div>';
            $('#uncleared_liability').empty();
            $('#uncleared_liability').append(tbl);
        }

        function Find_existing_liability(code) {
            $('#uncleared_liability').empty();
            document.getElementById("lid").value = '';
            $.ajax({
                url: murl + '/find-liabilty',
                type: "post",
                data: {
                    'code': code,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    console.log(data);
                    if (data.length == 0) {
                        //alert(code);
                        return;
                    }
                    //alert("kdkdkd");
                    tableCreate(data);
                }
            });
        }

        function Find_last_period_capital(ctType) {
                    $.ajax({
                        url: murl + '/past-period-for-capital',
                        type: "post",
                        data: {
                            'ctTypeID': ctType,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(data) {
                            console.log(data);
                            var $year = $('#year');
                            // reset select
                            $year.empty();
                            $year.append($('<option>').val('').text('Select Year'));
                            
                                if (Array.isArray(data) && data.length > 0) {
                                            data.forEach(function(y) {
                                                $year.append($('<option>').val(y).text(y));
                                            });
                                            $year.prop('disabled', false);
                                            $year.closest('div').show(); // ensure container is visible
                                        } else {
                                            // no data -> disable and show placeholder only
                                            $year.prop('disabled', true);
                                            $year.closest('div').show();
                                        }

                                        // if using bootstrap-select / selectpicker, refresh it
                                        if (typeof $year.selectpicker === 'function') {
                                            $year.selectpicker('refresh');
                                        }
                                    },
                                    error: function(xhr, status, err) {
                                        console.error('Error fetching past-period-for-capital:', err);
                                    }
                    });
                }

        function toggle_this(id) {
            var x = document.getElementById("checkbox" + id);
            if (x.value == 0) {
                x.value = 1;
                document.getElementById("lid").value = id;
                return;
            } else {
                x.value = 0;
                document.getElementById("lid").value = '';
                return;
            }
        }
        $('.select_picker').selectpicker({
            style: 'btn-default',
            size: 4
        });
    </script>

    @includeif('layouts._searchByDatePatial')
@endsection
