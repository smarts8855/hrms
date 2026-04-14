@extends('layouts.layout')
@section('pageTitle')
    Budget Allocation
@endsection
@section('content')


    <div id="editModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Budget Details </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="editBModal" name="editBModal" role="form" method="POST"
                    action="{{ url('allocation') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 12px;">
                            <label class="control-label">Period</label>
                            <input type="text" class="col-sm-9 form-control" id="period" name="period"
                                readonly="">



                        </div>

                        <div class="form-group" style="margin: 0 12px;">
                            <label class="control-label">Allocation Type</label>
                            <input type="text" class="col-sm-9 form-control" id="allocationType" name="allocationType"
                                readonly="">



                        </div>

                        <div class="form-group" style="margin: 0 12px;">
                            <label class="control-label">Economic Group</label>
                            <input type="text" class="col-sm-9 form-control" id="economicGroup" name="economicGroup"
                                readonly="">



                        </div>



                        <div class="form-group" style="margin: 0 12px;">
                            <label class="control-label">Economic Code</label>
                            <input type="text" class="col-sm-9 form-control" id="economicCode" name="economicCode"
                                readonly="">


                        </div>


                        <div class="form-group" style="margin: 0 12px;">
                            <label class="control-label">Budget (&#x20A6)</label>
                            <input type="text" class="col-sm-9 form-control" id="budget" name="budget"
                                required="">
                            <input type="hidden" class="col-sm-9 form-control" id="B_id" name="B_id">


                        </div>


                        <div class="modal-footer">
                            <button type="Submit" name="edit" class="btn btn-success">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>

                </form>
            </div>

        </div>
    </div>
    </div>


    <div id="delModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Contractor</h4>

                </div>
                <form class="form-horizontal" id="editLgaModal" name="editLgaModal" role="form" method="POST"
                    action="{{ url('allocation') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">

                            <h4>Are you sure you want to delete this item?</h4>
                            <input type="hidden" class="col-sm-9 form-control" id="conID" name="B_id">
                            <input type="hidden" class="col-sm-9 form-control" id="status" name="status">

                        </div>
                        <div class="modal-footer">
                            <button type="Submit" name="delete" class="btn btn-success">Continue ?</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>

                </form>
            </div>

        </div>
    </div>
    </div>


    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
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

                        <form class="form-horizontal" role="form" id="thisform1" name="thisform1" method="post"
                            action="{{ url('allocation') }}">
                            {{ csrf_field() }}

                            <div class="col-md-12"><!--2nd col-->
                                <!-- /.row -->
                                <div class="form-group">


                                    <div class="col-md-2">
                                        <label class="control-label">Contract Type</label>
                                        <select class="form-control" id="economicGroup" name="economicGroup"
                                            onchange="ReloadForm()" required="">
                                            <option value="">Choose One</option>
                                            @foreach ($EconomicGroup as $list)
                                                <option value="{{ $list->ID }}"
                                                    {{ $economicGroup == $list->ID ? 'selected' : '' }}>
                                                    {{ $list->contractType }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-2">
                                        <label class="control-label"> Description</label>
                                        <input type="text" class="form-control" id="economicHead" name="economicHead"
                                            placeholder="" required="">

                                    </div>



                                    <div class="col-md-2">
                                        <br>
                                        <label class="control-label"></label>
                                        <button type="submit" class="btn btn-success" name="add">
                                            <i class="fa fa-btn fa-floppy-o"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    </form>

                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">


                                    <th>S/N</th>
                                    <th> Economic Group</th>
                                    <th> Economic Head</th>
                                    <th> Status</th>

                                    <th> Action</th>
                                </tr>
                            </thead>
                            @php $i=1;@endphp

                            @foreach ($EconomicHead as $con)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $con->contractType }}</td>
                                    <td>{{ $con->economicHead }}</td>

                                    <td>

                                        @php
                                            if ($con->EcoHeadstatus == 1) {
                                                echo "<h4 class='btn-success'> Approved</h4>";
                                            } elseif ($con->EcoHeadstatus == 0) {
                                                echo "<h4 class='btn-warning'> Pending</h4>";
                                            }
                                        @endphp



                                    <td>
                                        <button type="button" class="btn btn-primary fa fa-edit" onclick="editfunc( )"
                                            class="" id=""> Edit</button>
                                        <button type="button" class="btn btn-danger fa fa-times"
                                            onclick="delfunc()"></button>
                                    </td>
                            @endforeach
                            </tr>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <script>
            function ReloadForm() {
                document.getElementById('thisform1').submit();
                return;
            }

            function ReloadForm2() {
                document.getElementById('editBModal').submit();
                return;
            }

            function editfunc(a, b, c, d, e, f) {
                $(document).ready(function() {
                    $('#period').val(a);
                    $('#allocationType').val(b);
                    $('#economicGroup').val(c);
                    $('#economicCode').val(d);
                    $('#budget').val(e);
                    $('#B_id').val(f);
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
        </script>



    @stop
