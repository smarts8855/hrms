@extends('layouts.layout')
@section('pageTitle')
    Insert Economic Code
@endsection



@section('content')
    <div>
        <div id="editModal" class="modal fade">
            <div class="modal-dialog box box-default" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Economic Code</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" id="editECModal" name="editECModal" role="form" method="POST"
                        action="{{ url('/economic-code/update') }}">
                        {{ csrf_field() }}
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="control-label">Economic Code</label>
                                    <input type="text" class="form-control" id="economicCodeChange" name="economicCode">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Suffix</label>
                                    <input type="text" class="form-control" id="suffixChange" name="suffix">
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Status</label>
                                    <select class="form-control" id="ecStatus" name="ecStatus">
                                        <option value='0'>Inactive</option>
                                        <option value='1'>Active</option>
                                    </select>
                                </div>

                                <input type="hidden" id="economicCodeId" name="economicCodeId" value="">
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Economic Description</label>
                                    <input type="text" class="form-control" id="economicDescriptionChange"
                                        name="economicDescription">
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
    </div>

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print text-uppercase">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>
            <div class="box box-success">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12"><!--1st col-->
                            @include('funds.Share.message')
                            <form class="form-horizontal" role="form" method="post"
                                action="{{ url('/economic-code/save') }}">
                                {{ csrf_field() }}
                                <div class="col-md-4">
                                    <label class="control-label">Allocation</label>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Contract Group</label>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Economic Head</label>
                                </div>

                                <div class="col-md-4">
                                    <select class="form-control" id="allocationId" name="allocationId">
                                        <option value=''>Select</option>
                                        @foreach ($allocationtype as $list)
                                            <option value="{{ $list->ID }}"
                                                {{ $getallocationId == $list->ID ? 'selected' : '' }}>
                                                {{ $list->allocation }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="contractGroupId" name="contractGroupId">
                                        <option value=''>Select</option>
                                        @foreach ($contracttype as $list)
                                            <option value="{{ $list->ID }}"
                                                {{ $getcontractGroupId == $list->ID ? 'selected' : '' }}>
                                                {{ $list->contractType }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="employeeHeadId" name="employeeHeadId">
                                        <option value=''>Select</option>
                                        @foreach ($EconHead as $list)
                                            <option value="{{ $list->ID }}">{{ $list->economicHead }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Economic Code</label>
                                    <input type="text" class="form-control" id="economicCode" name="economicCode">
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Suffix</label>
                                    <input type="text" class="form-control" id="suffix" name="suffix">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Economic Description</label>
                                    <input type="text" class="form-control" id="economicDescription"
                                        name="economicDescription">
                                </div>

                                <div class="col-md-4 mt-3">
                                    <br>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-btn fa-floppy-o"></i> Add
                                    </button>
                                </div>
                            </form>
                            <hr />
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================= TABLE CARD ========================= -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title text-uppercase">Economic Code List</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table id="mytable" class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">


                                    <th>S/N</th>
                                    <th>Allocation</th>
                                    <th>Contract Group</th>
                                    <th>Economic Head</th>
                                    <th>Economic Code</th>
                                    <th>Suffix</th>
                                    <th>Economic Description</th>
                                    <th>Status</th>
                                    {{-- <th>Edit</th>
                                    <th>Delete</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @php $i=1;@endphp
                            @foreach ($getEconCode as $list)
                                @php
                                    $astatus = $list->status == 0 ? 'Inactive' : 'Active';
                                @endphp

                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $list->allocation }}</td>
                                    <td>{{ $list->contractType }}</td>
                                    <td>{{ $list->economicHead }}</td>
                                    <td>{{ $list->economicCode }}</td>
                                    <td>{{ $list->suffix }}</td>
                                    <td>{{ $list->description }}</td>
                                    <td>
                                        @if ($list->status == 1)
                                            <span class="label label-success">Active </span>
                                        @else
                                            <span class="label label-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td style="width: 150px">
                                        <a style="cursor: pointer;" onclick="editfunc({{ json_encode([$list]) }})"
                                            class="btn btn-primary btn-sm">
                                            <i class="glyphicon glyphicon-edit"></i> Edit
                                        </a>
                                        <a style="cursor: pointer;" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ url('economic-code/' . $list->IDs) }}')">
                                            <i class="glyphicon glyphicon-trash"></i> Delete
                                        </a>
                                    </td>


                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>


        </div>
    </div>

    <form id="getAlloContract" method="post" action="{{ url('/economic-code') }}">
        {{ csrf_field() }}
        <input type="hidden" id="getAlloId" name="getAlloId" />
        <input type="hidden" id="getContractId" name="getContractId" />
    </form>
@endsection

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
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

    <script>
        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This record will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>

    <script>
        function editfunc(list) {
            $(document).ready(function() {
                $('#economicCodeId').val(list[0].IDs);
                $('#economicCodeChange').val(list[0].economicCode);
                $('#suffixChange').val(list[0].suffix);
                $('#economicDescriptionChange').val(list[0].description);
                $('#ecStatus').val(list[0].status);
                $("#editModal").modal('show');
            });
        }

        $('#allocationId').change(function() {
            $('#getAlloId').val($('#allocationId').val());
            $('#getContractId').val($('#contractGroupId').val());
            $('#getAlloContract').submit();
        });

        $('#contractGroupId').change(function() {
            $('#getAlloId').val($('#allocationId').val());
            $('#getContractId').val($('#contractGroupId').val());
            $('#getAlloContract').submit();
        });


        $(document).ready(function() {
            $('#mytable').DataTable({
                "pageLength": 100
            });
        });
    </script>
@endsection
