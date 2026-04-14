@extends('layouts.layout')
@section('pageTitle')
    NHIS
@endsection

@section('content')
    <div class="box box-default" style="border: none;">

        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span
                    id='processing'><strong><em>Staff Search</em></strong></span></h3>
        </div>
        <div class="box box-success">
            <div class="box-body box-profile" style="margin:10px 20px;">
                <div class="row">
                    @includeIf('hr.Share.message')
                    <div class="box-body">

                        <form method="get" action="">
                            @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="description">Search BY Staff Name</label>
                                        <input type="text" id="fileNo" name="fileNo" class="form-control"
                                            placeholder="Enter Staff first name or last name " />
                                    </div>
                                </div>
                                <label for="month">&nbsp;</label><br />
                                <button name="action" id="searchBtn" class="btn btn-success" type="button">
                                    Search &nbsp; <i class="fa fa-save"></i>
                                </button>
                                <button name="action" id="refresh" class="btn btn-danger" type="button">
                                    refresh &nbsp;<i class="fa fa-refresh" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border">
                <h4 class="box-title text-uppercase">
                    NHIS Staff List
                </h4>
            </div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive" id="tableID">
                        @include('hr.nhis.nhisStaffTable')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script type="text/javascript">
        < script src = "{{ asset('assets/js/jquery-ui.min.js') }}" >
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            console.log('timely');

            $('#refresh').click(function() {
                location.reload();
            });


            $('#searchBtn').click(function() {
                console.log("hello");
                let name = $('#fileNo').val();

                $.ajax({
                    url: "/staff-nhis?name=" + name,
                    success: function(data) {


                        $('#tableID').html(data);


                    }
                });


            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Bind event to all category dropdowns using class selector
            $(document).on('change', '.hospitalCat', function() {
                var categoryId = $(this).val();
                var modal = $(this).closest('.modal'); // Limit scope to the current modal
                var hospitalSelect = modal.find('.hospitalID');

                hospitalSelect.empty().append('<option selected disabled>Loading...</option>');

                if (categoryId) {
                    $.ajax({
                        url: '/get-hospitals/' + categoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            hospitalSelect.empty().append(
                                '<option selected disabled>Select Hospital</option>');
                            $.each(data, function(key, hospital) {
                                hospitalSelect.append('<option value="' + hospital.id +
                                    '">' + hospital.name + '</option>');
                            });
                        },
                        error: function() {
                            hospitalSelect.empty().append(
                                '<option selected disabled>Error loading hospitals</option>'
                                );
                        }
                    });
                } else {
                    hospitalSelect.empty().append('<option selected disabled>Select Hospital</option>');
                }
            });
        });
    </script>
@endsection
