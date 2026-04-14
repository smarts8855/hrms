@extends('layouts.layout')
@section('pageTitle')
    Allocation Recieves
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

            </div>


            <div class="box-body">
                <div class="row">


                    <div class="col-md-12">
                        <div class="panel panel-default" style="box-shadow:0 2px 6px rgba(0,0,0,.1);border-radius:6px;">
                            <div class="panel-heading" style="background:#f5f5f5;border-bottom:1px solid #ddd;">
                                <h4 class="panel-title" style="margin:0;font-weight:bold">Allocation</h4>
                            </div>

                            <div class="panel-body" style="padding:22px;">
                                <form class="form-horizontal" method="post" action="/save-allocation">
                                    {{ csrf_field() }}

                                    <!-- First Row -->
                                    <div class="row" style="margin-bottom:25px;">
                                        <div class="col-md-4" style="padding-right:20px;">
                                            <div class="form-group">
                                                <label>Division</label>
                                                <select name="division" required class="form-control input-sm">
                                                    <option value="">-select division-</option>
                                                    @foreach ($division as $desc)
                                                        <option value="{{ $desc->divisionID }}">{{ $desc->division }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="padding-right:20px;">
                                            <div class="form-group">
                                                <label>Year</label>
                                                <select name="year" class="form-control input-sm">
                                                    <option value="">Select Year</option>
                                                    @for ($i = 2025; $i <= 2040; $i++)
                                                        <option value="{{ $i }}"
                                                            @if (old('year') == $i) selected @endif>
                                                            {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Month</label>
                                                <select name="month" class="form-control input-sm">
                                                    <option value="">Select Month</option>
                                                    @foreach (['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'] as $m)
                                                        <option value="{{ $m }}"
                                                            @if (old('month') == $m) selected @endif>
                                                            {{ ucfirst(strtolower($m)) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Second Row -->
                                    <div class="row">
                                        <div class="col-md-4" style="padding-right:20px;">
                                            <div class="form-group">
                                                <label>Amount</label>
                                                <input type="number" step="0.01" name="amount" id="amount" required
                                                    class="form-control input-sm" placeholder="e.g 11000">
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="padding-right:20px;">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input type="date" name="date" required class="form-control input-sm">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group" style="margin-top:25px;">
                                                <button type="submit" class="btn btn-success btn-sm btn-block">
                                                    <i class="fa fa-floppy-o"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>








                    <hr />

                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">


                                    <th>S/N</th>
                                    <th>Division</th>
                                    <th>year</th>
                                    <th>month</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            @php
                                $i = 1;
                                $j = 1;
                            @endphp
                            <tbody>

                                @foreach ($allocation as $list)
                                    <tr>
                                        <td>{{ $j++ }}</td>
                                        <td>{{ $list->division }} </td>
                                        <td>{{ $list->year }} </td>
                                        <td>{{ $list->month }} </td>
                                        <td>{{ number_format($list->amount, 2, '.', ',') }}</td>
                                        <td>{{ $list->date }} </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" style="cursor: pointer;"
                                                onclick="editfunc({{ $i }})">Edit</button>

                                            <button class="btn btn-sm btn-danger" style="cursor: pointer;"
                                                onclick="deletefunc('{{ $i }}')">Delete</button>
                                        </td>
                                    </tr>
                                    <div id="DeleteModal{{ $i }}" class="modal fade">
                                        <div class="modal-dialog box box-default" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete Additional Allowance</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form class="form-horizontal" id="deletevariableModal" role="form"
                                                    method="POST" action="/delete-allocation">
                                                    {{ csrf_field() }}
                                                    <div class="modal-body">
                                                        <div class="form-group" style="margin: 0 10px;">
                                                            <div class="col-sm-12">
                                                                <label class="col-sm-9 control-label"><b>Are you sure
                                                                        you want to delete ths record ?</b></label>
                                                            </div>
                                                            <input type="hidden" value=" {{ $list->id }}"
                                                                name="id" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="Submit" class="btn btn-success">Yes</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">No</button>
                                                    </div>

                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="editModal{{ $i }}" class="modal fade">
                                        <div class="modal-dialog box box-default" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Variable</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form class="form-horizontal" id="editpartModal" name="editpartModal"
                                                    role="form" method="POST" action="/edit-allocation">
                                                    {{ csrf_field() }}
                                                    <div class="modal-body">
                                                        <div class="form-group" style="margin: 0 10px;">
                                                            <div class="col-sm-12">
                                                                <label class="col-sm-2 control-label">Division</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <select name="division" class="form-control">
                                                                    <option value="{{ $list->divisionID }}">
                                                                        {{ $list->division }}</option>
                                                                    @foreach ($division as $desc)
                                                                        <option value="{{ $desc->divisionID }}">
                                                                            {{ $desc->division }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" value=" {{ $list->id }}"
                                                                    name="id" class="form-control">
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <label class="col-sm-2 control-label">year</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <select name="year" id="section"
                                                                    class="form-control">
                                                                    <option value="{{ $list->year }}">
                                                                        {{ $list->year }}</option>
                                                                    @for ($i = 2011; $i <= 2040; $i++)
                                                                        <option value="{{ $i }}"
                                                                            @if (old('year') == $i) selected @endif>
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label> Select a Month </label>
                                                                    <select name="month" id="section"
                                                                        class="form-control">
                                                                        <option value="{{ $list->month }}">
                                                                            {{ $list->month }}</option>
                                                                        <option value="JANUARY"
                                                                            @if (old('month') == 'JANUARY') selected @endif>
                                                                            January</option>
                                                                        <option value="FEBRUARY"
                                                                            @if (old('month') == 'FEBRUARY') selected @endif>
                                                                            February</option>
                                                                        <option value="MARCH"
                                                                            @if (old('month') == 'MARCH') selected @endif>
                                                                            March</option>
                                                                        <option value="APRIL"
                                                                            @if (old('month') == 'APRIL') selected @endif>
                                                                            April</option>
                                                                        <option value="MAY"
                                                                            @if (old('month') == 'MAY') selected @endif>
                                                                            May</option>
                                                                        <option value="JUNE"
                                                                            @if (old('month') == 'JUNE') selected @endif>
                                                                            June</option>
                                                                        <option value="JULY"
                                                                            @if (old('month') == 'JULY') selected @endif>
                                                                            July</option>
                                                                        <option value="AUGUST"
                                                                            @if (old('month') == 'AUGUST') selected @endif>
                                                                            August</option>
                                                                        <option value="SEPTEMBER"
                                                                            @if (old('month') == 'SEPTEMBER') selected @endif>
                                                                            September</option>
                                                                        <option value="OCTOBER"
                                                                            @if (old('month') == 'OCTOBER') selected @endif>
                                                                            October</option>
                                                                        <option value="NOVEMBER"
                                                                            @if (old('month') == 'NOVEMBER') selected @endif>
                                                                            November</option>
                                                                        <option value="DECEMBER"
                                                                            @if (old('month') == 'DECEMBER') selected @endif>
                                                                            December</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <label class="col-sm-2 control-label">Date</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input type="date" required
                                                                    value="{{ $list->date }}" name="date"
                                                                    class="form-control">
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <label class="col-sm-2 control-label">Amount</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input type="text" value=" {{ $list->amount }}"
                                                                    name="amount" class="form-control">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="Submit" class="btn btn-success">Save
                                                            changes</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>

                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>



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
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                function editfunc(i) {


                    $("#editModal" + i).modal('show')
                }

                function deletefunc(i) {

                    $("#DeleteModal" + i).modal('show');
                }

                function getDivisions() {
                    document.getElementById('fileNo').value = "";
                    if ($('#court').val() !== "") {
                        $('#form1').submit();
                    }
                }

                function getStaff() {
                    document.forms["mainform"].submit();
                }

                function getTable() {
                    if ($('#fileNo').val() !== "") {
                        $('#form1').submit();
                    }
                }

                function checkForm() {
                    var court = $('#court').val();
                    division = $('#division').val();
                    fileno = $('#fileNo').val();
                    fname = $('#fname').val();
                    oname = $('#oname').val();
                    sname = $('#sname').val();
                    desc = $('#cvdesc').val();
                    amount = $('#amount').val();
                    if (court == "") {
                        alert('You have empty fields!');
                    } else {
                        if (division == "") {
                            alert('You have empty fields');
                        } else {
                            if (fileno == "") {
                                alert('you have empty fields!');
                            } else {
                                if (fname == "") {
                                    alert('you have empty fields!');
                                } else {
                                    if (oname == "") {
                                        alert('you have empty fields');
                                    } else {
                                        if (sname == "") {
                                            alert('you have empty fields!');
                                        } else {
                                            if (desc == "") {
                                                alert('you have empty fields!');
                                            } else {
                                                if (amount == "") {
                                                    alert('you have empty fields!');
                                                } else {
                                                    $('#form1').submit();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return false;
                }

                function Reload() {
                    document.forms["mainform"].submit();
                    return;
                }

                function StaffSearchReload() {
                    document.getElementById('fileNo').value = document.getElementById('userSearch').value;
                    document.forms["mainform"].submit();
                    return;
                }

                function ClickLimit() {
                    if (document.getElementById('hiddenlimit').value == 1) {

                        document.getElementById('tamount').removeAttribute('disabled');
                        document.getElementById('hiddenlimit').value = 0;
                    } else {
                        document.getElementById('tamount').setAttribute('disabled', 'disabled');
                        document.getElementById('hiddenlimit').value = 1;
                        //document.getElementById('recycle').setAttribute('disabled', 'disabled').off('click');
                        for (div of document.getElementById('recycle')) {
                            let children = div.children;
                            for (child of children) {
                                child.disabled = true;
                            }
                        }
                    }
                    return;
                }

                function ClickRecycle() {
                    if (document.getElementById('hiddenrecycle').value == 1) {
                        document.getElementById('hiddenrecycle').value = 0;
                    } else {
                        document.getElementById('hiddenrecycle').value = 1;
                        document.getElementById('tamount').value = document.getElementById('amount').value;
                    }
                    return;
                }

                function TargetRevalidate() {
                    if (document.getElementById('hiddenrecycle').value == 1) {
                        document.getElementById('tamount').value = document.getElementById('amount').value;
                    }

                    return;
                }
            </script>

            <script>
                // SweetAlert Toast Setup
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end', // you can change to 'center'
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                @if (session('saved'))
                    Toast.fire({
                        icon: 'success',
                        title: '{{ session('saved') }}'
                    });
                @endif

                @if (session('success'))
                    Toast.fire({
                        icon: 'info',
                        title: '{{ session('success') }}'
                    });
                @endif

                @if (session('deleted'))
                    Toast.fire({
                        icon: 'warning',
                        title: '{{ session('deleted') }}'
                    });
                @endif

                @if (session('error'))
                    Toast.fire({
                        icon: 'error',
                        title: '{{ session('error') }}'
                    });
                @endif
            </script>




            {{-- ///////////////////////////////////// --}}

            <script type="text/javascript">
                $(document).ready(function() {
                    // alert('danger')
                    $('select[name="division"]').on('change', function() {
                        var division_id = $(this).val();
                        // alert(division_id)

                        if (division_id) {
                            $.ajax({
                                url: "{{ url('/division/staff/ajax') }}/" + division_id,
                                type: "GET",
                                dataType: "json",
                                success: function(data) {

                                    var d = $('datalist[name="userSearch"]').html('');
                                    $.each(data, function(key, value) {
                                        $('datalist[name="userSearch"]').append(
                                            `<option value=${value.ID}>
                                ${value.fileNo} : ${value.surname}  ${value.first_name}  ${value.othernames}  </option>`
                                        );
                                    });
                                }
                            });
                        } else {
                            alert('danger')
                        }
                    }); // end sub category
                });
            </script>
            {{-- ///////////////////////////////////// --}}
        @stop
