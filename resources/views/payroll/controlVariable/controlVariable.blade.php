@extends('layouts.layout')
@section('pageTitle')
    Control Variable Set-up

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
                                    <label class="control-label">Description</label>
                                </div>
                                <div class="col-sm-12">
                                    <textarea rows="1" class="form-control" cols="50" id="e-desc" name="descriptions"></textarea>
                                </div>
                                <div class="col-sm-12">
                                    <label class="control-label">Address</label>
                                </div>
                                <div class="col-sm-12">
                                    <textarea rows="2" class="form-control" cols="50" id="e-addr" name="address"></textarea>
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
                                <div class="col-sm-12">
                                    <label class="control-label">Status</label>
                                </div>
                                <div class="col-sm-12">
                                    <select class="form-control" id="e-status" name="partStatus">
                                        <option value='0'>Inactive</option>
                                        <option value='1'>Active</option>
                                    </select>
                                </div>

                                <div class="col-sm-12">
                                    <label class="control-label">Rank</label>
                                </div>
                                <div class="col-sm-12">
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
                            @php
                                $dbtstatus = 'disabled';
                                if ($particulars == 1) {
                                    $dbtstatus = '';
                                }
                            @endphp
                            <!-- /.row -->
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label class="control-label">Earning/Deduction</label>
                                    <select class="form-control" id="particulars" name="particulars"
                                        onchange="TextBoxState();">
                                        <option value="">-select Particular</option>
                                        @foreach ($getep as $list)
                                            <option value="{{ $list->ID }}"
                                                {{ $particulars == $list->ID ? 'selected' : '' }}>{{ $list->Particular }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="control-label">Description</label>
                                    <input type="text" class="form-control" name="description" placeholder=""
                                        value='{{ $description }}'>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" name="address" placeholder=""
                                        value='{{ $address }}'>
                                </div>
                                {{-- <div class="col-md-4">
                                    <label class="control-label">Bank</label>
                                    <input type="text" class="form-control" id="bank" name="bank"
                                        placeholder="" value='{{ $bank }}'>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Account Name</label>
                                    <input type="text" class="form-control" id="account_name" name="account_name"
                                        placeholder="" value='{{ $account_name }}'>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Account Number</label>
                                    <input type="text" class="form-control" id="account_number" name="account_number"
                                        placeholder="" value='{{ $account_number }}'>
                                </div> --}}
                                <div class="col-md-6">
                                    <label class="control-label">Rank</label>
                                    <select class="form-control" id="rank" name="rank" onchange="TextBoxState();">
                                        <option value="">-select Rank--</option>
                                        @for ($i = 1; $i <= 50; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-12 control-label">
                                    <br>
                                    <button type="submit" class="btn btn-success" name="add">
                                        <i class="fa fa-btn fa-floppy-o"></i> Add
                                    </button>
                                </div>
                            </div>
                            {{-- <div class="form-group"> --}}
                            {{-- <div class="col-md-4">          
                                <label class="control-label">Account Head</label>
                                <select class="form-control" id="accounthead" name="accounthead" {{$dbtstatus}} onchange="Reload()">
                                <option value=""  >-Select Account Head-</option>
                                @foreach ($BudgetType as $list)
                                <option value="{{$list->ID}}" {{($accounthead==$list->ID||old('accounthead')==$list->ID)? "selected":""}} >{{$list->contractType}}</option>
                                @endforeach         
                                </select>
                            </div> --}}
                                            {{-- <div class="col-md-4">          
                                <label class="control-label">Allocation Type</label>
                                <select class="form-control" id="allocationtype" name="allocationtype" {{$dbtstatus}} onchange="Reload()">
                                <option value=""  >-Select Allocation Type-</option>
                                @foreach ($AllocationSource as $list)
                                <option value="{{$list->ID}}" {{($allocationtype==$list->ID||old('allocationtype')==$list->ID)? "selected":""}} >{{$list->allocation}}</option>
                                @endforeach         
                                </select>
                            </div>
                            {{-- <div class="col-md-4">           --}}
                                            {{-- <label class="control-label">Economic Code</label>
                                <select class="form-control" id="economiccode" name="economiccode" {{$dbtstatus}} >
                                <option value=""  >-Select Economic-</option>
                                @foreach ($EconomicCode as $list)
                                <option value="{{$list->ID}}" {{($economiccode==$list->ID||old('economiccode')==$list->ID)? "selected":""}} >{{$list->economicCode}}({{$list->description}})</option>
                                @endforeach         
                                </select>
                            </div> --}}


                            {{-- </div> --}}

                            <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    </form>

                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table id="mytable" class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">


                                    <th>S/N</th>
                                    <th>Earning/Deduction</th>
                                    <th>Description</th>
                                    <th>Address</th>
                                    {{-- <th>Bank</th>
                                    <th>Acc. Name</th>
                                    <th>Acc. Number</th> --}}
                                    <th>Ranks</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            @php $i=1;@endphp
                            @foreach ($getedj as $list)
                                @php
                                    if ($list->status == 0) {
                                        $astatus = 'Inactive';
                                    } else {
                                        $astatus = 'active';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $list->Particular }}</td>
                                    <td>{{ $list->description }}</td>
                                    <td>{{ $list->address }}</td>
                                    {{-- <td>{{ $list->bank }}</td>
                                    <td>{{ $list->account_name }}</td>
                                    <td>{{ $list->account_number }}</td> --}}
                                    <td>{{ $list->rank }}</td>
                                    <td>{{ $astatus }}</td>
                                    <td>
                                        <a style="color: blue; cursor: pointer;"
                                            onclick="editfunc('{{ $list->ID }}','{{ $list->description }}','{{ $list->address }}', '{{ $list->status }}', '{{ $list->rank }}')"
                                            class="editCV">Edit</a>
                                    </td>
                                    <td>
                                        <a style="color: rgb(231, 82, 12); cursor: pointer;" data-toggle="modal"
                                            data-target="#deleteModal{{ $list->ID }}" class="editCV">Delete</a>
                                    </td>

                                </tr>
                                <div class="modal fade" id="deleteModal{{ $list->ID }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        function editfunc(id, desc, addr, status, rank) {
            document.getElementById('partid').value = id
            document.getElementById('e-desc').value = desc
            document.getElementById('e-addr').value = addr
            // document.getElementById('e-bank').value = bank
            // document.getElementById('e-aname').value = accname
            // document.getElementById('e-anumber').value = accnum
            document.getElementById('e-status').value = status
            document.getElementById('e-rank').value = rank

            $("#editModal").modal('show');
        }

        function deletefunc(id, desc, addr, status, rank) {
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
