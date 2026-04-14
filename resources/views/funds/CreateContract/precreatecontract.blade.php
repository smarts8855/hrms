@extends('layouts.layout')
@section('pageTitle')
    {{ strtoupper('search contracts to raise voucher') }}
@endsection
@section('content')

    <div id="vim" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">All comments</h4>
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
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>

            <div class="row">
                <div class="col-md-12"><!--1st col-->
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
                </div>
            </div>


            <div class="box box-success">
                <div class="box-body">
                    @include('funds.Share.message')
                    <form class="form-horizontal" role="form" id="form1" method="post" action="">
                        {{ csrf_field() }}

                        <div class="col-md-12">
                            <div class="form-group">

                                <div class="col-md-3">
                                    <label class="control-label">-Select Economic Group-</label>
                                    <select class="form-control" name="contracttype" id="contracttype" placeholder="">
                                        <option value="">Select Contract</option>
                                        @foreach ($contracttypes as $list)
                                            <option value="{{ $list->ID }}"
                                                {{ $list->ID == $contracttype || $list->ID == old('contracttype') ? 'selected' : '' }}>
                                                {{ $list->contractType }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Contractor/Staff Voucher</label>
                                    <select name="contractor" id="contractor" class="form-control">
                                        <option value="">-Select All-</option>
                                        @foreach ($companyDetails as $list)
                                            <option value="{{ $list->id }}"
                                                {{ $list->id == $contractor || $list->id == old('contractor') ? 'selected' : '' }}>
                                                {{ $list->contractor }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">File No</label>
                                    <input list="fileNos" value="{{ $fileno ? $fileno : old('fileno') }}" name="fileno"
                                        id="fileno" autocomplete="off" class="form-control">
                                    <datalist id="fileNos">
                                        @foreach ($fileNos as $list)
                                            <option value="{{ $list->fileNo }}">{{ $list->fileNo }}</option>
                                        @endforeach
                                    </datalist>
                                </div>


                                <div class="col-md-1">
                                    <label class="control-label">&nbsp</label>
                                    <button class="btn btn-success form-control">Search</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="hiddencontractid" name="hiddencontractid">
                        <input type="hidden" id="hiddenuserid" name="hiddenuserid">
                    </form>

                    <form id="form10" method="post" action="/voucher/continue" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="selectedid" id="selectedid">
                        <input type="hidden" name="contracttype2" id="contracttype2">
                    </form>
                    <!--decline modal-->
                    <div id="declineModal" class="modal fade">
                        <form class="form-horizontal" role="form" method="post" action="/return/contract">
                            {{ csrf_field() }}
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Decline Approval</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h5> You are about to return this document back to the last officer! Do you still
                                            want
                                            to continue?</h5>
                                        <div class="form-group" style="margin: 0 10px;">
                                            <div class="col-sm-12">
                                                <label class="control-label"><b>Enter Reason for Decline</b></label>
                                            </div>
                                            <div class="col-sm-12">
                                                <textarea name="comment" class="form-control" required> </textarea>
                                            </div>
                                            <input type="hidden" id="vdid" name="id">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="Submit" name="decline" class="btn btn-success">Continue</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- ========================= TABLE CARD ========================= -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title text-uppercase">VOUCHER List</h4>
                </div>

                <div class="box-body">
                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    <th>S/N</th>
                                    <th>Action</th>
                                    <th>File No</th>
                                    <th>Description</th>
                                    <th>Total Amount</th>
                                    <th>Balance</th>
                                    <th>Beneficiary</th>
                                    <th>Approved By</th>
                                    <th>Approved Date</th>
                                    <th>Designated Staff</th>
                                    <th></th>

                                </tr>
                            </thead>
                            @php $i = 1; @endphp
                            <tbody>
                                @if ($tablecontent)
                                    @foreach ($tablecontent as $list)
                                        @if ($list->contractBalance != 0)
                                            <tr>
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
                                                            <li><a onclick="setID('{{ encrypt($list->ID) }}')"
                                                                    style="color: green; cursor: pointer;">Process</a>
                                                            </li>
                                                            <li><a onclick="decline('{{ $list->ID }}')"
                                                                    style="color: red; cursor: pointer;">Decline</a>
                                                            </li>
                                                            <li><a href="/display/comment/{{ $list->ID }}"
                                                                    style="color: blue; cursor: pointer;" target="_blank">View Comment</a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </td>
                                                <td>{{ $list->fileNo }}</td>

                                                <td>{{ $list->ContractDescriptions }}</td>

                                                <td> {{ number_format($list->contractValue, 2) }} </td>
                                                <td> {{ number_format($list->contractBalance, 2) }} </td>
                                                <td>
                                                    @if ($list->companyID == 13)
                                                        {{ $list->beneficiary }}@else{{ $list->contractor }}
                                                    @endif
                                                </td>
                                                <td>{{ $list->approvedBy }}</td>
                                                <td>{{ $list->approvalDate }} </td>
                                                <td>
                                                    <select class="form-control" id="staff{{ $list->ID }}">
                                                        <option value="">-Select Staff-</option>
                                                        @foreach ($UnitStaff as $list2)
                                                            <option value="{{ $list2->user_id }}"
                                                                {{ $list->OC_staffId == $list2->user_id ? 'selected' : '' }}>
                                                                {{ $list2->Names }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td id="{{ $list->ID }}">
                                                    <a class="btn btn-xs btn-success" style="cursor: pointer;"
                                                        onclick="return AssignStaff('{{ $list->ID }}')">Assign</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100%">No record</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <br><br><br><br><br>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end of decline modal-->
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@stop
@section('styles')
    <style type="text/css">
        .modal-dialog {
            width: 10cm
        }

        .modal-header {

            background-color: #006600;

            color: #FFF;

        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        function delfunc(a) {
            $(document).ready(function() {
                $('#conID').val(a);
                $("#delModal").modal('show');
            });
        }

        function AssignStaff(id) {
            document.getElementById('hiddencontractid').value = id;
            document.getElementById('hiddenuserid').value = document.getElementById("staff" + id).value;
            if (document.getElementById('hiddenuserid').value !== "") {
                document.getElementById('form1').submit();
                return;
            }

        }

        function setID(id) {
            document.getElementById('selectedid').value = id;
            return window.location.assign('/voucher/continue/' + id + '/');

        }

        function accept(a = "") {
            document.getElementById('vaid').value = a;
            $("#approveindex").modal('show');
        }

        function decline(a = "") {
            document.getElementById('vdid').value = a;
            $("#declineModal").modal('show')
            return false;
        }
    </script>


@stop
