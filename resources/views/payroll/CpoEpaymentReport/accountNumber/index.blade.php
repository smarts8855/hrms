@extends('layouts.layout')
@section('pageTitle')
    Create Bank For Salary Payment
@endsection

@section('content')

    <div id="page-wrapper" class="box box-default">
        <div class="container-fluid">
            <div class="col-md-12 text-success">
                <!--2nd col-->
                <big><b>@yield('pageTitle')</b></big>
            </div>
            <br />
            <hr>
            <div class="row">
                <div class="col-md-9"> <br>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span> </button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span> </button>
                            <strong>Success!</strong> {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span> </button>
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                    @endif

                    <div id="editModal" class="modal fade">
                        <div class="modal-dialog box box-default" role="document">
                            <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Bank  </h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form class="form-horizontal" action="{{url('cpo-update-bank')}}" role="form" method="POST" >
                                {{ csrf_field() }}
                        <div class="modal-body">  
                            {{-- <div class="form-group" style="margin: 0 10px;">
                                <label class="control-label">Bank</label>
                                <input type="text" class="col-sm-9 form-control" id="bank" name="new_bank" required>
                            </div> --}}
                            <div class="form-group">
                                <label for="section" class="col-md-3 control-label">Bank</label>
                                <div class="col-md-9">
                                    <select name="new_bankID" id="bankID" class="form-control">
                                        <option value="">Select Bank</option>
                                        @foreach ($bankList as $b)
                                            <option value="{{ $b->bankID }}">{{ $b->bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" style="margin: 0 10px;">
                                <label class="control-label">Account No.</label>
                                <input type="text" class="col-sm-9 form-control" id="account_no" name="new_account_no" required>
                            </div>
                            
                            <div class="form-group" style="margin: 0 10px;">
                                <label class="control-label">Status</label>
                                <select name="new_status" id="status" class="form-control" required>
                                    <option value=''>-Select Status-</option>
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>
                            </div>

                            <div class="form-group" style="margin: 0 10px;">
                                <label for="section" class="control-label">Description</label>
                                <div class="">
                                    <select name="new_desc" id="new_desc" class="form-control">
                                        <option value="1">For Salary Payment</option>
                                        {{-- <option value="">--Select Description--</option>
                                        <option value="2">Is For Justice</option>
                                        <option value="1">Is For Staff</option> --}}
                                    </select>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <input type="hidden" id="id" name="id">
                                <button type="Submit" name="edit" class="btn btn-success">Save changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                         
                            
                        </div>
                          </form>
                              </div>
                        </div>
                    </div>


                    <form method="post" action="{{ url('cpo-create-bank') }}" class="form-horizontal">
                        {{ csrf_field() }}

                        {{-- <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Bank Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="bank" value="{{ old('bank') }}"
                                    required>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Bank</label>
                            <div class="col-md-9">
                                <select name="bankID" class="form-control">
                                    <option value="">Select Bank</option>
                                    @foreach ($bankList as $b)
                                        <option value="{{ $b->bankID }}">{{ $b->bank }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Account Number</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="accNumber" value="{{ old('accNumber') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Status</label>
                            <div class="col-md-9">
                                <select name="status" class="form-control">
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Description</label>
                            <div class="col-md-9">
                                <select name="desc" class="form-control" required>
                                    <option value="1">For Salary Payment</option>
                                    {{-- <option value="">--Select Description--</option> --}}
                                    {{-- <option value="2">Is For Justice</option> --}}
                                    {{-- <option value="1">Is For Staff</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success btn-sm pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="page-wrapper" class="box box-default">
        <div class="box-body">
            <h4 class="text-center">All Bank</h4>
            <div class="row"> {{ csrf_field() }}
                <div class="col-md-12">
                    <table class="table table-striped table-bordered input-sm">
                        <thead>
                            <tr class="input-sm">
                                <th>S/N</th>
                                <th>BANK</th>
                                <th>ACCOUNT NUMBER</th>
                                <th>STATUS</th>
                                <th>Description</th>
                                <th colspan="3">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $key = 0 @endphp
                            @foreach ($banks as $key => $b)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$b->bank}}</td>
                                    <td>{{$b->account_no}}</td>
                                    @if ($b->is_active == 1)
                                        <td><span class="btn btn-xs btn-success">Active</span></td>
                                    @else
                                        <td><span class="btn btn-xs btn-danger">Inactive</span></td>
                                    @endif
                                    <td>
                                        @if ($b->is_staff == 1)
                                            <span class="badge">For Salary Payment</span>
                                        @endif
                                        {{-- @if($b->is_staff == 2)
                                            <span class="badge">Is For Justice</span>
                                        @endif --}}
                                    </td>
                                    {{-- <td> <button type="button" class="btn btn-xs btn-success fa fa-edit" onclick="editfunc('{{$b->id}}', '{{$b->bankID}}', '{{$b->account_no}}', '{{$b->is_active}}' , '{{$b->is_staff}}')">Edit</button> </td> --}}
                                    <td> 
                                        <form action="{{url("/cpo-delete-bank/$b->id")}}" method="post">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-xs btn-danger">Delete</button> 
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <hr />

                </div>
            </div>
            <!-- /.col -->
        </div>
    @endsection

    @section('scripts')
    {{-- <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/js/jQuery-2.2.0.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <script>
        function editfunc(id, bank, account_no, active, is_staff)
        {
            console.log("hello");
            console.log(id,bank,account_no,active, is_staff);
            $(document).ready(function(){
                $('#bankID').val(bank);
                $('#account_no').val(account_no);
                $('#status').val(active);
                $('#new_desc').val(is_staff);
                $('#id').val(id);
                $("#editModal").modal('show');
            });
        }

    </script>
