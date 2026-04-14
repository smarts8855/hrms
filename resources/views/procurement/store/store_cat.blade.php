@extends('layouts.layout')

@section('pageTitle')
    <strong>Store Category Setup</strong>
@endsection

@section('content')
    <div class="container" style="padding-top:25px;">

        <div class="panel"
            style="border-radius:8px;background-color:#ecf0f5;box-shadow:0 2px 8px rgba(0,0,0,0.1);border:none;">

            <div class="panel-heading">
                <div class="row">

                    <div class="col-sm-6">
                        <h4 class="panel-title" style="margin:0;color:#333;">
                            @yield('pageTitle')
                        </h4>
                    </div>

                    <div class="col-sm-6 text-right">
                        <span id="processing" class="small"></span>
                    </div>

                </div>
            </div>

            @if (session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Category',
                        text: '{{ session('error') }}'
                    });
                </script>
            @endif


            <div class="panel-body"
                style="background-color:#f9f9f9;border-bottom-left-radius:8px;border-bottom-right-radius:8px;">

                <!-- Add Category Form -->

                <div class="box box-primary" style="border-radius:6px;border:1px solid #ddd;">

                    <div class="box-header with-border" style="background-color:#ecf0f5;color:#333;">

                        <h4 class="box-title">
                            <i class="fa fa-folder"></i> Add Store Category
                        </h4>

                    </div>

                    <div class="box-body" style="padding:20px;">

                        <form method="POST" action="{{ route('store-category.store') }}" class="form-horizontal">
                            @csrf

                            <!-- CATEGORY -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                    <input type="text" name="storeItemCat" class="form-control"
                                        placeholder="Enter store category" required>
                                </div>
                            </div>

                            <!-- USER -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Select User (Optional)</label>
                                <div class="col-sm-10">
                                    <select name="assignedUser" class="form-control">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('assignedUser') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- BUTTON -->
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fa fa-save"></i> Add
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>



                <!-- Category Table -->

                <div class="table-responsive" style="margin-top:25px;">

                    <table class="table table-hover table-bordered" style="background:#fff;">

                        <thead style="background:#f1f1f1;">

                            <tr>

                                <th style="width:60px;">S/N</th>

                                <th>Category</th>
                                <th>Assigned User</th>

                                <th style="width:150px;text-align:center;">Action</th>

                            </tr>

                        </thead>

                        {{-- <tbody>

                            @php $i=1; @endphp

                            @foreach ($categories as $cat)
                                <tr>

                                    <td>{{ $i++ }}</td>

                                    <td>{{ $cat->storeItemCat }}</td>

                                    <td style="text-align:center;">

                                        <button class="btn btn-xs btn-primary"
                                            onclick="editCategory('{{ $cat->id }}','{{ addslashes($cat->storeItemCat) }}')">

                                            <i class="fa fa-edit"></i> Edit

                                        </button>


                                        <button class="btn btn-xs btn-danger"
                                            onclick="deleteCategory('{{ $cat->id }}',this)">

                                            <i class="fa fa-trash"></i> Delete

                                        </button>

                                    </td>

                                </tr>
                            @endforeach

                            @if (count($categories) == 0)
                                <tr>

                                    <td colspan="3" class="text-center text-muted" style="padding:20px;">
                                        No store categories found
                                    </td>

                                </tr>
                            @endif

                        </tbody> --}}

                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($categories as $cat)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $cat->storeItemCat }}</td>
                                    <td>
                                        @php
                                            $assignedUser = $users->firstWhere('id', $cat->assignedUser);
                                        @endphp
                                        @if ($assignedUser)
                                            <span>{{ $assignedUser->name }}</span>
                                        @else
                                            <span class="label label-default">Unassigned</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">

                                        <button class="btn btn-xs btn-primary"
                                            onclick="editCategory('{{ $cat->id }}','{{ addslashes($cat->storeItemCat) }}','{{ $cat->assignedUser }}')">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>

                                        <button class="btn btn-xs btn-danger"
                                            onclick="deleteCategory('{{ $cat->id }}',this)">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>



    <!-- EDIT MODAL -->

    <div id="editModal" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">


                <div class="modal-header" style="color:#fff;background:linear-gradient(90deg,#449d44,#337a33);">

                    <button type="button" class="close" data-dismiss="modal" style="color:#fff;">
                        &times;
                    </button>

                    <h4 class="modal-title">

                        <i class="fa fa-edit"></i> Edit Store Category

                    </h4>

                </div>


                <form method="POST" action="{{ route('store-category.update') }}" class="form-horizontal">

                    @csrf

                    <div class="modal-body">

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Category</label>

                            <div class="col-sm-8">

                                <input type="text" class="form-control" id="edit_category" name="storeItemCat">

                                <input type="hidden" id="edit_id" name="id">

                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Select User (Optional)</label>
                            <div class="col-sm-8">
                                <select name="assignedUser" id="edit_assigned_user" class="form-control">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                           >
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </div>


                    <div class="modal-footer">

                        <button type="submit" class="btn btn-success">

                            <i class="fa fa-save"></i> Update

                        </button>

                        <button type="button" class="btn btn-default" data-dismiss="modal">

                            Close

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection



@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function editCategory(id, name, assignedUser) {

            $('#edit_id').val(id);
            $('#edit_category').val(name);
            $('#editModal').modal('show');
              // Set the selected user in the dropdown
        if (assignedUser && assignedUser != '') {
            $('select[name="assignedUser"]').val(assignedUser);
        } else {
            $('select[name="assignedUser"]').val(''); // Set to empty option
        }

        }


        function deleteCategory(id, btn) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this category.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('store-category.delete', ':id') }}";
                    url = url.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.success) {
                                // deletion successful
                                $(btn).closest('tr').fadeOut(400, function() {
                                    $(this).remove();
                                });

                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: res.message || 'Category deleted successfully',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            } else {
                                // deletion blocked (has linked items)
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Cannot Delete',
                                    text: res.message || 'This category cannot be deleted.',
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    });
                }
            });
        }
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif
@endsection
