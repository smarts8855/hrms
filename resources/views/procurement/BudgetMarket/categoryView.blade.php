@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Create Budget Category') }}
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <!-- Bootstrap 3 card-style panel -->
            <div class="panel panel-default"
                style="border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); border:1px solid #ddd;">

                <div class="panel-heading"
                    style="background:#f7f7f7; border-top-left-radius:10px; border-top-right-radius:10px; padding:15px;">
                    <h4 class="panel-title" style="margin:0; font-weight:600;">
                        @yield('pageTitle')
                    </h4>
                </div>

                <div class="panel-body" style="padding:25px;">
                    <div class="text-right" style="margin-bottom:10px;">
                        All fields with <span class="text-danger">*</span> are required.
                    </div>



                    <form class="formFormatAmount" method="POST" action="{{ route('createBudgetCategory') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 col-md-offset-3">
                                <label>Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="category" value="{{ old('category') }}" class="form-control"
                                    placeholder="Category" required autofocus>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-md-offset-3 text-right">
                                <button class="btn btn-primary">
                                    <i class="glyphicon glyphicon-plus"></i> Add Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col -->
    </div><!-- /.row -->



    <div class="row">
        <div class="col-md-12">
            <!-- Bootstrap 3 Card-style Panel -->
            <div class="panel panel-default"
                style="border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); border:1px solid #ddd;">

                <div class="panel-heading"
                    style="background:#f7f7f7; border-bottom:1px solid #ddd; border-top-left-radius:10px; border-top-right-radius:10px; padding:15px;">
                    <h4 class="panel-title" style="margin:0; font-weight:600;">
                        List of Category
                    </h4>
                </div>

                <div class="panel-body" style="padding:25px;">
                    <hr style="margin-top:0; margin-bottom:20px;" />

                    <div class="row">
                        <div align="center" class="form-group col-md-12">
                            <table class="table table-hover table-bordered table-responsive">
                                <thead style="background:#f0f0f0; font-weight:bold;">
                                    <tr>
                                        <th>SN</th>
                                        <th>Category Name</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($getBudgetCategory) && is_iterable($getBudgetCategory))
                                        @foreach ($getBudgetCategory as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->category }}</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target=".viewEditRecord{{ $key }}">
                                                        <i class="glyphicon glyphicon-edit"></i> Edit
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" title="Delete Record"
                                                        class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target=".deleteCategory{{ $key }}">
                                                        <i class="glyphicon glyphicon-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <form method="POST" action="{{ route('createBudgetCategory') }}">
                                                @csrf
                                                <div class="modal fade viewEditRecord{{ $key }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="viewEditRecord{{ $key }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Edit Record</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group text-left">
                                                                    <label>Category Name <span
                                                                            class="text-danger">*</span></label>
                                                                    <input required type="text" name="category"
                                                                        value="{{ $value->category ?: old('category') }}"
                                                                        class="form-control" placeholder="Category">
                                                                    <input type="hidden" name="recordID"
                                                                        value="{{ $value->categoryID }}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- Delete Modal -->
                                            <div class="modal fade deleteCategory{{ $key }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Confirm Delete</h4>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <p class="text-primary">Delete this record:
                                                                <strong>{{ $value->category }}</strong>
                                                            </p>
                                                            <p class="text-danger">Are you sure you want to delete this
                                                                record?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Cancel</button>
                                                            <a href="{{ route('deleteCategory', ['cID' => base64_encode($value->categoryID)]) }}"
                                                                class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col -->
    </div><!-- /.row -->



@endsection

@section('styles')
    <style>
        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/table2excel.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('message'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif





    <!--Format Amount while typing-->
    <script>
        //Number Format
        $(document).ready(function() {
            $("#formatAmountOnKeyPress").on('keyup', function(evt) {
                //if (evt.which != 110 ){//not a fullstop
                //var n = parseFloat($(this).val().replace(/\,/g,''),10);

                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                        /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
                //$(this).val(n.toLocaleString());
                //}
            });
        });

        (function($, undefined) {
            "use strict";
            // When ready.
            $(function() {
                var $form = $(".formFormatAmount");
                var $input = $form.find(".format-amount");
                $input.on("keyup", function(event) {
                    // When user select text in the document, also abort.
                    var selection = window.getSelection().toString();
                    if (selection !== '') {
                        return;
                    }
                    // When the arrow keys are pressed, abort.
                    if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                        return;
                    }
                    var $this = $(this);
                    // Get the value.
                    var input = $this.val();
                    var input = input.replace(/[\D\s\._\-]+/g, "");
                    input = input ? parseInt(input, 10) : 0;
                    $this.val(function() {
                        return (input === 0) ? "" : input.toLocaleString("en-US");
                    });
                });

            });
        })(jQuery);
    </script>
@endsection
