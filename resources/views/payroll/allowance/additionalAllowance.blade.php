@extends('layouts.layout')
@section('pageTitle')
    Additional Allowance
@endsection



@section('content')





    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>




            <div class="box-body">


                <div class="row">
                    <div class="col-md-12">


                        <div class="panel panel-default"
                            style="margin: 18px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                            <div class="panel-heading"
                                style="background-color:#f5f5f5; font-weight:bold; font-size:16px; padding:12px 20px;">

                            </div>

                            <div class="panel-body" style="padding: 20px 25px;">
                                <form class="form-horizontal" id="mainform" name="mainform" role="form" method="post"
                                    action="/save-otherAllowance">
                                    {{ csrf_field() }}

                                    <!-- First Row -->
                                    <div class="row" style="margin-bottom:20px;">
                                        <div class="col-md-4">
                                            <div class="form-group" style="margin-right:10px;">
                                                <label class="control-label">Deduction</label>
                                                <select required name="deductionID" class="form-control" id="cvtype">
                                                    <option value="">- Select Deduction -</option>
                                                    @foreach ($EarningDeductionType as $desc)
                                                        <option value="{{ $desc->ID }}">{{ $desc->description }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group" style="margin-right:10px;">
                                                <label class="control-label">Amount</label>
                                                <input required type="number" step="0.01" value="{{ $amount }}"
                                                    name="amount" id="amount" class="form-control"
                                                    placeholder="e.g 11000" onkeyup="TargetRevalidate()">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" class="form-control" id="divisionName" name="name"
                                                    placeholder="Enter name">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Second Row -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group" style="margin-right:10px;">
                                                <label class="control-label">Date</label>
                                                <input required type="date" value="{{ $amount }}" name="date"
                                                    id="date" class="form-control" onkeyup="TargetRevalidate()">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group" style="margin-right:10px;">
                                                <label class="control-label">Remark</label>
                                                <input required type="text" value="{{ $tamount }}" name="remark"
                                                    class="form-control" placeholder="Remark" id="tamount">
                                            </div>
                                        </div>

                                        <div class="col-md-4 text-center">
                                            <div class="form-group" style="margin-top:30px;">
                                                <button type="submit" class="btn btn-success btn-block" name="add">
                                                    <i class="fa fa-floppy-o"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



                <hr />
                <div class="row">
                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">


                                    <th>S/N</th>
                                    <th>StaffName</th>
                                    <th>Earnings</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Remark</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            @php $i = 1;  @endphp
                            <tbody>

                                @foreach ($tablecontent as $list)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $list->name }} </td>
                                        <td>{{ $list->description }} </td>
                                        <td>{{ number_format($list->amount, 2, '.', ',') }}</td>
                                        <td>{{ $list->date }} </td>
                                        <td>{{ $list->remark }} </td>
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
                                                    method="POST" action="/delete-otherAllowance">
                                                    {{ csrf_field() }}
                                                    <div class="modal-body">
                                                        <div class="form-group" style="margin: 0 10px;">
                                                            <div class="col-sm-12">
                                                                <label class="col-sm-9 control-label"><b>Are you sure
                                                                        you want to delete
                                                                        {{ $list->name }}?</b></label>
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
                                                    role="form" method="POST" action="/edit-otherAllowance">
                                                    {{ csrf_field() }}
                                                    <div class="modal-body">
                                                        <div class="form-group" style="margin: 0 10px;">
                                                            <div class="col-sm-12">
                                                                <label class="col-sm-2 control-label">Name</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input type="text" value=" {{ $list->name }}"
                                                                    name="name" class="form-control">
                                                                <input type="hidden" value=" {{ $list->id }}"
                                                                    name="id" class="form-control">
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <label class="col-sm-2 control-label">Deduction</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input type="text" value=" {{ $list->earning_ID }}"
                                                                    name="deductionID" class="form-control">
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <label class="col-sm-2 control-label">Date</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input type="date" value="{{ $list->date }}"
                                                                    name="date" class="form-control">
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <label class="col-sm-2 control-label">Amount</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input type="text" value=" {{ $list->amount }}"
                                                                    name="amount" class="form-control">
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <label class="col-sm-2 control-label">Remark</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input type="text" value=" {{ $list->remark }}"
                                                                    name="remark" class="form-control">
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
            <!-- SweetAlert2 -->
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

            <script>
                @if (session('success'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#f0f9eb',
                        iconColor: '#28a745',
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: '{{ session('error') }}',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#fdecea',
                        iconColor: '#dc3545',
                    });
                @endif
            </script>





        @stop
