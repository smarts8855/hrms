@extends('layouts.layout')
@section('pageTitle')
    NHF
@endsection

@section('content')
    <div class="box-body" style="background:#FFF;">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span
                    id='processing'><strong><em>Staff List.</em></strong></span></h3>
        </div>

        <div class="row">

            @includeIf('Share.message')

            <div class="col-md-12">
                <!--2nd col-->
                {{-- <form method="GET" action="{{ url('update-staff-nhf-no') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="description">Staff Name:</label>

                                <input id="autocomplete" name="q" class="form-control input-lg"
                                    placeholder="Search By First Name, Surname or File Number">
                                <input type="hidden" id="fileNo" name="fileNo">
                                <span class="textbox"></span>
                            </div>

                        </div>
                        <div class="col-md-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-9">
                                <div align="right" class="form-group">
                                    <label for="month">&nbsp;</label><br />
                                    <button type="submit" name="searchName" id="searchName"
                                        class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Search</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form> --}}

            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12">
                <div class="box-header with-border hidden-print text-center">
                    {{-- <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3> --}}
                    <hr>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-condensed table-bordered">
                        <thead class="text-gray-b">
                            <tr>
                                <th>S/N</th>
                                <th>STAFF NAME</th>
                                <th>FILE No.</th>
                                <th>DEPARTMENT</th>
                                <th>GRADE & STEP</th>
                                <th>NHF No.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp

                            @foreach ($nhfStaffList as $list)
                                <tr>

                                    <td>{{ $i++ }}</td>
                                    <td>{{ $list->surname }} {{ $list->first_name }} {{ $list->othernames }}</td>
                                    <td>{{ $list->fileNo }}</td>
                                    <td>{{ $list->Dept }}</td>
                                    <td>{{ $list->grade }}|{{$list->step}}</td>
                                    <td>{{ $list->nhfNo }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-backdrop="false" data-target="#confirmToSubmit{{ $list->ID }}">Update
                                            Nhf No.</button>
                                    </td>

                                </tr>

                                <form action="{{ url('update-staff-nhf-no') }}" method="GET">
                                    @csrf
                                    <!-- Modal to delete -->
                                    <div class="modal fade text-left d-print-none" id="confirmToSubmit{{ $list->ID }}"
                                        tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h4 class="modal-title text-white"><i class="ti-save"></i> Update NHF
                                                        No!</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="fileNo" value="{{ $list->ID }}">
                                                    <div class="text-success text-center">
                                                        <h4>Are you sure you want to update NHF No. For
                                                            {{ $list->surname }} {{ $list->first_name }}
                                                            {{ $list->othernames }}? </h4>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-info"
                                                        data-dismiss="modal"> Cancel </button>
                                                    <button type="submit" class="btn btn-info">Yes Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end Modal-->
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $nhfStaffList->links() }}
                </div>
            </div>
        </div>
    </div>
    </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .init {
            line-height: 30px;
        }

        .table-responsive {
            max-height: 800px;
            overflow: auto;
        }

        .textbox {
            border: 1px;
            background-color: #33AD0A;
            outline: 0;
            height: 25px;
            width: 275px;
        }

        $('.autocomplete-suggestions').css({
            color: 'red'
        });

        .autocomplete-suggestions {
            color: #fff;
            font-size: 15px;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            $('#searchName').attr("disabled", true);
            $("#autocomplete").autocomplete({
                serviceUrl: murl + '/profile/searchUser',
                minLength: 2,
                onSelect: function(suggestion) {
                    $('#fileNo').val(suggestion.data);
                    $('#searchName').attr("disabled", false);
                    showAll();
                }
            });
        });
    </script>
@endsection
