@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Contract Category') }}
@endsection
@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="border-radius:6px; box-shadow:0 2px 4px rgba(0,0,0,0.1);">
                <div class="panel-heading" style="background:#fff; border-bottom:1px solid #eee;">
                    <h4 class="panel-title" style="margin:0; padding:10px 0;">Create New Contract Category</h4>
                    <div align="right" style="font-size:12px;">
                        All fields with <span class="text-danger">*</span> are required.
                    </div>
                </div>

                <div class="panel-body">


                    <form class="custom-validation" method="POST" action="{{ route('postContractCategory') }}">
                        @csrf

                        <div class="row">
                            <div class="form-group col-md-6 col-md-offset-3">
                                <label>Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="categoryName" value="{{ old('categoryName') }}" required
                                    autofocus class="form-control" placeholder="Category Name" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div align="center">
                                    <input type="hidden" name="categoryID" />

                                    <button type="reset" class="btn btn-default">
                                        Reset
                                    </button>

                                    <button type="submit" class="btn btn-success">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default"
                style="border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.15); border:1px solid #e5e5e5;">

                <div class="panel-heading" style="background:#fff; padding:15px; border-bottom:1px solid #eee;">
                    <h4 class="panel-title" style="margin:0;">All Categories</h4>
                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="form-group col-md-12" align="center">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Category Name</th>
                                        <th colspan="1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if (isset($getContractCategory) && is_iterable($getContractCategory))
                                        @foreach ($getContractCategory as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->category_name }}</td>

                                                <td>
                                                    <a href="javascript:;" title="Edit Record"
                                                        class="btn btn-default btn-sm" data-toggle="modal"
                                                        data-target=".editCategory{{ $key }}">
                                                        Edit
                                                    </a>

                                                    <a href="javascript:;" title="Delete Record"
                                                        class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target=".deleteCategory{{ $key }}">
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal -->
                                            <div class="modal fade deleteCategory{{ $key }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Confirm!</h4>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p><strong>Delete:</strong> {{ $item->category_name }}</p>
                                                            <p>Are you sure you want to delete this record?</p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>

                                                            <a href="{{ route('deleteContractCategory', ['id' => base64_encode($item->contractCategoryID)]) }}"
                                                                class="btn btn-danger">
                                                                Delete
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Delete Modal -->

                                            <!-- Edit Modal -->
                                            <form method="POST" action="{{ route('postContractCategory') }}">
                                                @csrf
                                                <div class="modal fade editCategory{{ $key }}" tabindex="-1"
                                                    role="dialog">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Record</h4>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    &times;
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Category Name <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" name="categoryName"
                                                                        value="{{ $item->category_name }}"
                                                                        class="form-control" required>
                                                                    <input type="hidden" name="categoryID"
                                                                        value="{{ $item->contractCategoryID }}">
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close</button>

                                                                <button type="submit" class="btn btn-success">
                                                                    Submit
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- End Edit Modal -->
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>





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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('msg'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('msg') }}',
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
@endsection
