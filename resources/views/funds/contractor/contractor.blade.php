@extends('layouts.layout')
@section('pageTitle')
    Add New Contractor
@endsection

@section('content')

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>

            <div class="box box-success">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('funds.Share.message')
                            <form class="form-horizontal" role="form" method="post"
                                action="{{ url('contractor/create') }}">
                                {{ csrf_field() }}

                                <div class="col-md-12"><!--2nd col-->
                                    <!-- /.row -->
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Contractor</label>
                                            <input type="text" class="form-control" id="name" name="contractor"
                                                placeholder="" required="">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Phone</label>
                                            <input type="text" class="form-control" id="name" name="phone"
                                                placeholder="" required="">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Email</label>
                                            <input type="email" class="form-control" id="name" name="email"
                                                placeholder="Optional">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Address</label>
                                            <textarea type="text" class="form-control" id="name" name="address" placeholder="Optional"></textarea>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Bank</label>
                                            <select class="form-control" id="bank" name="bank" required="">
                                                <option value="">-select Bank-</option>
                                                @foreach ($banklist as $list)
                                                    <option value="{{ $list->bankID }}">{{ $list->bank }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Account Number</label>
                                            <input type="text" class="form-control" id="name" name="account"
                                                placeholder="" required="">
                                        </div>
                                        {{-- <div class="col-md-3">
                                            <label class="control-label">Sort Code</label>
                                            <input type="text" class="form-control" id="name" name="sortcode"
                                                placeholder="Optional">
                                        </div> --}}
                                        <div class="col-md-3">
                                            <label class="control-label">TIN</label>
                                            <input type="text" class="form-control" id="name" name="tin"
                                                placeholder="Optional">
                                        </div>



                                        <div class="col-md-3">
                                            <br>
                                            <button type="submit" class="btn btn-success" name="add">
                                                <i class="fa fa-btn fa-floppy-o"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================= TABLE CARD ========================= -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title text-uppercase">Contractor List</h4>
                </div>

                <div class="box-body">

                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    <th>S/N</th>
                                    <th>Contractor</th>
                                    <th> Phone</th>
                                    <th> Email</th>
                                    <th> Address</th>
                                    <th> Bank</th>
                                    <th> Account No</th>
                                    {{-- <th> Sort Code</th> --}}
                                    <th> TIN</th>
                                    <th> Status</th>
                                    <th> Action</th>
                                </tr>
                            </thead>
                            @php $i=1;@endphp

                            @foreach ($contractorList as $con)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $con->contractor }}</td>
                                    <td>{{ $con->phoneNo }}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 150px;">
                                        {{ $con->emailAddress }}
                                    </td>
                                    <td style="word-wrap: break-word; white-space: normal;">
                                        {{ $con->address }}
                                    </td>
                                    <td style="word-wrap: break-word; white-space: normal;">{{ $con->bank }}</td>
                                    <td>{{ $con->AccountNo }}</td>
                                    {{-- <td>{{ $con->sortCode }}</td> --}}
                                    <td>{{ $con->TIN }}</td>
                                    <td>
                                        @if ($con->isFromProcurement == 0)
                                            @if ($con->status == 1)
                                                <span class="label label-success">Active </span>
                                            @else
                                                <span class="label label-danger">Inactive</span>
                                            @endif
                                        @else
                                            <span class="label label-primary">Procurement </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($con->isFromProcurement == 0)
                                            <div style="white-space: nowrap;">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    {{-- onclick="editfunc('{{ $con->contractor }}', '{{ $con->phoneNo }}', '{{ $con->emailAddress }}','{{ $con->address }}','{{ $con->Banker }}','{{ $con->AccountNo }}','{{ $con->sortCode }}','{{ $con->TIN }}', '{{ $con->id }}', '{{ $con->status }}' )" --}}
                                                    onclick='editfunc(
                                                        @json($con->contractor),
                                                        @json($con->phoneNo),
                                                        @json($con->emailAddress),
                                                        @json($con->address),
                                                        @json($con->Banker),
                                                        @json($con->AccountNo),
                                                        @json($con->TIN),
                                                        @json($con->id),
                                                        @json($con->status),
                                                    )'
                                                    id=""> <i class="fa fa-edit"></i> Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="delfunc('{{ $con->id }}')"><i class="fa fa-trash"></i>
                                                    Delete</button>
                                            </div>
                                        @endif

                                    </td>
                            @endforeach
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div id="editModal" class="modal fade">
            <div class="modal-dialog box box-default modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Contractor Details </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" id="editLgaModal" name="editLgaModal" role="form" method="POST"
                        action="{{ url('contractor/create') }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6" style="">
                                    <label class="control-label">Contractor</label>
                                    <input type="text" class="form-control" id="contractor" name="contractor"
                                        required="">
                                </div>

                                <div class="col-md-6" style="">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>

                                <div class="col-md-6" style="">
                                    <label class="control-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>

                                <div class="col-md-6" style="">
                                    <label class="control-label">Bank</label>
                                    <select name="bank" id="bank1" class="form-control" required>
                                        <option value=''>-Select Bank-</option>
                                        @foreach ($banklist as $b)
                                            <option value="{{ $b->bankID }}">{{ $b->bank }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6" style="">
                                    <label class="control-label">Account</label>
                                    <input type="text" class="form-control" id="account" name="account"
                                        required="">
                                </div>

                                {{-- <div class="col-md-6" style="">
                                    <label class="control-label">SortCode</label>
                                    <input type="text" class="form-control" id="sortcode" name="sortcode">
                                </div> --}}

                                <div class="col-md-6" style="">
                                    <label class="control-label">TIN</label>
                                    <input type="text" class="form-control" id="tin" name="tin">
                                    <input type="hidden" class="form-control" id="C_id" name="C_id">
                                </div>

                                <div class="col-md-6" style="">
                                    <label class="control-label">Status</label>
                                    <select class="form-control" id="status" name="status" required="">
                                        <option value="">-select Status-</option>
                                        <option value="1"> Active</option>
                                        <option value="0"> Suspended-</option>
                                    </select>
                                </div>
                                <div class="col-md-6" style="">
                                    <label class="control-label">Address</label>
                                    <textarea class="form-control" type="text" name="address" id="address"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="Submit" name="edit" class="btn btn-success">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
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
                        action="{{ url('contractor/create') }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group" style="margin: 0 10px;">
                                <h4>Are you sure you want to delete this contractor?</h4>
                                <input type="hidden" class="form-control" id="conID" name="C_id">
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
    <script>
        function editfunc(a, b, c, d, e, f, h, i, j) {
            $(document).ready(function() {
                $('#contractor').val(a);
                $('#phone').val(b);
                $('#email').val(c);
                $('#address').val(d);
                $('#bank1').val(e);
                $('#account').val(f);
                $('#tin').val(h);
                $('#C_id').val(i);
                $('#status').val(j);
                $("#editModal").modal('show');
            });
        }

        // function editfunc(a, b, c, d, e, f, g, h, i, j) {
        //     $(document).ready(function() {
        //         $('#contractor').val(a);
        //         $('#phone').val(b);
        //         $('#email').val(c);
        //         $('#address').val(d);
        //         $('#bank1').val(e);
        //         $('#account').val(f);
        //         $('#sortcode').val(g);
        //         $('#tin').val(h);
        //         $('#C_id').val(i);
        //         $('#status').val(j);
        //         $("#editModal").modal('show');
        //     });
        // }

        function delfunc(a) {
            $(document).ready(function() {
                $('#conID').val(a);
                $("#delModal").modal('show');
            });
        }
    </script>

    </script>

@stop
