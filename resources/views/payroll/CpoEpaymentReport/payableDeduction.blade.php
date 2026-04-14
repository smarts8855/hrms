@extends('layouts.layout')

@section('pageTitle')
    Duduction Report
@endsection

@section('content')

    <div class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:0 5px;">
            <form method="POST"
             action="{{url('/cpo-deduction-payment/retrieve')}}"
             >
                {{ csrf_field() }}

                <div class="col-md-12 hidden-print">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> {{ session('msg') }}
                        </div>
                    @endif
                    @if (session('err'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Operation Error !<br></strong> {{ session('err') }}
                        </div>
                    @endif
                </div>

                <p>
                <h2 class="text-success text-center">
                    <strong>DEDUCTION PAYMENT</strong>
                </h2>
                </p>

                <div class="row">
                    <div class="col-sm-12">

                        <div style="margin: 0px  5%;">
                            <div class="form-group" style="margin-bottom: 5%;">

                                <div class="col-sm-12 row">
                                    <div class="col-sm-6">
                                        <label >Select a Year</label>
                                        
                                        <select name="year" id="section" class="form-control">
                                            
                                            <option value="">Select Year</option>
                                            @for($i=2010;$i<=2040;$i++)
                                                <option value="{{$i}}" @if(($activeMonth !== '') && $activeMonth->year == $i) selected @elseif($year == $i) selected @endif>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-sm-6">
                                        <label> Select a Month </label>
                                        <select name="month" id="section" class="form-control input-sm">

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

                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                              <label>Serial No</label>
                                              <input type="number" min="0" name="sn" required class="form-control" value="{{old('sn')}}" />
                                            </div>
                                          </div>
                                          <div class="col-sm-6">

                                          </div>

                                    <div class="col-sm-6 text-right" style="margin-top:10px;">
                                        <button type="submit" name="" class="btn btn-success"> <i class="fa fa-save"></i>
                                        Generate deduction report
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    </div>

    {{-- <div class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:0 5px;">
            <div class="box">
                <table class="table table-bordered table-striped table-highlight">
                    <thead>
                        <tr bgcolor="#c7c7c7">
        
                            <th> S/N</th>
                            <th> Name</th>
                            <th>Amount</th>
                            <th>Division</th>
                            
                        </tr>
                    </thead>
                    @php $i=1;@endphp

                    @if (count($monthControlVariables) > 0)
                    @foreach ($monthControlVariables as $con)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $con->surname }} {{ $con->first_name }} {{ $con->othernames }}</td>
                            <td>{{number_format($con->amount, '2', '.', ',')}}</td>
                            <td>{{ $con->division }}</td>
                            <td>{{ $con->grossTotal }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td style="font-weight:bold;">TOTAL</span></td>
                            <td></td>
                            <td style="font-weight:bold;">{{ $grossTotal }}</td>
                        </tr>
                    @else
                        <tr class="text-center">
                            <td colspan="4" class="text-danger">No Result found!...</td>
                        </tr>
                    @endif
                    
                </table>
                <hr />
            </div>
        </div>
    </div> --}}


@endsection
