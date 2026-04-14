@extends('layouts.layout')
@section('pageTitle')
    Create Allocation type
@endsection



@section('content')

    <div id="editModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit </h4>
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
                                <label class="col-sm-2 control-label">Allocation</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" value="" name="editable" id="editable" class="form-control">
                            </div>
                            <input type="hidden" id="edit-hidden" name="edit-hidden" value="">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div id="RestoreModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Restore Variable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-9 control-label"><b>Are you sure you want to restore this
                                        record?</b></label>
                            </div>
                            <input type="hidden" id="restoreid" name="restoreid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>

                </form>
            </div>

        </div>
    </div>


    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>

            <div class="col-md-12">
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
            </div>


            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        @include('Share.message')

                        <form class="form-horizontal" id="form1" role="form" method="post" action="">
                            {{ csrf_field() }}

                            <div class="col-md-12"><!--2nd col-->
                                <!-- /.row -->
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label class="control-label">Allocation Type</label>
                                        <input required class="form-control" id="allocation" name="allocation">
                                    </div>

                                    <div class="col-md-2">
                                        <br>
                                        <button type="submit" class="btn btn-success form-control"
                                            name="submit">Submit</button>
                                    </div>


                                </div>
                            </div>
                            <!-- /.col -->
                    </div>
                    </form>
                    <!-- /.row -->
                    <div class="row">
                        {{ csrf_field() }}


                        <!-- /.col -->
                    </div>


                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    <th>S/N</th>
                                    <th>Allocations</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            @php $i = 1; @endphp
                            <tbody>

                                @foreach ($Lists as $list)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $list->allocation }}</td>
                                        <td>
                                            @if ($list->status == 1)
                                                <span class="text-success"> Active </span>
                                            @else
                                                <span class="text-danger"> Inactive </span>
                                            @endif
                                        <td>
                                            @if ($list->status == 1)
                                                <button
                                                    onclick="return editfunc('{{ $list->ID }}', '{{ $list->allocation }}')"
                                                    class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button>
                                                <button onclick="return deletefunc('{{ $list->ID }}')"
                                                    class="btn btn-danger btn-xs"> Deactivate </button>
                                            @else
                                                <button
                                                    onclick="return editfunc('{{ $list->ID }}', '{{ $list->allocation }}')"
                                                    class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button>
                                                <button onclick="return restorefunc('{{ $list->ID }}')"
                                                    class="btn btn-warning btn-xs"> Restore </button>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <input type="hidden" value="" id="co" name="court">
                    <input type="hidden" value="" id="di" name="division">
                    <input type="hidden" value="{{ $status }}" name="status">
                    <input type="hidden" value="" name="chosen" id="chosen">
                    <input type="hidden" value="" id="type" name="type">

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
            $("#check-all").change(function() {
                $(".checkitem").prop("checked", $(this).prop("checked"))
            })
            $(".checkitem").change(function() {
                if ($(this).prop("checked") == false) {
                    $("#check-all").prop("checked", false)
                }
                if ($(".checkitem:checked").length == $(".checkitem").length) {
                    $("#check-all").prop("checked", true)
                }
            })

            function approve(a = '') {
                if (a !== '') {
                    document.getElementById('chosen').value = a;
                    // alert(a);
                }
                co = document.getElementById('court').value;
                div = document.getElementById('division').value;
                document.getElementById('co').value = co;
                document.getElementById('di').value = div;
                document.getElementById('type').value = 1;
                document.getElementById('form2').submit();
                return false;
            }

            function reject(a = '') {
                if (a !== '') {
                    document.getElementById('chosen').value = a;
                    //alert(a);
                }
                co = document.getElementById('court').value;
                div = document.getElementById('division').value;
                document.getElementById('co').value = co;
                document.getElementById('di').value = div;
                document.getElementById('type').value = 2;
                document.getElementById('form2').submit();
                return false;
            }

            function delet(a = '') {
                if (confirm('Are you sure you want to delete this record!')) {
                    if (a !== '') {
                        document.getElementById('chosen').value = a;
                        //alert(a);
                    }
                    co = document.getElementById('court').value;
                    div = document.getElementById('division').value;
                    document.getElementById('co').value = co;
                    document.getElementById('di').value = div;
                    document.getElementById('type').value = 3;
                    document.getElementById('form2').submit();
                }
                return false;
            }


            function editfunc(x, a) {
                document.getElementById('edit-hidden').value = x;
                document.getElementById('editable').value = a;
                $("#editModal").modal('show')
            }

            function deletefunc(x) {
                //$('#deleteid').val() = x;

                document.getElementById('deleteid').value = x;
                $("#DeleteModal").modal('show');
            }

            function restorefunc(x) {

                document.getElementById('restoreid').value = x;
                $("#RestoreModal").modal('show');
            }

            function getDivisions() {
                document.getElementById('status').value = "";
                if ($('#court').val() !== "") {
                    $('#form1').submit();
                }
            }

            function getStaff() {
                document.getElementById('status').value = "";
                if ($('#division').val() !== "") {
                    $('#form1').submit();
                }
            }

            function getTable() {
                if ($('#status').val() !== "") {
                    $('#form1').submit();
                }
            }

            function checkForm() {
                var court = $('#court').val();
                division = $('#division').val();
                fileno = $('#fileNo').val();
                fname = $('#fname').val();
                oname = $('#oname').val();
                sname = $('#sname').val();
                desc = $('#cvdesc').val();
                amount = $('#amount').val();
                if (court == "") {
                    alert('You have empty fields!');
                } else {
                    if (division == "") {
                        alert('You have empty fields');
                    } else {
                        if (fileno == "") {
                            alert('you have empty fields!');
                        } else {
                            if (fname == "") {
                                alert('you have empty fields!');
                            } else {
                                if (oname == "") {
                                    alert('you have empty fields');
                                } else {
                                    if (sname == "") {
                                        alert('you have empty fields!');
                                    } else {
                                        if (desc == "") {
                                            alert('you have empty fields!');
                                        } else {
                                            if (amount == "") {
                                                alert('you have empty fields!');
                                            } else {
                                                $('#form1').submit();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                return false;
            }
        </script>
    @stop
