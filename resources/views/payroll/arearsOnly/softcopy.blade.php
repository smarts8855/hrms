@extends('layouts.layout')
@section('pageTitle')
Export SoftCopy
@endsection

@section('content')
<form method="post" action="{{ url('/arrears/softcopy') }}">

  <div class="box-body">
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

        @if(session('msg'))

        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> 
          {{ session('msg') }}
        </div>                        
        @endif
        @if(session('warning'))
        <div class="alert alert-info alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Info!</strong> 
          {{ session('warning') }}
        </div>                        
        @endif

      </div>
      {{ csrf_field() }}

      <div class="col-md-4 col-md-offset-4"><!--2nd col-->
        <div class="row">
            @if ($CourtInfo->divisionstatus==1 && Auth::user()->is_global==1)
						<div class="col-md-12">
							<div class="form-group">
							  <label>Select Division</label>  
							  <select name="division" id="division_" class="form-control" style="font-size: 13px;">
							  <option value="">All</option>
							   @foreach($courtDivisions as $divisions)
							   <option value="{{$divisions->divisionID}}" @if(old('division') == $divisions->divisionID) @endif>{{$divisions->division}}</option>
							   @endforeach
							  </select>
							 </div>
							</div>
						  @else
							<div class="col-md-12">
							  <div class="form-group">
								  <label>Division</label>
									  <input type="text" class="form-control" id="divisionName" name="divisionName" value="{{$curDivision->division}}" readonly>
							  </div>
						  </div>
							<input type="hidden" id="division" name="division" value="{{Auth::user()->divisionID}}">
							{{-- <input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}"> --}}
						  @endif
        <div class="col-md-12">
            <div class="form-group">
                <label for="month">Report Type</label>
                <select name="rptType" id="rptType" class="form-control" onchange="setTextField(this)">
                      <option value="" selected="selected">Select</option>
                    
                  <option value="netpay">Total Net Arrears</option>
                  <option value="tax">PAYE</option>
                  <option value="pension">Pension</option>
                  <option value="totalDeduct">Total Deduction</option>
                  <option value="cumEmolu">Gross Emolument</option>
                </select>
                <input id="make_text" type = "hidden" name = "make_text" value = "" />
            </div>
            <div id="currentStateDiv" class="form-group" style="display: none">
                <label>State/Residential</label>
                <select name="currentState" id="currentState" class="form-control">
                <option value="" selected>Select State/Residential</option>
                  @foreach ($StateList as $s)
                  <option value="{{ $s->State }}" {{ (old("currentState") == $s->State ? "selected":"") }}>{{ $s->State }}</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="month">Month</label>
              <select name="month" id="month" class="form-control input-sm">
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
          <div class="col-md-12">
          <div class="form-group">
            <label for="year">Year</label>
            <select name="year" id="year" class="form-control input-sm">
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
        <div class="col-md-12" id="currentWorkingStateDiv">
            <div class="form-group">
                <label for="division">Current Working State</label>
                <select name="currentWorkingState" id="currentWorkingState" class="form-control">
                      <option value="" selected="selected">Select</option>
                      @foreach($currentDivision as $division)
                         <option value="{{$division-> division}}">{{$division -> division}}</option>
                      @endforeach
                </select>
            </div>
          </div>

      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for=""></label>
            <div align="right">
              <input class="btn btn-success" name="btn" type="submit" value="Export Soft Copy"/>
              <input class="btn btn-success" name="reset" type="reset" value="Reset" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->
</form>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">

      function setTextField(ddl) {
          document.getElementById('make_text').value = ddl.options[ddl.selectedIndex].text;
      }

      $('#currentWorkingStateDiv').hide();

      (function () {
      $('#rptType').change( function(){
        if ($('#rptType').val() == 'tax'){
          $('#currentStateDiv').show();
        }
      });}) ();

      (function () {
      $('#rptType').change( function(){
        if ($('#rptType').val() != 'tax'){
          $('#currentStateDiv').hide();
        }
      });}) ();

   </script>
@endsection