@extends('layouts.layout')
@section('pageTitle')
    Add New Module
@endsection

<style type="text/css">
    .row {
        margin-bottom: 10px;
    }
</style>

@section('content')
    <div id="page-wrapper" class="box box-default">
        <div class="container-fluid">

            <div class="col-md-12 text-success"><!--2nd col-->
                <big><b>@yield('pageTitle')</b></big>
            </div>
            <br />

            <hr>
            <div class="row">
                <div class="col-md-9">
                    <br>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error_message'))
                        <div class="alert alert-error alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong> {{ session('error_message') }}
                        </div>
                    @endif
                    <form method="post" action="{{ url('/sub-module/add') }}" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Select Module</label>
                            <div class="col-md-9">
                                <select name="module" id="module" class="form-control">
                                    <option value="">Select</option>

                                    @foreach ($modules as $list)
                                        @if ($list->moduleID == session('moduleId'))
                                            <option value="{{ $list->moduleID }}" selected="selected">
                                                {{ $list->modulename }} - ({{$list->link_type}} MODULE)</option>
                                        @else
                                            <option value="{{ $list->moduleID }}">{{ $list->modulename }} - ({{$list->link_type}} MODULE)</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Sub Module Name</label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="subModule"
                                    value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Route</label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="route"
                                    value="{{ old('name') }}" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success btn-sm pull-right">Add</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


    <div id="page-wrapper" class="box box-default">
        <div class="box-body">
            <h2 class="text-center">All Sub Module</h2>
            <div class="row">
                {{ csrf_field() }}

                <div class="col-md-12">
                    <table class="table table-striped table-condensed table-bordered input-sm">
                        <thead>
                            <tr class="input-sm">
                                <th>S/N</th>
                                <th>MODULE</th>
                                <th>SUB MODULE</th>
                                <th>DATE CREATED</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $key = 1; @endphp
                            @foreach ($submodules as $list)
                                <tr>
                                    <td>{{ $key++ }}</td>
                                    <td>{{ strtoupper($list->modulename) }}</td>
                                    <td>{{ strtoupper($list->submodulename) }}</td>
                                    <td>{{ $list->created_at }}</td>
                                    <td><a href="#" title="Edit" id="{{ $list->submoduleID }}"
                                            class="btn btn-success fa fa-edit edit"></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="pagination">{{ $submodules->links() }}</div>
            </div><!-- /.col -->
        </div>


        <!-- modal bootstrap -->
        <form action="{{ url('/sub-module/update') }}" method="post">
            {{ csrf_field() }}
            <div id="myModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Update Sub Module</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="form-group">
                                    <label for="section" class="col-md-3 control-label">Select Module</label>
                                    <div class="col-md-9">
                                        <select name="modules" class="form-control">



                                            @foreach ($modules as $list)
                                                @if ($list->moduleID == session('moduleID'))
                                                    <option value="{{ $list->moduleID }}" selected="selected">
                                                        {{ $list->modulename }}</option>
                                                @else
                                                    <option value="{{ $list->moduleID }}">{{ $list->modulename }}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label for="section" class="col-md-3 control-label">Sub Module Name</label>
                                    <div class="col-md-9">
                                        <input id="subModule" type="text" class="form-control" name="subModules"
                                            value="" required>
                                        <input id="subModuleID" type="hidden" class="form-control" name="subModuleID"
                                            value="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label for="section" class="col-md-3 control-label">Route</label>
                                    <div class="col-md-9">
                                        <input id="routes" type="text" class="form-control" name="routes"
                                            value="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label for="section" class="col-md-3 control-label">Rank</label>
                                    <div class="col-md-9">
                                        <input id="rank" type="number" class="form-control" name="ranks"
                                            value="" required>

                                    </div>
                                </div>
                            </div>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
        <!--// modal Bootstrap -->


    @endsection

    @section('scripts')
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <!-- autocomplete js-->
        <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
        <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>



        <script type="text/javascript">
            $(document).ready(function() {

                $("#module").on('change', function() {
                    var id = $(this).val();

                    $token = $("input[name='_token']").val();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $token
                        },
                        url: "{{ url('/module/setsession') }}",

                        type: "post",
                        data: {
                            'module': id
                        },
                        success: function(data) {
                            location.reload(true);
                        }
                    });



                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {

                $(".table tr td .edit").on('click', function() {
                    var id = $(this).val();

                    $token = $("input[name='_token']").val();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $token
                        },
                        url: "{{ url('/submodule/setsession') }}",

                        type: "post",
                        data: {
                            'submodule': id
                        },
                        success: function(data) {

                        }
                    });



                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('table tr td .edit').click(function() {
                    var id = $(this).attr('id');
                    //alert(id);
                    $.ajax({
                        url: murl + '/submodule/modify',
                        type: "post",
                        data: {
                            'id': id,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(data) {
                            console.log(data.modulename);
                            $('#subModule').val(data.submodulename);
                            $('#subModuleID').val(data.submoduleID);
                            $('#routes').val(data.route);
                            $('#rank').val(data.sub_module_rank);
                        }
                    });

                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('table tr td .edit').click(function() {

                    $("#myModal").modal('show');
                })

            });
        </script>

    @stop
