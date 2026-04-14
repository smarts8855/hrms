@extends('layouts.layout')
@section('pageTitle')
    Staff Control Variable Approval
@endsection

@section('content')

    <div id="editModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Approve Control Variable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="editpartModal" name="editpartModal" role="form" method="POST"
                    action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-12 control-label"><b>Are you sure you want to approve staff control variable modification?</b></label>
                            </div>
                            <input type="hidden" id="editStaffCv" name="editStaffCv" value="">
                            <input type="hidden" id="amount" name="amount" value="">
                            <input type="hidden" id="remark" name="remark" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Variable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-9 control-label"><b>Are you sure you want to delete this
                                        record?</b></label>
                            </div>
                            <input type="hidden" id="deleteid" name="deleteid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
                <span class="pull-right"> <span class="badge badge-lg bg-red">{{$pending}}</span> Pending Approval </span>
            </div>

            {{-- <div class="col-md-12">
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
            </div> --}}


            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        @include('payroll.Share.message')

                        <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                            <table class="table table-bordered table-striped table-highlight">
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                        <th>S/N</th>
                                        <th>CV Description</th>
                                        <th>Staff</th>
                                        <th>Division</th>
                                        <th>Old Amount</th>
                                        <th>New Amount</th>
                                        <th>Requested By</th>
                                        <th>Reason</th>
                                        {{-- <th>Target Amount</th>
                                        <th>Target Balance</th>
                                        <th>With Limit</th>
                                        <th>Last processed</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @php $i = 1; @endphp
                                <tbody>

                                    @foreach ($staffCvTemp as $list)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $list->description }}</td>
                                            <td>{{ $list->surname . ' ' . $list->first_name . ' ' . $list->othernames }}
                                            </td>
                                            <td>{{ $list->division }}</td>
                                            <td>{{ $list->oldAmount }}</td>
                                            <td>{{ $list->newAmount }}</td>
                                            <td>{{ $list->requesterName }}</td>
                                            <td>{{ $list->remark }}</td>
                                            {{-- <td>{{ number_format($list->amount, 2, '.', ',') }}</td>
                                            <td>
                                                @if ($list->targetAmount != '' && $list->recycling == 0)
                                                    {{ number_format($list->targetAmount, 2, '.', ',') }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </td> --}}
                                            {{-- <td>
                                                @if ($list->targetAmount != '' && $list->recycling == 0)
                                                    {{ number_format($list->targetAmount - $list->totaloffset, 2, '.', ',') }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </td>
                                            <td>
                                                @if ($list->recycling == 1)
                                                    No
                                                @else
                                                    yes
                                                @endif
                                            </td>
                                            <td>
                                                @if ($list->lastperiod != '')
                                                    {{ $list->lastperiod }}
                                                @else
                                                    Not yet processed
                                                @endif
                                            </td> --}}
                                            <td>
                                                @if ($list->approvedBy == null)
                                                    <button class="btn btn-sm btn-primary" style="cursor: pointer;"
                                                        onclick="editfunc('{{ $list->tblstaffcvId }}', '{{ $list->newAmount }}', '{{ $list->remark }}')">Approve</button>
                                                @else
                                                    <span class="text-success"><strong><i>Approved By:</i></strong></span>
                                                    {{ $list->approvalName }}
                                                @endif

                                                @if ($list->approvedBy == null)
                                                    <button class="btn btn-sm btn-danger" style="cursor: pointer;"
                                                        onclick="deletefunc('{{ $list->id }}')">Delete</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="hidden-print">{{ $staffCvTemp->links() }}</div>
                        </div>

                        <hr />
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
            <script>
                function editfunc(x, y, z) {
                    document.getElementById('editStaffCv').value = x;
                    document.getElementById('amount').value = y;
                    document.getElementById('remark').value = z;
                    $("#editModal").modal('show')
                }

                function deletefunc(x, y, a) {
                    document.getElementById('deleteid').value = x;
                    $("#DeleteModal").modal('show');
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

                function Reload() {
                    document.forms["mainform"].submit();
                    return;
                }

                function StaffSearchReload() {
                    document.getElementById('fileNo').value = document.getElementById('userSearch').value;
                    document.forms["mainform"].submit();
                    return;
                }
            </script>

        @stop
