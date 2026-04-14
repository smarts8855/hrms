@extends('layouts_procurement.app')
@section('pageTitle', 'Unit Page')
@section('pageMenu', 'active')
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div class="row">


            <div class="col-md-12"><!--2nd col-->
                <h4 class="" style="text-transform:uppercase">Unit Management</h4>
                <div align="right" style="margin-bottom: 15px;"> All fields with <span class="text-danger">*</span> are
                    required.</div>

                <form class="custom-validation" method="POST" action="{{ route('store-unit') }}" validate>
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Unit Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="unitName" placeholder="Enter new unit"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="d-flex justify-content-end gap-2" style="margin-top: 27px;">
                                    <button type="reset" class="btn btn-secondary">Clear</button>
                                    <button type="submit" class="btn btn-success">Submit form</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="box-body" style="background:#FFF;">
        <div class="box-header with-border hidden-print">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="box-title"><b>Unit List</b></h3>
                </div>
                <div class="col-md-6 text-right">
                    <h4 style="font-size: 14px; text-decoration: none;">
                        <i class="fa fa-list"></i> Total Units
                    </h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box-header with-border hidden-print text-center">
                    <hr>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-condensed table-bordered">
                        <thead class="text-gray-b">
                            <tr>
                                <th>S/N</th>
                                <th>UNIT</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getUnit as $key => $units)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="font-weight-bold">{{ $units->unit }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target=".viewMoreDescription{{ $key }}">
                                            Edit <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-backdrop="false" data-target="#confirmToDelete{{ $key }}">
                                            Delete <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Unit Modal -->
                                <div class="modal fade viewMoreDescription{{ $key }}" tabindex="-1" role="dialog"
                                    aria-labelledby="editUnitModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xs">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white">Edit Unit</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ URL('/unit-update/') }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Unit Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="unitName"
                                                            value="{{ $units->unit }}" required>
                                                        <input type="hidden" name="unitId" value="{{ $units->unitID }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Modify</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade text-left d-print-none" id="confirmToDelete{{ $key }}"
                                    tabindex="-1" role="dialog" aria-labelledby="confirmToDelete" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h4 class="modal-title text-white">
                                                    <i class="fa fa-trash"></i> Delete Unit
                                                </h4>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-danger text-center">
                                                    <h4>Are you sure you want to delete "{{ $units->unit }}"?</h4>
                                                    <p>This action cannot be undone.</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <a href="/delete-unit/{{ $units->unitID }}" class="btn btn-danger">Yes,
                                                    Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($getUnit instanceof \Illuminate\Pagination\AbstractPaginator)
                    <div>
                        {{ $getUnit->links() }}
                    </div>
                    <div align="right" class="mt-2">
                        Showing {{ ($getUnit->currentpage() - 1) * $getUnit->perpage() + 1 }}
                        to {{ $getUnit->currentpage() * $getUnit->perpage() }}
                        of {{ $getUnit->total() }} entries
                    </div>
                @endif
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
