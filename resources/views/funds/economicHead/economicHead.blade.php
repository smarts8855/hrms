@extends('layouts.layout')
@section('pageTitle')
    Economic Head
@endsection
@section('content')

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>

            <div class="box box-success">
                <div class="box-body">
                    @include('funds.Share.message')
                    <form class="form-horizontal" role="form" id="thisform1" name="thisform1" method="post"
                        action="{{ url('economic-head/create') }}">
                        {{ csrf_field() }}

                        <div class="col-md-3">
                            <label class="control-label">Economic Group</label>
                            <select class="form-control" id="economicGroup" name="economicGroup" required="">
                                <option value="">Choose One</option>
                                @foreach ($EconomicGroup as $list)
                                    <option value="{{ $list->ID }}" {{ $economicGroup == $list->ID ? 'selected' : '' }}>
                                        {{ $list->contractType }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder=""
                                required="">

                        </div>

                        <div class="col-md-4">
                            <label class="control-label"> Description</label>
                            <textarea type="text" class="form-control" id="economicHead" name="economicHead" placeholder="" rows="1"></textarea>

                        </div>



                        <div class="col-md-2">
                            <label class="control-label" style="visibility: hidden">Add</label>
                            <button type="submit" class="btn btn-success" name="add" style="width: 100%">
                                <i class="fa fa-btn fa-floppy-o"></i> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ========================= TABLE CARD ========================= -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title text-uppercase">Economic Head List</h4>
                </div>

                <div class="box-body">

                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">


                                    <th>S/N</th>
                                    <th> Economic Group</th>
                                    <th> Economic Head</th>
                                    <th> Code</th>
                                    <th> Status</th>

                                    <th> Action</th>
                                </tr>
                            </thead>
                            @php $i=1;@endphp

                            @foreach ($EconomicHead as $con)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $con->contractType }}</td>
                                    <td>{{ $con->economicHead }} </td>
                                    <td> {{ $con->Code }}</td>
                                    <td>
                                        @if ($con->Status == 1)
                                            <span class="label label-success">Active </span>
                                        @else
                                            <span class="label label-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="editfunc('{{ $con->contractTypeID }}','{{ $con->economicHead }}','{{ $con->Status }}','{{ $con->HeadID }}','{{ $con->Code }}')">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>

                                        <a style="cursor: pointer;" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ route('economicHead.destroy', ['id' => $con->HeadID]) }}')">
                                            <i class="glyphicon glyphicon-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div>
                            <div class="hidden-print">{{ $EconomicHead->links() }}</div>
                            Showing {{ ($EconomicHead->currentpage() - 1) * $EconomicHead->perpage() + 1 }}
                            to {{ $EconomicHead->currentpage() * $EconomicHead->perpage() }}
                            of {{ $EconomicHead->total() }} entries
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>





    <div>
        <div id="editModal" class="modal fade">
            <div class="modal-dialog box box-default" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Economic Head Details </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" id="editBModal" name="editBModal" role="form" method="POST"
                        action="{{ url('economic-head/create') }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group" style="margin: 0 12px;">
                                <label class="control-label">Period</label>
                                <select name="economicGroup" id="economicGroup1" class="form-control">
                                    <option value=''>-Select Bank-</option>
                                    @foreach ($EconomicGroup as $b)
                                        <option value="{{ $b->ID }}">{{ $b->contractType }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin: 0 12px;">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" id="economicHead1" name="economicHead" required></textarea>
                                <input type="hidden" id="EcoID" name="EcoID">
                            </div>


                            <div class="form-group" style="margin: 0 12px;">
                                <label class="control-label">Code </label>
                                <input type="text" class="col-sm-9 form-control" id="EcoCode" name="EcoCode">
                            </div>

                            <div class="form-group" style="margin: 0 10px;">
                                <label class="control-label">Status</label>
                                <select class="form-control" id="status" name="status" required="">
                                    <option value="">-select Status-</option>
                                    <option value="1"> Active</option>
                                    <option value="0"> Suspended</option>
                                </select>
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
        function editfunc(a, b, c, d, e) {
            console.log(b);

            // No need for $(document).ready() inside a function
            $('#economicGroup1').val(a);
            $('#editModal').on('shown.bs.modal', function() {
                $('#economicHead1').val(b);
            });
            // $('#economicHead').val(b);
            $('#status').val(c);
            $('#EcoID').val(d);
            $('#EcoCode').val(e);

            // Now show the modal
            $('#editModal').modal('show');
        }
    </script>


    <script>
        function ReloadForm() {
            document.getElementById('thisform1').submit();
            return;
        }

        function ReloadForm2() {
            document.getElementById('editBModal').submit();
            return;
        }

        function delfunc(a) {
            $(document).ready(function() {
                $('#conID').val(a);
                $("#delModal").modal('show');
            });
        }
    </script>



@stop
