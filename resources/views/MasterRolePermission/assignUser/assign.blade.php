@extends('layouts.layout')
@section('pageTitle')
    ASSIGN USER
@endsection

@section('content')
    <div id="page-wrapper" class="box box-default">
        <div class="container-fluid">
            <div class="col-md-12 text-success"><!--2nd col-->
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
                    <form method="post" action="{{ url('/user-assign/assign') }}" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Select User</label>
                            <div class="col-md-9">
                                <select name="user" class="select_picker form-control" data-live-search="true"
                                    id="role">
                                    <option value="">Select One</option>

                                    @foreach ($users as $list)
                                        <option value="{{ $list->id }}">{{ $list->name }}({{ $list->username }})
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Select Role</label>
                            <div class="col-md-9">
                                <select name="role" class="form-control" id="role">
                                    <option value="">Select One</option>

                                    @foreach ($roles as $list)
                                        <option value="{{ $list->roleID }}">{{ $list->rolename }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success btn-sm pull-right">ASSIGN USER</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="page-wrapper" class="box box-default">
        <div class="box-body">
            <h2 class="text-center">ASSIGNED USERS</h2>
            <div class="col-md-12">
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
            </div>
            <div style="clear: both;"></div>
            <div class="row" style="margin-top: 25px;">
                <div class="col-md-12">
                    <table class="table table-striped table-condensed table-bordered input-sm" id="userRoles">
                        <thead>
                            <tr class="input-sm">
                                <th>S/N</th>
                                <th> NAME</th>
                                <th> Role</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php $key = 1; @endphp
                            @foreach ($userroles as $list)
                                <tr id="tr">
                                    <td>{{ $key++ }}</td>
                                    <td>{{ strtoupper($list->name) }}</td>
                                    <td>{{ strtoupper($list->rolename) }}</td>
                                    <td>{{ $list->created_at }}</td>
                                    <!--<td><a href="{{ url('/user-assign/edit/' . $list->assignuserID) }}" title="Edit" class="btn btn-success fa fa-edit"></a></td>-->
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="hidden-print">{{ $userroles->links() }}</div>
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
@endsection
