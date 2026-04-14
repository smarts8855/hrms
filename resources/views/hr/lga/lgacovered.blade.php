@extends('layouts.layout')
@section('pageTitle')
    Local Govement Covered
@endsection



@section('content')
    <style>
        .table>thead>tr>th {
            vertical-align: middle;
            text-align: center;
            font-weight: 600;
            background-color: #f0f0f0;
            border-bottom: 2px solid #ddd;
        }

        .table>tbody>tr:hover {
            background-color: #f9f9f9;
        }

        .btn-xs {
            padding: 3px 8px;
            font-size: 12px;
        }

        .text-right {
            margin-top: 5px;
        }

        .panel {
            border-radius: 6px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
        }

        .panel-heading {
            background-color: #2c3e50;
            color: #fff;
        }

        .form-group label {
            font-weight: 600;
        }

        .swal2-title-custom {
            font-size: 18px !important;
            font-weight: 600;
        }

        .dataTables_filter {
            float: right !important;
            margin-bottom: 10px !important;


        }

        .dataTables_length label:first-child {
            display: none !important;
        }
    </style>


    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <!-- Card header -->
                <div class="modal-header " style="color: #fff;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="editModalLabel">
                        <i class="fa fa-edit"></i> Edit Local Government Area
                    </h4>
                </div>

                <!-- Card body -->
                <form class="form-horizontal" id="editLgaModal" name="editLgaModal" method="POST"
                    action="{{ url('lga/covered/edit') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="panel panel-default" style="box-shadow: 0 2px 6px rgba(0,0,0,0.2); border-radius: 4px;">
                            <div class="panel-body">

                                <div class="form-group">
                                    <label for="lgaChange" class="col-sm-3 control-label">LGA Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="lgaChange" name="lgaChange"
                                            placeholder="Enter Local Government Area">
                                        <input type="hidden" id="lgaid" name="lgaid">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Card footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Save changes
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times"></i> Close
                        </button>
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
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        {{-- @include('hr.Share.message') --}}

                        <form class="form-horizontal" role="form" method="post" action="{{ url('lga/covered/add') }}">
                            {{ csrf_field() }}

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Add New Local Government</strong></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row" style="padding: 10px">


                                        <div class="col-md-4" style="margin-right: 15px">
                                            <div class="form-group">
                                                <label>State</label>


                                                <select class="form-control department" id="state" name="state">
                                                    <option value="">-select State-</option>
                                                    @foreach ($getStates as $list)
                                                        <option value="{{ $list->StateID }}"
                                                            {{ $StateID == $list->StateID ? 'selected' : '' }}>
                                                            {{ $list->State }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="margin-right: 20px">
                                            <div class="form-group">
                                                <label>Local Govement Area</label>
                                                <input type="text" class="form-control" id="localGovernmentArea"
                                                    name="localGovernmentArea" placeholder="">
                                            </div>
                                        </div>



                                        <div class="col-md-2">
                                            <div class="form-group" style="margin-top:25px;">
                                                <button type="submit" class="btn btn-success btn-block" name="add">
                                                    <i class="fa fa-floppy-o"></i> Add New
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                    </div>








                    <!-- /.row -->

                    </form>

                    <div class="table-responsive col-md-12" style="font-size:13px; margin-top:10px;">
                        <table id="mytable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background-color:#f5f5f5; color:#333;">


                                    <th style="width: 10%">S/N</th>
                                    <th style="width: 50%">NAME</th>
                                    <th style="width: 10%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            @php $i=1;@endphp
                            @foreach ($getLGA as $list)
                                <tr>
                                    <td style="widows: 10%">{{ $i++ }}</td>
                                    <td style="width: 70%">{{ $list->lga }}</td>


                                    <td style="width: 20%" class="text-center">

                                        <button type="button" class="btn btn-xs btn-primary"
                                            onclick="editfunc('{{ $list->lga }}', '{{ $list->lgaId }}')"
                                            class="" id="">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>

                                        {{-- <a style="color: #fff; cursor: pointer;" class="btn btn-xs btn-danger"
                                            href="{{ url('lga/covered/remove/' . $list->lgaId) }}"
                                            onclick="return confirm('Are you sure you want to delete this item?');"> <i
                                                class="fa fa-trash"></i> Delete</a> --}}

                                        <button type="button" class="btn btn-xs btn-danger"
                                            onclick="deleteLGA({{ $list->lgaId }})">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </table>

                    </div>



                    <hr />
                </div>

            </div>
        </div>

        <form id="getAllLga" method="post" action="{{ url('lga/covered') }}">
            {{ csrf_field() }}
            <input type="hidden" id="getState" name="getState" />
        </form>
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

    {{-- @section('scripts')
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
        <script>
            function editfunc(x, y) {
                $(document).ready(function() {
                    $('#lgaChange').val(x);
                    $('#lgaid').val(y);
                    $("#editModal").modal('show');
                });
            }



            $('#state').change(function() {
                $('#getState').val($('#state').val());
                $('#getAllLga').submit();
            });

            $(document).ready(function() {
                $('#mytable').DataTable();
            });
            // delete function for LGA
            function deleteLGA(lgaId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will permanently delete the LGA. This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a form and submit it
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/lga/covered/remove/${lgaId}`; // Your Laravel route

                        // Add CSRF token
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}'; // Laravel CSRF token
                        form.appendChild(csrfToken);

                        // Append form to body and submit
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

            @if (session('success'))
                <
                script >
                    $(document).ready(function() {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: '{{ session('success') }}',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            background: '#d4edda',
                            color: '#155724',
                        });
                    });
        </script>
        @endif

        @if (session('error'))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: '{{ session('error') }}',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#f8d7da',
                        color: '#721c24',
                    });
                });
            </script>
        @endif



        </script>



    @stop --}}

    @section('scripts')
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

        <script>
            function editfunc(x, y) {
                $('#lgaChange').val(x);
                $('#lgaid').val(y);
                $("#editModal").modal('show');
            }

            $('#state').change(function() {
                $('#getState').val($('#state').val());
                $('#getAllLga').submit();
            });

            // $(document).ready(function() {
            //     $('#mytable').DataTable();
            // });

            $(document).ready(function() {
                $('#mytable').DataTable({
                    pageLength: 15, // 👈 show 15 rows per page
                    lengthMenu: [10, 15, 20, 30, 50, 100], // optional dropdown options
                });
            });

            // delete function for LGA
            function deleteLGA(lgaId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will permanently delete the LGA. This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a form and submit it
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/lga/covered/remove/${lgaId}`; // Your Laravel route

                        // Add CSRF token
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}'; // Laravel CSRF token
                        form.appendChild(csrfToken);

                        // Append form to body and submit
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        </script>

        {{-- ✅ Toast alerts after redirect --}}
        @if (session('success'))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#d4edda',
                        color: '#155724',
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: '{{ session('error') }}',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#f8d7da',
                        color: '#721c24',
                    });
                });
            </script>
        @endif
    @endsection
