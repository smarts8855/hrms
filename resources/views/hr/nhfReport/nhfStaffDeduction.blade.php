@extends('layouts.layout')
@section('pageTitle')
    NHF
@endsection

@section('content')
    <div class="box-body" style="background:#FFF;">

        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i>  <span id='processing'><strong><em>NHF Staff Deduction.</em></strong></span></h3>
        </div>

        <div class="row">
            

            @includeIf('Share.message')

            <div class="col-md-12">
                <!--2nd col-->
                <form method="GET" action="{{url('nhf-staff-monthly-deduction')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="description">Staff Name</label>

                                <input id="autocomplete" name="q" class="form-control input-lg"
                                    placeholder="Search By First Name, Surname or File Number">
                                <input type="hidden" id="fileNo" name="fileNo">
                                <span class="textbox"></span>
                            </div>

                        </div>
                        <div class="col-md-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="month">Month</label>

                                <select name="month" class="form-control">
                                    <option value=""> --Select-- </option>
                                    <option value="january">January</option>
                                    <option value="february">February</option>
                                    <option value="march">March</option>
                                    <option value="april">April</option>
                                    <option value="may">May</option>
                                    <option value="june">June</option>
                                    <option value="july">July</option>
                                    <option value="august">August</option>
                                    <option value="september">September</option>
                                    <option value="october">October</option>
                                    <option value="november">November</option>
                                    <option value="december">December</option>
                                </select>

                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="description">Year</label>
                                @php $count = 2050; @endphp
                                <select name="year" id="" name="year" class="form-control">
                                    <option value=""> --Select-- </option>

                                        @for ($i = 2020; $i <= $count; $i++)
                                            <option value="{{$i}}"> {{$i}} </option>
                                        @endfor

                                </select>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-9">
                                <div align="right" class="form-group">
                                    <label for="month">&nbsp;</label><br />
                                    <button type="submit" name="searchName" id=""
                                        class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Search</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->


    </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
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

        $('.autocomplete-suggestions').css( {
                color: 'red'
            }

        );

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
