@extends('layouts.layout')
@section('pageTitle')
    Budget Appropriation
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
                            <label class="control-label">Account Type</label>
                            <input type="text" class="col-sm-9 form-control" id="economicGroup" name="economicGroup"
                                readonly="">



                        </div>

                        <div class="form-group" style="margin: 0 12px;">
                            <label class="control-label">Economic Head</label>
                            <input type="text" class="col-sm-9 form-control" id="economicHead" name="economicHead"
                                readonly="">



                        </div>

                        <div class="form-group" style="margin: 0 12px;">
                            <label class="control-label">Economic Code</label>
                            <input type="text" class="col-sm-9 form-control" id="economicCode" name="economicCode"
                                readonly="">


                        </div>


                        <div class="form-group" style="margin: 0 12px;">
                            <label class="control-label">Appropriation (&#x20A6)</label>
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
                                        <label class="control-label">Period</label>
                                        <select name="period" class="form-control" onchange="ReloadForm()" required>
                                            <option Value="">Select Year</option>
                                            @for ($i = 2024; $i < 2035; $i++)
                                                <option value="{{ $i }}" {{ $period == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <input type="hidden" name="allocationType" value="5">



                                    <div class="col-md-2">
                                        <label class="control-label">Account Type</label>
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

                                    <div class="col-md-4">
                                        <label class="control-label">Economic Head</label>
                                        <select class="form-control" id="economicHead" name="economicHead"
                                            onchange="ReloadForm()" required="">
                                            <option value="">Choose One</option>
                                            @foreach ($EconomicHead as $list)
                                                <option value="{{ $list->ID }}"
                                                    {{ $economicHead == $list->ID ? 'selected' : '' }}>
                                                    {{ $list->economicHead }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="control-label">Economic Code</label>
                                        <select class="form-control" id="economicCode" name="economicCode"
                                            required="">
                                            <option value="">Choose One</option>
                                            @foreach ($EconomicCode as $list)
                                                <option value="{{ $list->ID }}"
                                                    {{ $economicCode == $list->ID ? 'selected' : '' }}>
                                                    {{ $list->description }} - {{ $list->economicCode }} </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="col-md-2">
                                        <label class="control-label">Appropriation (&#x20A6)</label>
                                        <input type="text" class="form-control" id="budget" name="budget"
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

                                    <th> Account Type</th>
                                    <th> Economic Head</th>
                                    <th> Economic Code</th>

                                    <th> Budget</th>


                                    <th> Status</th>

                                    <th> Action</th>
                                </tr>
                            </thead>
                            @php $i=1;@endphp
                            @php $sum=0;@endphp


                            @foreach ($budget as $con)
                                @php $sum+=$con->allocationValue;@endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $con->contractType }}</td>
                                    <td>{{ $con->economicHead }}</td>
                                    <td>{{ $con->description }} | {{ $con->economicCode }}</td>
                                    <td>&#x20A6 {{ number_format($con->allocationValue, 2) }}</td>



                                    <td>

                                        @php
                                            if ($con->AllocationStatus == 1) {
                                                echo "<h4 class='btn-success'> Approved</h4>";
                                            } elseif ($con->AllocationStatus == 0) {
                                                echo "<h4 class='btn-warning'> Pending</h4>";
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary fa fa-edit"
                                            onclick="editfunc('{{ $con->Period }}', '{{ $con->allocation }}', '{{ $con->contractType }}', '{{ $con->description }}', '{{ $con->allocationValue }}','{{ $con->economicHead }}', '{{ $con->b_id }}' )"
                                            class="" id=""> Edit</button>
                                        <button type="button" class="btn btn-danger fa fa-times"
                                            onclick="delfunc('{{ $con->b_id }}','{{ $con->AllocationStatus }}')"></button>
                                    </td>
                            @endforeach
                            </tr>
                            <tr>
                                <td colspan=4></td>
                                <td>{{ number_format($sum, 2) }}</td>
                                <td colspan=4></td>
                            </tr>
                        </table>
                        <div>
                            <div class="hidden-print">{{ $budget->links() }}</div>
                            Showing {{ ($budget->currentpage() - 1) * $budget->perpage() + 1 }}
                            to {{ $budget->currentpage() * $budget->perpage() }}
                            of {{ $budget->total() }} entries
                        </div>
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
        </script>

        // ...existing code...
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

            // --- Added: live formatting for budget inputs + strip commas on submit ---
            (function() {
                // Format a numeric string with thousand separators, preserve decimals
                function formatWithCommas(value) {
                    if (!value) return value;
                    value = value.replace(/,/g, '');
                    var parts = value.split('.');
                    parts[0] = parts[0].replace(/\D/g, ''); // remove non-digits from integer part
                    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    if (parts.length > 1) {
                        // limit to 2 decimal places (adjust if you want different)
                        parts[1] = parts[1].replace(/\D/g, '').slice(0, 2);
                        return parts[0] + '.' + parts[1];
                    }
                    return parts[0];
                }

                // Attach input listener to all budget inputs (by name)
                function attachBudgetFormatting() {
                    var inputs = document.querySelectorAll('input[name="budget"]');
                    inputs.forEach(function(inp) {
                        // format initial value if any
                        inp.value = formatWithCommas(inp.value);

                        inp.addEventListener('input', function(e) {
                            var pos = inp.selectionStart;
                            var oldLength = inp.value.length;
                            inp.value = formatWithCommas(inp.value);
                            // Attempt to keep caret near the end (simpler and reliable)
                            var newLength = inp.value.length;
                            var newPos = pos + (newLength - oldLength);
                            try {
                                inp.setSelectionRange(newPos, newPos);
                            } catch (ex) {}
                        });
                    });
                }

                // On submit, strip commas so server receives plain numeric value
                function stripCommasOnSubmit() {
                    var forms = document.querySelectorAll('form#thisform1, form#editBModal');
                    forms.forEach(function(frm) {
                        frm.addEventListener('submit', function() {
                            var inputs = frm.querySelectorAll('input[name="budget"]');
                            inputs.forEach(function(i) {
                                i.value = i.value.replace(/,/g, '');
                            });
                        });
                    });
                }

                // init on DOM ready
                document.addEventListener('DOMContentLoaded', function() {
                    attachBudgetFormatting();
                    stripCommasOnSubmit();
                });
            })();
        </script>

    @stop
