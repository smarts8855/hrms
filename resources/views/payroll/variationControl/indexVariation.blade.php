@extends('layouts.layout')
@section('pageTitle')
Payroll Report
@endsection
@section('content')

  <div class="box-body" style="background:#FFF;">
<div style = "clear:both"></div>
    <div class="row">
      <div class="col-md-12"><!--1st col-->
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Error!</strong> 
          @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
        </div>
        @endif  
        @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> 
          {{ session('message') }}
        </div>                        
        @endif

         @if(session('err'))
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> 
          {{ session('err') }}
        </div>                        
        @endif

      </div>
      </div>
    </div>

  <div class="box-body" style="background:#FFF;">
    <div class="row">

    <h4 class="col-md-6" style="text-transform:uppercase">Payroll Report</h4>

      <form method="post" action="{{ url('/variation-control/view') }}" target="_blank">
      {{ csrf_field() }}
      <div class="col-md-12">
        <div class="row">
          @if ($CourtInfo->courtstatus==1)
        <div class="col-md-6">
              <div class="form-group">
                <label>Select Court</label>
                <select name="court" id="court" class="form-control" style="font-size: 13px;">
                  <option value="">Select Court</option>
                  @foreach($courts as $court)
                  @if($court->id == session('anycourt'))
                  <option value="{{$court->id}}" selected="selected">{{$court->court_name}}</option>
                @else
                <option value="{{$court->id}}" @if(old('court') == $court->id) selected @endif>{{$court->court_name}}</option>
                @endif
                  @endforeach
                </select>
                 
              </div>
            </div>
          @else
            <input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
          @endif

            @if ($CourtInfo->divisionstatus==1 && Auth::user()->is_global==1)
          <div class="col-md-6">
              <div class="form-group">
                <label>Select Division</label>  
                <select name="division" id="division_" class="form-control" style="font-size: 13px;">
                <option value="">Select Division</option>
                 @foreach($courtDivisions as $divisions)
                 <option value="{{$divisions->divisionID}}" @if(old('division') == $divisions->divisionID) @endif>{{$divisions->division}}</option>
                 @endforeach
                </select>
               </div>
              </div>
            @else
            <div class="col-md-6">
                <div class="form-group">
                    <label>Division</label>
                        <input type="text" class="form-control" id="divisionName" name="divisionName" value="{{$curDivision->division}}" readonly>
                </div>
            </div>
              <input type="hidden" id="division" name="division" value="{{Auth::user()->divisionID}}">
              <!--<input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">-->
            @endif
            
            <div class="col-md-6">
            <div class="form-group">
              <label >Select a Year</label>
              <select name="year" id="section" class="form-control">
                <option value="">Select Year</option>
                @for($i=2011;$i<=2040;$i++)
                 <option value="{{$i}}" @if(old('year') == $i) selected @endif>{{$i}}</option>
                @endfor
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label> Select a Month </label>
              <select name="month" id="section" class="form-control">
                <option value="">Select Month </option>
                <option value="JANUARY" @if(old('month') == 'JANUARY') selected @endif>January</option>
                <option value="FEBRUARY" @if(old('month') == 'FEBRUARY') selected @endif>February</option>
                <option value="MARCH" @if(old('month') == 'MARCH') selected @endif>March</option>
                <option value="APRIL" @if(old('month') == 'APRIL') selected @endif>April</option>
                <option value="MAY" @if(old('month') == 'MAY') selected @endif>May</option>
                <option value="JUNE" @if(old('month') == 'JUNE') selected @endif>June</option>
                <option value="JULY" @if(old('month') == 'JULY') selected @endif>July</option>
                <option value="AUGUST" @if(old('month') == 'AUGUST') selected @endif>August</option>
                <option value="SEPTEMBER" @if(old('month') == 'SEPTEMBER') selected @endif>September</option>
                <option value="OCTOBER" @if(old('month') == 'OCTOBER') selected @endif>October</option>
                <option value="NOVEMBER" @if(old('month') == 'NOVEMBER') selected @endif>November</option>
                <option value="DECEMBER" @if(old('month') == 'DECEMBER') selected @endif>December</option>
              </select>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="bankName">BANK NAME</label>
              <select name="bankName" id="bankName_"  class="form-control">
              <option value="">Select Bank</option>
                  @foreach($allbanklist as $list)
                 <option value="{{$list->bankID}}" @if(old('bankName') == $list->bankID)@endif>{{$list->bank}} </option>
                 @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Bank Group</label>
              <input type="text" name="bankGroup" id="bankGroup" class="form-control" value="{{old('bankGroup')}}" />
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div >
                <button type="submit" class="btn btn-success pull-right">Generate Schedule</button>
              </div>
            </div>           
          </div>
        </div>
      </div> 
      </form> 

    

      <form method="post" action="{{ url('payrollReport/bulk-report') }}">
      {{ csrf_field() }}
      <!--<div class="col-md-12">

      <br />
      <h4>Print Bulk Payroll Report</h4>
      <hr />

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label> Select a Month </label>
              <select name="month" id="section" class="form-control">
                <option value="">Select Month </option>
                <option value="JANUARY">January</option>
                <option value="FEBRUARY">February</option>
                <option value="MARCH">March</option>
                <option value="APRIL">April</option>
                <option value="MAY">May</option>
                <option value="JUNE">June</option>
                <option value="JULY">July</option>
                <option value="AUGUST">August</option>
                <option value="SEPTEMBER">September</option>
                <option value="OCTOBER">October</option>
                <option value="NOVEMBER">November</option>
                <option value="DECEMBER">December</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label >Select a Year</label>
              <select name="year" id="section" class="form-control">
                <option value="">Select Year</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
                <option value="2033">2033</option>
                <option value="2024">2034</option>
                <option value="2035">2035</option>
                <option value="2036">2036</option>
                <option value="2037">2037</option>
                <option value="2038">2038</option>
                <option value="2039">2039</option>
                <option value="2040">2040</option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div >
                <button type="submit" class="btn btn-success pull-right">Generate Report</button>
              </div>
            </div>           
          </div>
        </div>
      </div> -->
      </form>


    </div>
  </div><!-- /.col -->
</div><!-- /.row -->





      

@endsection


@section('styles')
@endsection


@section('scripts')

<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>


<script type="text/javascript">

$(document).ready(function(){
 
$("#court").on('change',function(e){
   e.preventDefault();
  var id = $(this).val();
//alert(id);
  $token = $("input[name='_token']").val();
 $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: murl +'/session/court',
 
  type: "post",
  data: {'courtID':id},
  success: function(data){
  location.reload(true);
  //console.log(data);
  }
});

});
 });
</script>


@endsection


