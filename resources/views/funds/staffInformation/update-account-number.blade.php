@extends('layouts.layout')
@section('pageTitle')
    STAFF INFORMATION
@endsection
@section('content')

    <div class="box box-default">
        <div class="box-body">
            <div class="box-body">
                <div>
                    <h4 class="text-success text-uppercase">Update Staff Claim Account Details</h4>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12"><!--1st col-->
                            @include('funds.Share.message')
                            <form method="post" action="{{ route('update-staff-account-details') }}">
                                @csrf

                                <div class="row">

                                    {{-- Staff Select2 Search --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Staff File No.</label>
                                            <select name="staffFileNo" id="staff_select" class="form-control"
                                                required></select>
                                        </div>
                                    </div>

                                    {{-- Firstname --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>File number <i class="text-danger">*</i></label>
                                            <input type="text" name="fileNumber" id="fileNumber" class="form-control"
                                                readonly />
                                        </div>
                                    </div>

                                    {{-- Surname --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fullname <i class="text-danger">*</i></label>
                                            <input type="text" name="surname" id="fullname" class="form-control"
                                                readonly />
                                        </div>
                                    </div>


                                    {{-- Account Number --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Claim Account Number <i class="text-danger">*</i></label>
                                            <input type="text" name="accountNumber" id="accountNumber"
                                                class="form-control" required />
                                        </div>
                                    </div>

                                    {{-- Bank --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Bank Name <i class="text-danger">*</i></label>
                                            <select name="bankName" class="form-control" id="bankName" required>
                                                <option value="">Select</option>
                                                @forelse($bank as $bkList)
                                                    <option value="{{ $bkList->bankID }}"
                                                        data-code="{{ $bkList->sortcode }}">
                                                        {{ $bkList->bank }}
                                                    </option>
                                                @empty
                                                    <option value="">No Bank Available</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Sort Code --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sort Code</label>
                                            <input type="text" name="sortCode" id="sortCode" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-4"> </div>

                                    {{-- Submit --}}
                                    <div class="col-md-4"> </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-success w-100 form-control">
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
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0-beta.10/dist/select2-bootstrap.min.css"
        rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {

            // Initialize Select2
            $('#staff_select').select2({
                placeholder: "Search by File No or Name",
                ajax: {
                    url: "{{ route('search.staff') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(data) {
                        return data;
                    },
                    cache: true
                }
            });

            // When staff selected
            $('#staff_select').on('select2:select', function(e) {

                let data = e.params.data;

                let surname = data.surname;
                let firstname = data.firstname;
                let othernames = data.othernames;

                console.log({
                    surname,
                    firstname,
                    othernames
                });

                $('#fullname').val(`${surname} ${firstname} ${othernames}`);
                $('#fileNumber').val(`${data.fileNo}`);

                // Optional: auto-fill account/bank if returned
                if (data.accountNumber) {
                    $('#accountNumber').val(data.accountNumber);
                }

                if (data.bankName) {
                    $('#bankName').val(data.bankName).trigger('change');
                }

                if (data.sortCode) {
                    $('#sortCode').val(data.sortCode);
                }
            });

            // Auto-fill sort code when bank changes
            $('#bankName').on('change', function() {
                let sortCode = $(this).find(':selected').data('code');
                $('#sortCode').val(sortCode ?? '');
            });

        });
    </script>
@endsection
