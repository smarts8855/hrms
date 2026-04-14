@extends('layouts.layout')
@section('pageTitle')
    Monthly allocation by vote
@endsection
@section('content')
    

    <div id="editModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Monthly Allocation </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="editBModal" name="editBModal" role="form" method="POST"
                    action="{{ url('allocation/monthly') }}">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">

                            <h4>Are you sure you want to approve this item?</h4>
                            <input type="hidden" class="col-sm-9 form-control" id="UpdateID" name="U_id">

                        </div>


                        <div class="modal-footer">
                            <button type="Submit" name="newinsert" class="btn btn-success">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="uneditModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Monthly Allocation </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="editBModal" name="editBModal" role="form" method="POST"
                    action="{{ url('allocation/monthly') }}">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">

                            <h4>Are you sure you want to disapprove this record?</h4>
                            <input type="hidden" class="col-sm-9 form-control" id="UpdateID" name="U_id">

                        </div>


                        <div class="modal-footer">
                            <button type="Submit" name="disapprove" class="btn btn-success">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="updateModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Monthly Allocation </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="editBModal" name="editBModal" role="form" method="POST"
                        action="{{ url('allocation/monthly') }}">
                        {{ csrf_field() }}


                        <div class="form-group" style="margin: 0 10px;">
                            <label class="control-label">Enter Amount</label>
                            <input type="hidden" class="col-sm-9 form-control" id="amount" name="oldamount">
                            <input type="text" class="col-sm-9 form-control" id="amounty" name="amount">
                            <input type="hidden" class="col-sm-9 form-control" id="E_id" name="E_id">
                            <input type="hidden" class="col-sm-9 form-control" id="budgetID" name="budgetID">

                        </div>


                        <div class="modal-footer">
                            <button type="Submit" name="update" class="btn btn-success">Save changes</button>
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
                <div class="modal-body">
                    <form class="form-horizontal" id="editLgaModal" name="editLgaModal" role="form" method="POST"
                        action="{{ url('allocation/monthly') }}">
                        {{ csrf_field() }}

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
                            action="{{ url('allocation/monthly') }}">
                            {{ csrf_field() }}

                            <div class="col-md-12"><!--2nd col-->
                                <!-- /.row -->
                                <div class="form-group">

                                    <div class="col-md-2">
                                        <label class="control-label">Period</label>
                                        <select name="year" class="form-control" id="year"
                                            onchange="ReloadForm()" required>
                                            <option Value="">Select Year</option>
                                            @for ($i = 2024; $i < 2035; $i++)
                                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>


                                    <div class="col-md-2">
                                        <label class="control-label">{{ $month }}Month</label>
                                        <select class="form-control" id="month" name="month"
                                            onchange="ReloadForm()" required="">
                                            <option value=""> Choose One</option>
                                            <option value="January" {{ $month == 'January' ? 'selected' : '' }}> January
                                            </option>
                                            <option value="February" {{ $month == 'February' ? 'selected' : '' }}>
                                                February</option>
                                            <option value="March" {{ $month == 'March' ? 'selected' : '' }}> March
                                            </option>
                                            <option value="April" {{ $month == 'April' ? 'selected' : '' }}> April
                                            </option>
                                            <option value="May" {{ $month == 'May' ? 'selected' : '' }}> May</option>
                                            <option value="June" {{ $month == 'June' ? 'selected' : '' }}> June</option>
                                            <option value="July" {{ $month == 'July' ? 'selected' : '' }}> July</option>
                                            <option value="August" {{ $month == 'August' ? 'selected' : '' }}> August
                                            </option>
                                            <option value="September" {{ $month == 'September' ? 'selected' : '' }}>
                                                September</option>
                                            <option value="October" {{ $month == 'October' ? 'selected' : '' }}> October
                                            </option>
                                            <option value="November" {{ $month == 'November' ? 'selected' : '' }}>
                                                November</option>
                                            <option value="December" {{ $month == 'December' ? 'selected' : '' }}>
                                                December</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Budget Type</label>
                                        <select name="budgettype" id="budgettype" class="form-control"
                                            onchange ="ReloadForm();">
                                            <option value="" selected>-All-</option>
                                            @foreach ($BudgetType as $b)
                                                <option value="{{ $b->ID }}"
                                                    {{ $budgettype == $b->ID ? 'selected' : '' }}>{{ $b->contractType }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Economics Vote</label>
                                        <select class="form-control" id="single" name="single"
                                            onchange="ReloadForm()">
                                            <option value=""> All</option>
                                            @foreach ($BudgetSingle as $list)
                                                <option value="{{ $list->b_id }}"
                                                    {{ $single == $list->b_id ? 'selected' : '' }}>
                                                    {{ $list->economicCode }} - {{ $list->description }} </option>
                                            @endforeach
                                        </select>
                                    </div>




                                </div>
                            </div>
                            <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table class="table table-bordered table-striped table-highlight">
                            <form method="post" id="form2" name="form2">
                                {{ csrf_field() }}
                                <div class="col-md-6"></div>
                                {{-- <div class="col-md-6 ">
                                    <div class="col-md-0 pull-right" style="margin:2px;">
                                        
                                        <button class="btn btn-success " type="submit" id="" value=""
                                            name="insert"> Approve <i class="fa fa-check"></i> </button>
                                        <button class="btn btn-success " type="submit" id="" value=""
                                            name="uninsert"> Reverse <i class="fa fa-check"></i> </button>
                                    </div>
                                    <div class="col-md-0 checkbox pull-right" style="margin:2px;">
                                        <label class="text-primary" for="check-all">
                                            <input type="checkbox" class="checkitem" id="toggle" value="select"
                                                onClick="do_this()">CheckAll
                                        </label>
                                    </div>


                                </div> --}}



                                <div class="row" style="margin:2px;">
                                   
                                    <div class="col-md-6">

                                        <button class="btn btn-success" type="button" onclick="printTable()">
                                            Print All <i class="fa fa-print"></i>
                                        </button>
                                    </div>

                                    <iframe id="printFrame" style="display: none;"></iframe>
                                    <div class="col-md-6 text-right">
                                        <button class="btn btn-success" type="submit" name="insert">
                                            Approve <i class="fa fa-check"></i>
                                        </button>
                                        <button class="btn btn-success" type="submit" name="uninsert">
                                            Reverse <i class="fa fa-check"></i>
                                        </button>
                                        <div class="checkbox pull-right" style="margin:2px;">
                                            <label class="text-primary">
                                                <input type="checkbox" id="toggle" value="select"
                                                    onclick="do_this()">
                                                Check All
                                            </label>
                                        </div>

                                    </div>

                                </div>


                                <thead>
                                    <tr bgcolor="#c7c7c7">


                                        <th>S/N</th>
                                        <th> Year</th>
                                        <th> Month</th>
                                        <th> Economic Code</th>
                                        <th> Status</th>
                                        <th> Total Budget</th>
                                        <th> Total Alloted<br> Janauary to {{ $month }}</th>
                                        <th> Total Alloted<br> this year</th>
                                        <th> Total Pending <br> this year</th>
                                        <th> Allocation this Month</th>

                                        <th> Action</th>
                                    </tr>
                                </thead>
                                @php $i=1;@endphp
                                @php $tval=0;@endphp
                                @php $tbt=0;@endphp
                                @php $taltd=0;@endphp
                                @php $taltdm=0;@endphp
                                @php $tpending=0;@endphp


                                @foreach ($budget as $con)
                                    @php $tval+=$con->amount;@endphp
                                    @php $tbt+=$con->allocationValue;@endphp
                                    @php $taltd+=$con->thisyearalloted;@endphp
                                    @php $taltdm+=$con->allotedtodate;@endphp
                                    @php $tpending+=$con->allocationValue-$con->thisyearalloted;@endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $con->year }}</td>
                                        <td>{{ $con->month }}</td>
                                        <td>{{ $con->economicCode }} - {{ $con->description }} </td>
                                        <td>

                                            @if ($con->stat == 1)
                                                <b><span class="text-success">Approved</span></b>
                                            @else($con->stat == 0)
                                                <b><span class="text-danger">Pending</span></b>
                                            @endif

                                        </td>
                                        <td style ="text-align: right">&#x20A6
                                            {{ number_format($con->allocationValue, 2) }}</td>
                                        <td style ="text-align: right">&#x20A6 {{ number_format($con->allotedtodate, 2) }}
                                        </td>
                                        <td style ="text-align: right">&#x20A6
                                            {{ number_format($con->thisyearalloted, 2) }}</td>
                                        <td style ="text-align: right">&#x20A6
                                            {{ number_format($con->allocationValue - $con->thisyearalloted, 2) }}</td>
                                        <td style ="text-align: right">&#x20A6
                                            {{ is_numeric($con->amount) ? number_format($con->amount, 2) : '0000' }}

                                            <button style="align:right;" type="button" class="btn btn-info fa fa-edit"
                                                onclick="updatefunc( '{{ $con->mID }}','{{ $con->amount }}','{{ $con->amount }}','{{ $con->budgetID }}')"
                                                class="" id=""></button>


                                        </td>

                                        <td>
                                            @if ($con->stat == 0)
                                                <input type="checkbox" name="checkbox[]" value="{{ $con->mID }}">
                                                <button type="button" class="btn btn-success fa fa-edit"
                                                    onclick="editfunc('{{ $con->mID }}' )" class=""
                                                    id=""> Approve</button>
                                            @else
                                                <input type="checkbox" name="checkbox[]" value="{{ $con->mID }}">
                                                <button type="button" class="btn btn-success fa fa-edit"
                                                    onclick="Uneditfunc('{{ $con->mID }}' )" class=""
                                                    id=""> Reverse</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan=5>Total this month</td>
                                    <td><b>{{ number_format($tbt, 2) }}</b></td>
                                    <td><b>{{ number_format($taltdm, 2) }}</b></td>
                                    <td><b>{{ number_format($taltd, 2) }}</b></td>
                                    <td><b>{{ number_format($tpending, 2) }}</b></td>
                                    <td><b>{{ number_format($tval, 2) }}</b></td>
                                     <td></td>
                                </tr>
                        </table>
                        </form>

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
            function do_this() {

                var checkboxes = document.getElementsByName('checkbox[]');
                var button = document.getElementById('toggle');

                if (button.value == 'select') {
                    for (var i in checkboxes) {
                        checkboxes[i].checked = 'FALSE';
                    }
                    button.value = 'deselect'
                } else {
                    for (var i in checkboxes) {
                        checkboxes[i].checked = '';
                    }
                    button.value = 'select';
                }
            }


            function ReloadForm() {
                document.getElementById('thisform1').submit();
                return;
            }

            function ReloadForm2() {
                document.getElementById('editBModal').submit();
                return;
            }

            function editfunc(a) {
                $(document).ready(function() {
                    $('#UpdateID').val(a);
                    $("#editModal").modal('show');
                });
            }

            function Uneditfunc(a) {
                $(document).ready(function() {
                    $('#UpdateID').val(a);
                    $("#uneditModal").modal('show');
                });
            }

            function updatefunc(a, b, c, d) {
                $(document).ready(function() {
                    $('#E_id').val(a);
                    $('#amount').val(b);
                    $('#amounty').val(c);
                    $('#budgetID').val(d);
                    $("#updateModal").modal('show');
                });
            }

            function delfunc(a, b) {
                $(document).ready(function() {
                    $('#conID').val(a);
                    $('#status').val(b);
                    $("#delModal").modal('show');
                });
            }


            window.onload = function() {
                var selItem = sessionStorage.getItem("SelItem");
                $('#periody').val(selItem);
            }
            $('#periody').change(function() {
                var selVal = $(this).val();
                sessionStorage.setItem("SelItem", selVal);
            });

            
            function printTable() {
                var table = document.querySelector('.table.table-bordered');
                var clone = table.cloneNode(true);
           
                var headerRow = clone.querySelector('thead tr');
                if (headerRow && headerRow.children.length > 0) {
                    headerRow.removeChild(headerRow.lastElementChild);
                }
                
                clone.querySelectorAll('tbody tr').forEach(row => {
                    if (row.children.length > 0) {
                        row.removeChild(row.lastElementChild);
                    }
                });
                
                clone.querySelectorAll('button, .btn').forEach(btn => btn.remove());
                
                var printFrame = document.getElementById('printFrame');
                var frameDoc = printFrame.contentWindow.document;
                
                frameDoc.open();
                frameDoc.write(`
                    <html>
                        <head>
                            <title>Budget Allocation Report</title>
                            <style>
                                body { 
                                    font-family: Arial; 
                                    padding: 20px; 
                                    margin: 0;
                                }
                                .print-container {
                                    width: 100%;
                                }
                                .report-title {
                                    text-align: center;
                                    font-size: 18px;
                                    font-weight: bold;
                                    margin-bottom: 10px;
                                }
                                .print-date {
                                    text-align: right;
                                    margin-bottom: 20px;
                                    font-size: 12px;
                                    color: #666;
                                }
                                table { 
                                    border-collapse: collapse; 
                                    width: 100%; 
                                    font-size: 12px;
                                    margin-top: 10px;
                                }
                                th, td { 
                                    border: 1px solid #000; 
                                    padding: 6px 8px; 
                                }
                                th { 
                                    background-color: #f2f2f2; 
                                    text-align: center;
                                    font-weight: bold;
                                }
                                .text-right { 
                                    text-align: right; 
                                }
                                .total { 
                                    font-weight: bold; 
                                    background-color: #e0e0e0; 
                                }
                                td:nth-child(6),
                                td:nth-child(7),
                                td:nth-child(8),
                                td:nth-child(9),
                                td:nth-child(10) {
                                    text-align: right;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="print-container">
                                <div class="report-title">BUDGET ALLOCATION REPORT</div>
                                <div class="print-date">Printed on: ${new Date().toLocaleDateString()}</div>
                                ${clone.outerHTML}
                            </div>
                        </body>
                    </html>
                `);
                frameDoc.close();
       
                setTimeout(function() {
                    var frameDoc = printFrame.contentWindow.document;
                    var frameTable = frameDoc.querySelector('table');
                    if (frameTable) {
                        var rows = frameTable.querySelectorAll('tr');
                        if (rows.length > 0) {
                            rows[rows.length - 1].className = 'total';
                        }
                       
                        var allRows = frameTable.querySelectorAll('tr');
                        allRows.forEach(function(row) {
                            var cells = row.children;
                            for (var i = 5; i <= 9; i++) {
                                if (cells[i]) {
                                    cells[i].classList.add('text-right');
                                }
                            }
                        });
                    }
                    
                    printFrame.contentWindow.focus();
                    printFrame.contentWindow.print();
                }, 100);
            }

        </script>



    @stop
