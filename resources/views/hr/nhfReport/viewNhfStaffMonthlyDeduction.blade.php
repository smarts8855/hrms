@extends('layouts.layout')
@section('pageTitle')
    UPDATE NHF STAFF DEDUCTION
@endsection

@section('content')
    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>

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
                                    
                                    <option value="{{$month}}" {{isset($month) ? 'selected' : '' }}>{{$month}}</option>
                                    
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
                                    <option value="{{$year}}" {{isset($year) ? 'selected' : '' }}>{{$year}}</option>
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

    @isset($monthlyDeduction)

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="box-header with-border hidden-print text-center">
                <h3 class="box-title"><b>@yield('pageTitle')</b></h3><br><em> <b>{{$month}} {{$year}}<b></em>
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
                            <th>GRADE LEVEL</th>
                            <th>NHF Deduction.</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp

                        @forelse ($monthlyDeduction as $list)
                            <tr>

                                <td>{{ $i++ }}</td>
                                <td>{{$list->surname}} {{$list->first_name}} {{$list->othernames}}</td>
                                <td>{{$list->fileNo}}</td>
                                <td>{{$list->Dept}}</td>
                                <td>{{$list->grade}}</td>
                                <td>{{$list->NHF}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-backdrop="false" data-target="#confirmToSubmit{{$list->perID}}">Update Deduction.</button>
                                </td>

                            </tr>

                            <form action="{{url('nhf-staff-monthly-deduction-update/'.$list->perID)}}" method="POST">
                            @csrf @method('PUT')
                            <!-- Modal to delete -->
                            <div class="modal fade text-left d-print-none" id="confirmToSubmit{{$list->perID}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h4 class="modal-title text-white"><i class="ti-save"></i> Update NHF Deduction!</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="row">
                                        <div class="modal-body">
                                            <div class="text-success text-center"> <h4>You want to update deduction For {{$list->surname}} {{$list->first_name}} </h4></div>

                                                <input type="hidden" name="month" value="{{$month}}">
                                                <input type="hidden" name="year" value="{{$year}}">
                                                <div class="form-group">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <label for="deduction">Deduction Amount</label>
                                                        <input type="text" class="form-control" name="deduction" value="{{$list->NHF}}">
                                                    </div>
                                                    
                                                </div>
                                        </div>
                                        </div>

                                        <div class="row">
                                        <div class="modal-footer col-md-8 col-md-offset-2">
                                            <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                            <button type="submit" class="btn btn-info">Yes Continue</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                    <!--end Modal-->

                        @empty

                            <h4 class="alert alert-warning"><em>Salary has not been computed for {{$month}} {{$year}}</em></h4>

                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{$monthlyDeduction->appends(request()->input())->links()}}
            </div>

        </div>
    </div>
    @endisset

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

