@extends('layouts.layout')
@section('pageTitle')
    Assign Bank to Staff for Salary Processing
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
                    <form method="post" action="{{ url('/assign-salary-staff') }}" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Select User</label>
                            <div class="col-md-9">
                                <select name="user" class="select_picker form-control" data-live-search="true"
                                    id="">
                                    <option value="">Select...</option>

                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->username }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Select Court</label>
                            <div class="col-md-9">
                                <select name="division" class=" form-control" data-live-search="true" id="getDivision">
                                    <option value="">Select...</option>

                                    @foreach ($divisions as $d)
                                        <option value="{{ $d->divisionID }}">{{ $d->division }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="section" class="col-md-3 control-label">Select Bank</label>
                            <div class="col-md-9">
                                <select name="bank" class=" form-control" data-live-search="true" id="bankName">
                                    <option value="">Select...</option>



                                </select>
                            </div>
                        </div> --}}

                        {{-- <div class="form-group">
                            <div class="col-md-9 col-md-offset-3" id="bankCheckboxList">
                                <!-- Checkboxes will load here -->
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><strong>Banks</strong></div>
                                    <div class="panel-body" id="bankCheckboxList">
                                        <!-- Checkboxes load here -->
                                    </div>
                                </div>
                            </div>
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
            <h4 class="text-center">ASSIGNED STAFF'S</h4>

            <div style="clear: both;"></div>
            <div class="row" style="margin-top: 25px;">
                <div class="col-md-12">
                    <table class="table table-striped table-condensed table-bordered input-sm" id="userRoles">
                        <thead>
                            <tr class="input-sm">
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Bank</th>
                                <th>Court</th>
                                <th>Role</th>
                                <th colspan="2" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php $key = 1; @endphp
                            @foreach ($assigned as $list)
                                <tr id="tr">
                                    <td>{{ $key++ }}</td>
                                    <td>{{ strtoupper($list->name) }}</td>
                                    <td>{{ $list->bank }}</td>
                                    <td>{{ $list->division }}</td>
                                    <td>{{ $list->rolename }}</td>

                                    <td>
                                        <button title="Edit" type="button" class="btn btn-primary btn-sm fa fa-edit"
                                            data-target="#editModal{{ $list->id }}" data-toggle="modal">
                                        </button>

                                    </td>
                                    <td>
                                        <form action="{{ url("/remove-assign-salary-staff/$list->id") }}" method="post">
                                            {{ csrf_field() }}
                                            <button type="submit"
                                                class="btn btn-sm btn-danger fa fa-trash btn-delete"></button>
                                        </form>
                                    </td>
                                </tr>
                                <div id="editModal{{ $list->id }}" class="modal fade">
                                    <div class="modal-dialog box box-default" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">update bank/division assigned to
                                                    {{ $list->username }} </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="form-horizontal"
                                                action="{{ url("/update-assigned-salary-staff/$list->id") }}"
                                                role="form" method="POST">
                                                {{ csrf_field() }}
                                                <div class="modal-body">

                                                    <input type="hidden" class="col-sm-9 form-control" name="assignedId"
                                                        value="{{ $list->id }}">
                                                    <div class="form-group">
                                                        <label for="section" class="col-md-3 control-label">Select
                                                            User</label>
                                                        <div class="col-md-9">
                                                            <select name="user" class="select_picker form-control"
                                                                data-live-search="true" id="">
                                                                <option value="">Select...</option>

                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}"
                                                                        {{ $user->id == $list->userID ? 'selected' : '' }}>
                                                                        {{ $user->username }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="section" class="col-md-3 control-label">Select
                                                            Court</label>
                                                        <div class="col-md-9">
                                                            <select name="division" class=" form-control"
                                                                data-live-search="true" id="">
                                                                <option value="">Select...</option>

                                                                @foreach ($divisions as $d)
                                                                    <option value="{{ $d->divisionID }}"
                                                                        {{ $d->divisionID == $list->divID ? 'selected' : '' }}>
                                                                        {{ $d->division }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="section" class="col-md-3 control-label">Select
                                                            Bank</label>
                                                        <div class="col-md-9">
                                                            <select name="bank" class=" form-control"
                                                                data-live-search="true" id="">
                                                                <option value="">Select...</option>

                                                                @foreach ($banks as $b)
                                                                    <option value="{{ $b->bankID }}"
                                                                        {{ $b->bankID == $list->bankID ? 'selected' : '' }}>
                                                                        {{ $b->bank }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="modal-footer" style="margin-top: 10px !important;">
                                                    <input type="hidden" id="id" name="id">
                                                    <button type="submit" name="edit" class="btn btn-success">Save
                                                        changes</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="hidden-print">{{ $assigned->links() }}</div>
                </div>
            </div>
            <!-- /.col -->

        </div>
    @endsection

    @section('style')
        {{-- <style>
            #bankCheckboxList label {
                font-size: 10px;
                /* Smaller font */
            }

            #bankCheckboxList .col-md-4 {
                margin-bottom: 2px;
                /* space between rows */
            }
        </style> --}}
        <style>
            #bankCheckboxList label {
                font-size: 10px;
                vertical-align: middle;
            }

            #bankCheckboxList input[type="checkbox"] {
                margin-top: 1px;
                /* fine-tune checkbox position */
                vertical-align: middle;
            }

            #bankCheckboxList .col-md-3 {
                margin-bottom: 6px;
            }
        </style>
    @endsection

    @section('scripts')
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- autocomplete js-->
        <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
        <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>

        <script type="text/javascript">
            $('.select_picker').selectpicker({
                style: 'btn-default',
                size: 4
            });
        </script>

        {{-- <script>
            $(document).ready(function() {
                    $('#getDivision').change(function() {
                        let prevDivision = $("#getDivision").val();
                        // alert(prevDivision);
                        $("#bankName").empty();
                        $.ajax({
                            url: murl + '/staff/bank/retreive',
                            type: "post",
                            data: {
                                'divisionID': prevDivision,
                                '_token': $('input[name=_token]').val()
                            },
                            success: function(data) {
                                // console.log("banks", data);
                                $('#bankName').append('<option value="" >' + 'Select Bank' +
                                    '</option>');
                                $.each(data, function(i, obj) {
                                    $('#bankName').append('<option value="' + obj.bank +
                                        '" >' + obj
                                        .bankName + '</option>');

                                })
                            }
                        });
                    })

            })

        </script> --}}
        <script>
            // $(document).ready(function() {
            //     $('#getDivision').change(function() {
            //         let prevDivision = $("#getDivision").val();

            //         $("#bankCheckboxList").empty(); // clear old checkboxes

            //         $.ajax({
            //             url: murl + '/staff/bank/retreive',
            //             type: "post",
            //             data: {
            //                 'divisionID': prevDivision,
            //                 '_token': $('input[name=_token]').val()
            //             },
            //             success: function(data) {

            //                 $.each(data, function(i, obj) {

            //                     // Each checkbox
            //                     let checkbox = `
    //             <div class="checkbox">
    //                 <label>
    //                     <input type="checkbox" name="bank[]" value="${obj.bank}">
    //                     ${obj.bankName}
    //                 </label>
    //             </div>
    //         `;

            //                     $('#bankCheckboxList').append(checkbox);
            //                 });
            //             }
            //         });
            //     });
            // });

            $(document).ready(function() {
                $('#getDivision').change(function() {

                    let prevDivision = $("#getDivision").val();
                    $("#bankCheckboxList").empty();

                    $.ajax({
                        url: murl + '/staff/bank/retreive',
                        type: "post",
                        data: {
                            'divisionID': prevDivision,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(data) {

                            $.each(data, function(i, obj) {

                                let checkbox = `
                        <div class="col-md-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="bank[]" value="${obj.bank}">
                                    ${obj.bankName}
                                </label>
                            </div>
                        </div>
                    `;

                                $('#bankCheckboxList').append(checkbox);
                            });

                        }
                    });
                });
            });
        </script>
        <script>
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault(); // Stop the form from submitting

                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This record will be deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        </script>


    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">
    @endsection

@endsection
