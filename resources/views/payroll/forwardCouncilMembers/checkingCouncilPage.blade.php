@extends('layouts.layout')
@section('pageTitle')
  Justices  Payroll Summary
@endsection
@section('content')
    <form method="post" action="{{ url('/council-members/payroll-vc') }}">
        <div class="box-body" style="background:#FFF;">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title pull-center">@yield('pageTitle')
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!--1st col-->
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong>
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong>
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="row">

                        @if ($CourtInfo->courtstatus == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Court</label>
                                    <select name="court" id="court" class="form-control" style="font-size: 13px;">
                                        <option value="">Select Court</option>
                                        @foreach ($courts as $court)
                                            @if ($court->id == session('anycourt'))
                                                <option value="{{ $court->id }}" selected="selected">
                                                    {{ $court->court_name }}</option>
                                            @else
                                                <option value="{{ $court->id }}"
                                                    @if (old('court') == $court->id) selected @endif>
                                                    {{ $court->court_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        @else
                            <input type="hidden" id="court" name="court" value="{{ $CourtInfo->courtid }}">
                        @endif

                        @if (Auth::user()->is_global == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Division</label>
                                    <select name="division" id="division_" class="form-control" style="font-size: 13px;">
                                        <option value="">Select Division</option>
                                        @foreach ($courtDivisions as $divisions)
                                            <option value="{{ $divisions->divisionID }}"
                                                @if (old('division') == $divisions->divisionID)  @endif>{{ $divisions->division }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Division</label>
                                    <input type="text" class="form-control" id="divisionName" name="divisionName"
                                        value="{{ $curDivision->division }}" readonly>
                                </div>
                            </div>
                            <input type="hidden" id="division" name="division" value="{{ Auth::user()->divisionID }}">
                            <!--<input type="hidden" id="division" name="division" value="{{ $CourtInfo->divisionid }}">-->
                        @endif

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Select a Month </label>
                                <select name="month" id="section" class="form-control">
                                    <option value="">Select Month </option>
                                    <option value="JANUARY" @if(($activeMonth !== '') && $activeMonth->month == 'JANUARY') selected @elseif ($month == 'JANUARY') selected @endif>January</option>
                                    <option value="FEBRUARY" @if(($activeMonth !== '') && $activeMonth->month == 'FEBRUARY') selected @elseif($month == 'FEBRUARY') selected @endif>February</option>
                                    <option value="MARCH" @if(($activeMonth !== '') && $activeMonth->month == 'MARCH') selected @elseif ($month == 'MARCH') selected @endif>March</option>
                                    <option value="APRIL" @if(($activeMonth !== '') && $activeMonth->month == 'APRIL') selected @elseif ($month == 'APRIL') selected @endif>April</option>
                                    <option value="MAY" @if(($activeMonth !== '') && $activeMonth->month == 'MAY') selected @elseif ($month == 'MAY') selected @endif>May</option>
                                    <option value="JUNE" @if(($activeMonth !== '') && $activeMonth->month == 'JUNE') selected @elseif ($month == 'JUNE') selected @endif>June</option>
                                    <option value="JULY" @if(($activeMonth !== '') && $activeMonth->month == 'JULY') selected @elseif ($month == 'JULY') selected @endif>July</option>
                                    <option value="AUGUST" @if(($activeMonth !== '') && $activeMonth->month == 'AUGUST') selected @elseif ($month == 'AUGUST') selected @endif>August</option>
                                    <option value="SEPTEMBER" @if(($activeMonth !== '') && $activeMonth->month == 'SEPTEMBER') selected @elseif ($month == 'SEPTEMBER') selected @endif>September</option>
                                    <option value="OCTOBER" @if(($activeMonth !== '') && $activeMonth->month == 'OCTOBER') selected @elseif ($month == 'OCTOBER') selected @endif>October</option>
                                    <option value="NOVEMBER" @if(($activeMonth !== '') && $activeMonth->month == 'NOVEMBER') selected @elseif ($month == 'NOVEMBER') selected @endif>November</option>
                                    <option value="DECEMBER" @if(($activeMonth !== '') && $activeMonth->month == 'DECEMBER') selected @elseif ($month == 'DECEMBER') selected @endif>December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select a Year</label>
                                <select name="year" id="year" class="form-control">
                                    <option value="">Select Year</option>
                                    @for($i=2010;$i<=2040;$i++)
                                        <option value="{{$i}}" @if(($activeMonth !== '') && $activeMonth->year == $i) selected @elseif($year == $i) selected @endif>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                              <label></label>
                              <div >
                                <button type="button" id="locationButton" class="btn btn-primary">View Location</button>
                                <button type="submit" class="btn btn-success">Display Payroll</button>
                              </div>
                            </div>           
                          </div>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </form>

    <form id="location" method="post" action={{ url('/council-members-payroll-location') }}>
        {{ csrf_field() }}
        <input type="hidden" id="locationMonth" name="month"/>
        <input type="hidden" id="locationYear" name="year"/>
      </form>
      

@endsection
@section('styles')
@endsection

@section('scripts')

<script>
    document.getElementById('locationButton').addEventListener('click', function() {
        const month = document.getElementById('section').value
        const year = document.getElementById('year').value
        document.getElementById('locationMonth').value = month
        document.getElementById('locationYear').value = year
        document.getElementById('location').submit();
    });
  </script>

    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#court").on('change', function(e) {
                e.preventDefault();
                var id = $(this).val();
                //alert(id);
                $token = $("input[name='_token']").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $token
                    },
                    url: murl + '/session/court',

                    type: "post",
                    data: {
                        'courtID': id
                    },
                    success: function(data) {
                        location.reload(true);
                        //console.log(data);
                    }
                });

            });
        });
    </script>
@endsection
