@extends('layouts_procurement.app')
@section('pageTitle', 'Bank')
@section('pageMenu', 'active')
@section('content')

    @include('Bank.create')




    <div class="row" style="margin-top:150px;">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Banks List</h4>
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Bank Name</th>
                                <th>Bank Code</th>
                                <th>Sort Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($banks as $bank)
                                <tr>
                                    <td>{{ $bank->bankID }}</td>
                                    <td>{{ $bank->bank }}</td>
                                    <td>{{ $bank->bank_code }}</td>
                                    <td>{{ $bank->sort_code }}</td>

                                    <td>

                                        <!-- EDIT BUTTON -->
                                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#edit{{ $bank->bankID }}" style="margin-right:10px;">
                                            Edit
                                        </a>

                                        <!-- DELETE BUTTON -->
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $bank->bankID }}">
                                            Delete
                                        </a>

                                        <!-- EDIT MODAL -->
                                        <div class="modal fade" id="edit{{ $bank->bankID }}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Bank</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('banks.update', $bank->bankID) }}">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="form-group">
                                                                <label>Bank Name <span style="color:red">*</span></label>
                                                                <input type="text" name="bank_name" class="form-control"
                                                                    value="{{ $bank->bank }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Bank Code</label>
                                                                <input type="text" name="bank_code" class="form-control"
                                                                    value="{{ $bank->bank_code }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Sort Code <span style="color:red">*</span></label>
                                                                <input type="text" name="sort_code" class="form-control"
                                                                    value="{{ $bank->sort_code }}">
                                                            </div>

                                                            <button type="submit" class="btn btn-success">Update</button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>



                                        <!-- DELETE MODAL -->
                                        <div class="modal fade" id="delete{{ $bank->bankID }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content panel panel-danger">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header panel-heading"
                                                        style="background:#d9534f; color:#fff;">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">
                                                            <i class="fa fa-trash"></i> Delete Bank
                                                        </h4>
                                                    </div>

                                                    <!-- Modal Body -->
                                                    <div class="modal-body text-center" style="padding:25px;">
                                                        <h4 style="margin-bottom:10px;">Are you sure?</h4>
                                                        <p>You are about to delete:</p>
                                                        <strong
                                                            style="color:#d9534f; font-size:16px;">{{ $bank->bank }}</strong>
                                                    </div>

                                                    <!-- Modal Footer -->
                                                    <div class="modal-footer panel-footer" style="text-align:right;">
                                                        <button class="btn btn-default" data-dismiss="modal">
                                                            <i class="fa fa-times"></i> Cancel
                                                        </button>

                                                        <form method="POST"
                                                            action="{{ route('banks.destroy', $bank->bankID) }}"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fa fa-trash"></i> Delete Bank
                                                            </button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div> <!-- panel-body -->
            </div> <!-- panel -->

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
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('success') }}',
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






    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {
                action: 'contact'
            }).then(function(token) {
                if (token) {
                    document.getElementById('recaptcha').value = token;
                }
            });
        });
    </script>
@endsection
