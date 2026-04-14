@extends('layouts.layout')
@section('pageTitle')
    Contract/Claim Reports
@endsection



@section('content')

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>

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
                        <strong>Input Error!</strong> <br />
                        {{ session('err') }}
                    </div>
                @endif
            </div>


            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        @include('funds.Share.message')

                        <form class="form-horizontal" id="form1" role="form" method="post" action="">
                            {{ csrf_field() }}

                            <div class="col-md-12"><!--2nd col-->
                                <!-- /.row -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Contract Type</label>
                                        <select class="form-control" id="contracttype" onchange="getTable()"
                                            name="contracttype">
                                            <option value="">-select Contract Type</option>
                                            @foreach ($contractlist as $list)
                                                <option value="{{ $list->ID }}"
                                                    {{ $contracttype == $list->ID || $list->ID == old('contracttype') ? 'selected' : '' }}>
                                                    {{ $list->contractType }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-3">
                                        <label class="control-label"> Status </label>
                                        <select id="status" name="status" onchange="getTable()" class="form-control">

                                            <option value="All"
                                                {{ $status === 'All' || 'All' == old('status') ? 'selected' : '' }}>All
                                            </option>
                                            @foreach ($paymemtstatus as $list)
                                                <option value="{{ $list->code }}"
                                                    {{ $status == $list->code || $list->code == old('status') ? 'selected' : '' }}>
                                                    {{ $list->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label"> Approval From </label>
                                        <input type="text" class="form-control" id="datepicker1" name="datepicker1"
                                            value={{ $datepicker1 }} onchange="getTable()" />
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label"> To </label>
                                        <input type="text" class="form-control" id="datepicker2" name="datepicker2"
                                            value={{ $datepicker2 }} onchange="getTable()" />
                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <button type="submit" class="btn btn-success">Go </button>
                                    </div>


                                </div>
                            </div>
                            <!-- /.col -->
                    </div>
                    </form>
                    <!-- /.row -->
                    <form method="post" id="form2">
                        <div class="row">
                            {{ csrf_field() }}

                            <div class="col-md-12"><!--2nd col-->
                                <!-- /.row -->
                                <!--<div class="col-md-6"></div>
                        <div class="col-md-6 " >
                            <div class="col-md-0 checkbox pull-right" style="margin:2px;"><label class="text-primary" for="check-all"><input  type="checkbox" class="checkitem" name="check-all" id="check-all">CheckAll</label></div>
                            <div class="col-md-0 pull-right" style="margin:2px;"><span onclick="return reject()" class="btn btn-xs btn-warning">Reject</span></div>
                            <div class="col-md-0 pull-right" style="margin:2px;"><span onclick="return approve()" class="btn btn-xs btn-success">Approve</span></div>
                             <div class="col-md-0 pull-right" style="margin:2px;"><span onclick="return delet()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></span></div>                     </div>
                    </div>-->
                                <!-- /.col -->
                            </div>


                            <div class="table-responsive col-md-12">
                                <table id="res_tab" class="table table-bordered table-striped table-highlight">
                                    <thead>
                                        <tr bgcolor="#c7c7c7">
                                            <th>S/N</th>

                                            <th>File No</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Balance</th>
                                            <th>Beneficiary</th>
                                            <th>Created By</th>
                                            <th>Award/Approved Date</th>
                                            <th>Payment Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    @php $i = 1; @endphp
                                    <tbody>

                                        @foreach ($tablecontent as $list)
                                            <tr>
                                                <td>{{ $i++ }}</td>

                                                <td>{{ $list->fileNo }}</td>
                                                <td>{{ $list->ContractDescriptions }}</td>
                                                <td>&#8358; {{ number_format($list->contractValue) }}</td>
                                                <td> &#8358; {{ number_format($list->contractBalance) }} </td>
                                                @if ($list->voucherType == 2)
                                                    <td>{{ $list->beneficiary }}</td>
                                                @else
                                                    <td>{{ $list->contractor }}</td>
                                                @endif
                                                <td>{{ $list->createdby }}</td>


                                                <td>{{ $list->dateAward }} </td>

                                                <td>
                                                    @if ($list->paymentStatus == 0)
                                                        <b><span class="text-danger">Pending</span></b>
                                                    @elseif($list->paymentStatus == 2)
                                                        <b><span class="text-success">Completed</span></b>
                                                    @else
                                                        <b><span class="text-info">Part Payment</span></b>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="/display/comment/{{ $list->ID }}" target="_blank"
                                                        class="btn btn-info">View Details</a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br><br><br><br><br>
                            </div>

                    </form>
                    <hr />
                </div>
                <br><br><br>
            </div>
        </div>



    @endsection
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    @stop

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
            $('#res_tab').DataTable();
            $(function() {
                $("#todayDate").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
                });
            });


            $("#datepicker1").datepicker({
                dateFormat: "yy-mm-dd",
                onSelect: function(dateText) {
                    $('#getCompany').val($('#contractorList').val());
                    $('#getStatus').val($('#statusList').val());
                    $('#getTime1').val($('#datepicker1').val());
                    $('#getTime2').val($('#datepicker2').val());
                    $("#SearchContract").submit();
                }

            });

            $("#datepicker2").datepicker({
                dateFormat: "yy-mm-dd",
                onSelect: function(dateText) {
                    $('#getCompany').val($('#contractorList').val());
                    $('#getStatus').val($('#statusList').val());
                    $('#getTime1').val($('#datepicker1').val());
                    $('#getTime2').val($('#datepicker2').val());
                    $("#SearchContract").submit();
                }
            });

            function getTable() {

                $('#form1').submit();

            }
        </script>
    @stop
