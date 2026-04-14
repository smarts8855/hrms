@extends('layouts_procurement.app')
@section('pageTitle', 'Edit Award Letter')
@section('pageMenu', 'active')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="panel panel-default"> <!-- Bootstrap 3 panel instead of card -->
                <div class="panel-heading">
                    <h3 class="panel-title"><b>Edit Award Letter</b></h3>
                </div>
                <div class="panel-body">


                    <form method="post" action="{{ route('update-award-letter') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <p class="form-text">Awarded Amount (NGN): <strong>{{ $getList->awarded_amt }}</strong></p>
                        </div>

                        <div class="form-group">
                            <label for="date_award">Date:</label>
                            <input type="date" class="form-control" id="date_award" name="date_award"
                                value="{{ $getList->date_issued }}" required>
                        </div>

                        <div class="form-group">
                            <label for="department_number">Contract Number:</label>
                            <input type="text" class="form-control" id="department_number" name="department_number"
                                value="{{ $getList->department_number }}" required>
                        </div>

                        <div class="form-group">
                            <label for="summernote">Award Letter Content:</label>
                            <textarea id="summernote" name="letter" class="form-control">
                            {!! $getList->award_letter !!}
                        </textarea>
                        </div>

                        <input type="hidden" name="cbid" value="{{ $getList->bidding_id }}">

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 500,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
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
