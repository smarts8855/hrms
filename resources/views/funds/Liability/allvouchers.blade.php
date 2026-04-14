@extends('layouts.layout')
@section('pageTitle')
    Voucher list
@endsection
@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"> @yield('pageTitle') <span id='processing'></span></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        @include('funds.Share.message')
                        <!-- /.row -->

                        <div class="row hidden-print">
                            <form id="thisform1" name="thisform1" method="post">
                                <div class="col-md-12">
                                    <div class="form-group">

                                        <div class="col-md-2">
                                            <label class="control-label">Date From</label>
                                            <input type="text" class="col-sm-9 form-control" value="{{ $fromdate }}"
                                                name="fromdate" id="fromdate">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label">Date To</label>
                                            <input type="text" class="col-sm-9 form-control" value="{{ $todate }}"
                                                name="todate" id="todate">
                                        </div>
                                        <div class="col-md-5">
                                            <label>Current Location</label>
                                            <select name="location" id="location" class="form-control"
                                                onchange ="ReloadForm();">
                                                <option value="" selected>-All-</option>
                                                @foreach ($UnitLocation as $b)
                                                    <option value="{{ $b->id }}"
                                                        {{ $location == "$b->id" ? 'selected' : '' }}>{{ $b->unit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">

                                        <br>
                                        <label class="control-label"></label>
                                        <button type="submit" class="btn btn-success" name="add">
                                            <i class="fab fa-btn fa-sistrix"></i> Search
                                        </button>

                                    </div>
                                </div>
                                {{ csrf_field() }}
                            </form>
                        </div>
                        <div class="row">

                            <!-- /.col -->
                        </div>


                        <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                            <table id="res_tab" class="table table-bordered table-striped table-highlight">
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                        <th>S/N</th>
                                        <th>Action</th>
                                        <th>Beneficiary</th>
                                        <th>Total Amount</th>
                                        <th>Contract Description</th>
                                        <th>Payment Description</th>
                                        <th>Vote Description</th>
                                        <th>Progress Status</th>
                                        <th>Location</th>
                                        <th>Date Prepared</th>
                                        <th>Date Passed</th>

                                    </tr>
                                </thead>
                                @php $i = 1; @endphp
                                <tbody>
                                    @if ($tablecontent)
                                        @foreach ($tablecontent as $list)
                                            <tr @if ($list->isrejected == 1) style="background-color: red; color:#FFF;" @endif
                                                @if ($list->is_need_more_doc == 1) style="background-color: #FF7F50; color:#FFF;" @endif>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-danger btn-xs dropdown-toggle" type="button"
                                                            id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="true">
                                                            Action
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="/display/voucher/{{ $list->ID }}">Preview</a>
                                                            </li>
                                                            <li><a href="/display/comment/{{ $list->conID }}"
                                                                    target="_blank">View Minute</a></li>
                                                        </ul>
                                                    </div>
                                                </td>

                                                @if ($list->companyID != '13')
                                                    <td>{{ $list->contractor }} <br> {{$list->voucherFileNo}} </td>
                                                @else
                                                    <td>{{ $list->payment_beneficiary }} <br> {{$list->voucherFileNo}} </td>
                                                @endif
                                                <td>{{ number_format($list->totalPayment, 2) }}</td>
                                                <td>{{ $list->ContractDescriptions }}</td>
                                                <td>{{ $list->paymentDescription }}</td>
                                                <td>{{ $list->economicCode }}:{{ $list->ecotext }}-{{ $list->contractType }}
                                                </td>
                                                <td>{{ $list->statusdesc }}</td>
                                                <td>
                                                    @if ($list->vstage < 1 && $list->is_advances == 1)
                                                        Advances
                                                    @else
                                                        {{ $list->unit }}
                                                    @endif
                                                </td>
                                                <td>{{ $list->datePrepared }}</td>
                                                <td>{{ $list->dateTakingLiability }}</td>
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
                            <br><br><br><br><br>
                        </div>
                        <input type="hidden" value="" id="co" name="court">
                        <input type="hidden" value="" id="di" name="division">
                        <input type="hidden" value="" name="status">
                        <input type="hidden" value="" name="chosen" id="chosen">
                        <input type="hidden" value="" id="type" name="type">

                        <hr />
                    </div>

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
                $(function() {
                    $("#fromdate").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                    $("#todate").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                });

                function ReloadForm() {
                    document.getElementById('thisform1').submit();
                    return;
                }

                $('#res_tab').DataTable({
                    "pageLength": 50
                });
            </script>
        @stop
