@extends('layouts.layout')
@section('pageTitle')
    Assign Ability For Salary Processing
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
                    @if (session('error_message'))
                        <div class="alert alert-error alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span> </button>
                            <strong>Error!</strong> {{ session('error_message') }}
                        </div>
                    @endif
                    <form method="post" action="{{ url('/assign-ability') }}" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Select User Role</label>
                            <div class="col-md-9">
                                <select name="user" class="select_picker form-control" data-live-search="true"
                                    id="role">
                                    <option value="">Select One</option>

                                    @foreach ($users as $list)
                                        <option value="{{ $list->roleID }}">{{ $list->rolename }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Select Role</label>
                            <div class="col-sm-offset-3 col-md-9">
                                <input type="checkbox" name="can_submit_salary" value="1"> Can Submit salary
                            </div>
                            <div class="col-sm-offset-3 col-md-9">
                                <input type="checkbox" name="can_authorize_salary" value="1"> Can Authorize to checking
                            </div>
                            <div class="col-sm-offset-3 col-md-9">
                                <input type="checkbox" name="can_check" value="1"> Can Check
                            </div>
                            <div class="col-sm-offset-3 col-md-9">
                                <input type="checkbox" name="can_audit" value="1"> Can Audit
                            </div>
                            <div class="col-sm-offset-3 col-md-9">
                                <input type="checkbox" name="can_cpo" value="1"> Cpo action
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success btn-sm pull-right">ASSIGN ABILITY</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="page-wrapper" class="box box-default">
        <div class="box-body">
            <h4 class="text-center">ASSIGNED ABILITIES FOR SALARY PROCESSING</h4>
            {{-- <div class="col-md-12">
                <form method="post" action="{{ url('/user/display') }}">
                    {{ csrf_field() }}
                    <div class="col-md-9" style="padding: 0px">
                        <input type="text" id="autocomplete" name="q" class="form-control"
                            placeholder="Search User">
                        <input type="hidden" id="nameID" name="nameID">
                    </div>
                    <div class="col-md-1" style="padding: 0px">
                        <button type="submit" class="btn btn-success">Search User</button>
                    </div>
                </form>
            </div> --}}
            <div style="clear: both;"></div>
            <div class="row" style="margin-top: 25px;">
                <div class="col-md-12">
                    <table class="table table-striped table-condensed table-bordered input-sm" id="userRoles">
                        <thead>
                            <tr class="input-sm">
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Can Submit salary</th>
                                <th>Can Authorize</th>
                                <th>Can Check</th>
                                <th>Can Audit</th>
                                <th>Cpo action</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php $key = 1; @endphp
                            @foreach ($assignedFunctions as $list)
                                <tr id="tr">
                                    <td>{{ $key++ }}</td>
                                    <td>{{ strtoupper($list->rolename) }}</td>
                                    <td>
                                        @if ($list->can_submit_salary == 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td>
                                        @if ($list->can_authorize_salary == 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td>
                                        @if ($list->can_check == 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td>
                                        @if ($list->can_audit == 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td>
                                        @if ($list->can_cpo == 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <a href="#" title="Edit" class="btn btn-success btn-sm fa fa-edit"></a> --}}
                                        <button title="Edit" type="button" class="btn btn-primary btn-sm fa fa-edit" data-target="#editModal{{$list->roleID}}" data-toggle="modal">
                                        </button>
                                    </td>
                                </tr>
                                <div id="editModal{{$list->roleID}}" class="modal fade">
                                    <div class="modal-dialog box box-default" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Update User Ability for {{$list->rolename}} </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="form-horizontal" action="{{url('/update-assign-ability')}}" role="form" method="POST">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                            
                                                    {{-- <div class="form-group" style="margin: 0 10px;">
                                                        <label class="control-label">ID</label>
                                                        <input type="hidden" class="col-sm-9 form-control" name="user" value="{{$list->roleID}}">
                                                    </div> --}}
                                                    <input type="hidden" class="col-sm-9 form-control" name="user" value="{{$list->roleID}}">
                                                    <div class="form-group mt-2">
                                                        <label for="section" class="col-md-3 control-label">Select Role</label>
                                                        <div class="col-md-9">
                                                            <input type="checkbox" name="can_submit_salary" @php if($list->can_submit_salary == 1) echo "checked"; else echo " "; @endphp value="1"> Can Submit salary
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="checkbox" name="can_authorize_salary" @php if($list->can_authorize_salary == 1) echo "checked"; else echo " "; @endphp value="1"> Can Authorize to checking
                                                        </div>
                                                        <div class="col-sm-offset-3 col-md-9">
                                                            <input type="checkbox" name="can_check" @php if($list->can_check == 1) echo "checked"; else echo " "; @endphp value="1"> Can Check
                                                        </div>
                                                        <div class="col-sm-offset-3 col-md-9">
                                                            <input type="checkbox" name="can_audit" @php if($list->can_audit == 1) echo "checked"; else echo " "; @endphp value="1"> Can Audit
                                                        </div>
                                                        <div class="col-sm-offset-3 col-md-9">
                                                            <input type="checkbox" name="can_cpo" @php if($list->can_cpo == 1) echo "checked"; else echo " "; @endphp value="1"> Cpo action
                                                        </div>
                                                    </div>
                            
                                                    <div class="modal-footer">
                                                        <input type="hidden" id="id" name="id">
                                                        <button type="submit" name="edit" class="btn btn-success">Save changes</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                            
                            
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="hidden-print">{{ $assignedFunctions->links() }}</div>
                </div>
            </div>
            <!-- /.col -->

        </div>
    @endsection

    @section('scripts')
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <!-- autocomplete js-->
        <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
        <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">
    @endsection
    <script type="text/javascript">
        $('.select_picker').selectpicker({
            style: 'btn-default',
            size: 4
        });

        $(function() {
            $("#autocomplete").autocomplete({
                serviceUrl: murl + '/user/search',
                minLength: 2,
                onSelect: function(suggestion) {

                    $('#nameID').val(suggestion.data);

                    //showAll();
                    //alert(suggestion.data);
                    var v = suggestion.data;

                    $.ajax({


                        type: 'post',
                        url: murl + '/user/display',
                        data: {
                            'nameID': v,
                            '_token': $('input[name=_token]').val()
                        },

                        success: function(datas) {
                            // $.each(datas, function(index, obj){
                            alert(ok);


                            //$("#userRoles").append(tr);
                            //});
                        }

                    });


                }
            });
        });
    </script>
    <script>
        function editfunc(id,can_submit,can_authorize,can_check,can_audit,can_cpo)
        {
        $(document).ready(function(){
            $('#id').val(id);
            $('#can_submit').val(can_submit);
            // $('#email').val(email);
            // $('#role').val(roleID);
            // $('#status').val(status);
            // $('#division').val(division);
            // $('#global').val(global);
            //  $('#id').val(id);
            $("#editModal").modal('show');
         });
        }
    
        
    </script>
@endsection
