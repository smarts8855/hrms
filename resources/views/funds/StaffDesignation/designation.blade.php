@extends('layouts.layout')
@section('pageTitle')
    Staff Designation
@endsection

@section('content')
    <div id="page-wrapper" class="box box-default">
        <div class="container-fluid">

            <hr>    
            <div class="row">
                <div class="col-md-12"> <br>
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
                            <strong>Successful!</strong> {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error_message'))
                        <div class="alert alert-error alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span> </button>
                            <strong>Error!</strong> {{ session('error_message') }}
                        </div>
                    @endif
                    <form method="post" id="mandateForm" action="{{ url('user/assign-designation') }}"
                        class="form-horizontal" style="margin-left:10px; margin-right:10px;">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-groupp">
                                    <label class="control-label">Staff</label>
                                    <select class="select_picker form-control" data-live-search="true" id="users" name="users">
                                        <option value="">--Select Staff--</option>
                                        @foreach ($users as $list)
                                            <option value="{{ $list->id }}" {{-- {{ old('users') == $list->id || $users == $list->id ? 'selected' : '' }} --}}>
                                                {{ $list->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-groupp">
                                    <label class="control-label">Section</label>
                                    <select class="form-control" id="sections" name="sections">
                                        <option value="">--Select Section--</option>
                                        @foreach ($sections as $lists)
                                            <option value="{{ $lists->code }}"
                                                {{-- {{ old('sections') == $lists->id || $sections == $lists->id ? 'selected' : '' }} --}}
                                                >
                                                {{ $lists->section }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="" style="margin-top: 26px;">
                                <div class="form-group">
                                    <button type="submit" class="col-md-3 btn btn-success">Update</button>
                                </div>
                            </div>
                        </div>
                        </br>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="page-wrapper" class="box box-default">
        <div class="box-body">
            <h4 class="text-center">Finance Dept Staff Designations</h4>
            <div class="row"> {{ csrf_field() }}
                <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">

                    <table id="mytable" class="table table-bordered table-striped table-highlight">
                        <thead>
                            <tr bgcolor="#c7c7c7">
                                <th>S/N</th>
                                <th>Staff Name</th>
                                <th>Section</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $i = 1;
                            @endphp

                            @foreach ($staffsections as $pv)
                                <tr>
                                    <td>{{ $i++ }}</td>

                                    <td>

                                        {{ $pv->name }}

                                    </td>

                                    <td>
                                        {{ $pv->section }}
                                    </td>


                                    <td><a href="{{ url('user/delete') }}/{{ $pv->id }}"
                                            class="btn btn-success btn-xs">Delete</a></td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr />


                    <div class="hidden-print"></div>
                </div>
            </div>
            <!-- /.col -->

        </div>


        <!-- modal bootstrap -->
        <form method="post">
            {{ csrf_field() }}
            <div id="myModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Update Module</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row" style="margin-bottom: 10px;">
                                <div class="form-group">
                                    <label for="section" class="col-md-3 control-label">Module Name</label>
                                    <div class="col-md-9">
                                        <input id="module" type="text" class="form-control" name="name" required>
                                        <input id="id" type="hidden" class="form-control" name="moduleID" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label for="section" class="col-md-3 control-label">Rank</label>
                                    <div class="col-md-9">
                                        <input id="ranks" type="number" class="form-control" name="rank"
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

                <!--// modal Bootstrap -->
        </form>

    @endsection

    @section('scripts')

        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <script type="text/javascript">
            $('.select_picker').selectpicker({
                style: 'btn-default',
                size: 4
            });
        </script>

    @endsection

    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
        <style type "text/css">
            <!--
            /* @group Blink */
            .blink {
                -webkit-animation: blink .75s linear infinite;
                -moz-animation: blink .75s linear infinite;
                -ms-animation: blink .75s linear infinite;
                -o-animation: blink .75s linear infinite;
                animation: blink .75s linear infinite;
                color: red;
            }

            @-webkit-keyframes blink {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 1;
                }

                50.01% {
                    opacity: 0;
                }

                100% {
                    opacity: 0;
                }
            }

            @-moz-keyframes blink {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 1;
                }

                50.01% {
                    opacity: 0;
                }

                100% {
                    opacity: 0;
                }
            }

            @-ms-keyframes blink {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 1;
                }

                50.01% {
                    opacity: 0;
                }

                100% {
                    opacity: 0;
                }
            }

            @-o-keyframes blink {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 1;
                }

                50.01% {
                    opacity: 0;
                }

                100% {
                    opacity: 0;
                }
            }

            @keyframes blink {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 1;
                }

                50.01% {
                    opacity: 0;
                }

                100% {
                    opacity: 0;
                }
            }

            /* @end */
            -->
        </style>
    @stop

    @section('scripts')

        <script type="text/javascript" src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        <script>
            function getPetitionByType() {
                var petitionValue = $('#petitionType').val();
                if (petitionValue != "") {
                    $('#petitionForm').submit();


                }
            }
        </script>

        <script>
            function getPetitionByStatus() {
                var petitionValue = $('#petitionStatus').val();
                if (petitionValue != "") {
                    $('#petitionForm').submit();
                }
            }


            $(function() {
                $("#from").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
                });
                $("#to").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
                });
            });
            $(document).ready(function() {
                $('#').DataTable();
            });

            $(document).ready(function() {
                $('#mytable').DataTable({
                    dom: 'Bfrtip',
                    "pageLength": 100
                    buttons: [{
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt')
                                .prepend(
                                    ''
                                );

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }]
                });
            });
        </script>

    @stop
