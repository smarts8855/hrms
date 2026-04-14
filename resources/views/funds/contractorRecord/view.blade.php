@extends('layouts.layout')
@section('pageTitle')
    Payment Transactions
@endsection
@section('content')


    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') for @foreach ($description as $d)
                        {{ $d->ContractDescriptions }}
                    @endforeach
                    <span id='processing'></span>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        @if ($warning != '')
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ $warning }}</strong>
                            </div>
                        @endif
                        @if ($success != '')
                            <div class="alert alert-dismissible alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ $success }}</strong>
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

                        <div class="col-md-2">
                            <br>
                            <label class="control-label"></label>
                            <a href="{{ url('/contractor-record') }}" class="btn btn-success" name="add">
                                <i class="fab fa-btn fa-sistrix"></i> Back
                            </a>
                        </div>


                        <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                            <table id="mytable" class="table table-bordered table-striped table-highlight">
                                <thead>
                                    <tr bgcolor="#c7c7c7">


                                        <th>S/N</th>
                                        <th> Contractor</th>
                                        <th> Payment Description</th>
                                        <th> Status</th>
                                        <th> Voucher Date</th>

                                        <th> Amount</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                @php
                                    $i = 1;
                                    $grossAmount = 0.0;
                                @endphp


                                @foreach ($transactions as $t)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $t->contractor }}</td>

                                        <td>{{ $t->paymentDescription }}</td>
                                        <td>

                                            @if ($t->stat == 1)
                                                <span class="text-success"> Approved </span>
                                            @elseif($t->stat == 2)
                                                <span class="text-primary"> Booked </span>
                                            @elseif($t->stat == 3)
                                                <span class="text-danger"> Rejected </span>
                                            @elseif($t->stat == 4)
                                                <span class="text-success"> Commenced </span>
                                            @elseif($t->stat == 5)
                                                <span class="text-success"> Complete </span>
                                            @elseif($t->stat == 6)
                                                <span class="text-success"> Paid </span>
                                            @else
                                                <span class="text-danger"> Pending </span>
                                            @endif

                                        </td>
                                        <td>{{ $t->datePrepared }}</td>
                                        <td>{{ $t->totalPayment }}</td>
                                        <td>
                                            <a href="{{ url('/display/voucher') }}/{{ $t->ID }}"
                                                class="btn btn-primary fa fa-eye" class="" id=""> View</a>
                                        </td>




                                    </tr>
                                @endforeach
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <th>Total</th>
                                        <td>₦ @php $grossAmount = 0.0; @endphp
                                            @foreach ($transactions as $t)
                                                @php
                                                    $grossAmount += $t->totalPayment;
                                                @endphp
                                            @endforeach
                                            {{ number_format($grossAmount) }}
                                        </td>

                                        <td></td>
                                    </tr>
                                </tfoot>

                            </table>

                        </div>

                        <hr />
                    </div>

                </div>
            </div>




        @endsection

        @section('styles')
            <style type="text/css">
                .modal-dialog {
                    width: 15cm
                }

                .modal-header {

                    background-color: #20b56d;

                    color: #FFF;

                }
            </style>
        @endsection

        @section('scripts')
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
            <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

            <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

            <script>
                function ReloadForm() {
                    document.getElementById('thisform1').submit();
                    return;
                }

                function ReloadForm2() {
                    document.getElementById('editBModal').submit();
                    return;
                }

                function editfunc(a, b, c, d, e, f, g) {
                    $(document).ready(function() {
                        $('#period').val(a);
                        $('#allocationType').val(b);
                        $('#economicGroup').val(c);
                        $('#economicCode').val(d);
                        $('#budget').val(e);
                        $('#economicHead').val(f);
                        $('#B_id').val(g);
                        $("#editModal").modal('show');
                    });
                }

                function delfunc(a, b) {
                    $(document).ready(function() {
                        $('#conID').val(a);
                        $('#status').val(b);
                        $("#delModal").modal('show');
                    });
                }


                $(function() {
                    $("#dateFrom").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                    $("#dateTo").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                });

                $(document).ready(function() {
                    $('#mytable').DataTable();
                });
            </script>


        @stop
