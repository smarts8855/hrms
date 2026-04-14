@extends('layouts.layout')
@section('pageTitle')
    Invalid Control Variable

@endsection



@section('content')



    <div class="box box-default">
        <div id="editModal" class="modal fade">
            <div class="modal-dialog box box-default" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Particular</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" id="editpartModal" name="editpartModal" role="form" method="POST"
                        action="{{ url('/control-variable/update') }}">
                        {{ csrf_field() }}
                        <div class="modal-body">

                            <div class="form-group" style="margin: 0 10px;">
                                <div class="col-sm-12">
                                    <label class="col-sm-2 control-label">Description</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea rows="4" cols="50" id="e-desc" name="descriptions"></textarea>
                                </div>
                                {{-- <div class="col-sm-12">
                                    <label class="col-sm-4 control-label">Bank</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="e-bank" class="form-control" name="bank">
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-sm-4 control-label">Account Name</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="e-aname" class="form-control" name="account_name">
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-sm-4 control-label">Account Number</label>
                                </div> --}}
                                {{-- <div class="col-sm-9">
                                    <input type="text" id="e-anumber" class="form-control" name="account_number">
                                </div> --}}
                                <div class="col-sm-3 ">
                                    <select class="form-control" id="e-status" name="partStatus">
                                        <option value='0'>Inactive</option>
                                        <option value='1'>Active</option>
                                    </select>
                                </div>
                                <div class="col-sm-3" style="font-size: 12px; padding:5px;">
                                    <select class="form-control" name="rank" id="e-rank">

                                        @for ($i = 1; $i <= 50; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <input type="hidden" id="partid" name="partid" value="">
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

        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <!--1st col-->
                        @include('funds.Share.message')

                        <form class="form-horizontal" role="form" method="post" id="mainform" name="mainform">
                            {{ csrf_field() }}
                            
                            <!-- /.row -->
                            <div class="form-group">
                                <div class="col-md-10">
                                    <label class="control-label">Division</label>
                                    @if (Auth::user()->is_global == 1)
                                        <select class="form-control" id="particulars" name="division"
                                            onchange="TextBoxState();">
                                            <option value="">-select division</option>
                                            @foreach ($division as $list)
                                                <option value="{{ $list->divisionID }}">{{ $list->division }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control" id="particulars" name="division"
                                            onchange="TextBoxState();">
                                            @foreach ($staffdivision as $list)
                                                <option value="{{ $list->divisionID }}">{{ $list->division }}
                                                </option>
                                            @endforeach
                                        </select>

                                    @endif

                                </div>




                                <div class="col-md-1 control-label ">
                                    <br>
                                    <button type="submit" class="btn btn-success" name="add">
                                        <i class="fa fa-btn fa-floppy-o"></i> Display
                                    </button>
                                </div>
                            </div>

                    </div>


                    </form>

                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table id="mytable" class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">


                                    <th>S/N</th>
                                    <th>Names</th>
                                    <th>Description</th>
                                    <th>Division</th>

                                </tr>
                            </thead>
                            @php $i=1;@endphp
                            @foreach ($staff as $list)
                                @php
                                    if ($list->status == 0) {
                                        $astatus = 'Inactive';
                                    } else {
                                        $astatus = 'active';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $list->surname }}, {{ $list->first_name }} {{ $list->othernames }}</td>
                                    <td>{{ $list->description }}</td>
                                    <td>{{ $list->division }}</td>

                                    {{--                                     
                                    <td>
                                        <a style="color: blue; cursor: pointer;"
                                            onclick="editfunc('{{ $list->ID }}','{{ $list->description }}', '{{ $list->status }}', '{{ $list->rank }}')"
                                            class="editCV">Edit</a>
                                    </td>
                                    <td>
                                        <a  style="color: rgb(231, 82, 12); cursor: pointer;"
                                        data-toggle="modal"
                                                        data-target="#deleteModal{{ $list->ID }}"
                                            class="editCV">Delete</a>
                                    </td> --}}

                                </tr>
                                <div class="modal fade" id="deleteModal{{ $list->ID }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="form">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLongTitle">Delete</h4>
                                                <form method="post"
                                                    action="/control-variable/delete/{{ $list->ID }}">
                                                    {{ csrf_field() }}


                                            </div>

                                            <input type="text" hidden name="id" id=""
                                                value="{{ $list->ID }}">
                                            <div class="modal-body">
                                                <h3> Do you want to delete {{ $list->description }} ?</h3>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" name="delete"
                                                    class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </table>

                    </div>

                    <hr />
                </div>

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
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script>
        function editfunc(id, desc, status, rank) {
            document.getElementById('partid').value = id
            document.getElementById('e-desc').value = desc
            // document.getElementById('e-bank').value = bank
            // document.getElementById('e-aname').value = accname
            // document.getElementById('e-anumber').value = accnum
            document.getElementById('e-status').value = status
            document.getElementById('e-rank').value = rank
            $("#editModal").modal('show');
        }
        function deletefunc(id, desc, status, rank) {
            // document.getElementById('id').value = id
            // document.getElementById('desc').value = desc
            // document.getElementById('status').value = status
            // document.getElementById('e-rank').value = rank
            $("#deleteModal").modal('show');
        }
        function TextBoxState() {
            var p = document.getElementById("particulars").value;
            if (p == "2") {
                document.getElementById('accounthead').setAttribute('disabled', 'disabled');
                document.getElementById('allocationtype').setAttribute('disabled', 'disabled');
                document.getElementById('economiccode').setAttribute('disabled', 'disabled');
            }
            if (p == "1") {
                document.getElementById('accounthead').removeAttribute('disabled');
                document.getElementById('allocationtype').removeAttribute('disabled');
                document.getElementById('economiccode').removeAttribute('disabled');
            }
            return;
        }
        function Reload() {
            document.forms["mainform"].submit();
            return;
        }
    </script>
@stop