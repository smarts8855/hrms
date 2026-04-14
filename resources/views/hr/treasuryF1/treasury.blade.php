@extends('layouts.layout')

@section('pageTitle')
  Deductions Report(Treasury 209)
@endsection

@section('content')
  <form method="post" action="{{ url('/treasuryf1/view') }}">

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

            </div>
			{{ csrf_field() }}
            
				<input type="hidden" name="codeID" id="codeID">

				<div class="col-md-12"><!--2nd col-->
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="reporttype">Report Type</label>
								<select name="reportType" id="reporttype" required="true" class="form-control" onchange="check(this.value)">
									<option>Select</option>
									@foreach($reporttype as $type)
									<option value="{{$type->determinant}}" @if (old('reporttype') == $type->determinant) {{ 'selected' }} @endif>{{$type->addressName}}</option>
									@endforeach
									@foreach($cvSetup as $type)
									<option value="{{$type->ID}}" @if (old('reporttype') == $type->ID) {{ 'selected' }} @endif>{{$type->description}}</option>
									@endforeach
								</select>   
							</div>
						</div>
									
						<div class="col-md-6">
							<div class="form-group">
								<label for="year">Select Year</label>
								<select name="year" id="year" class="form-control">
									<option></option>
									<option @if (old('year') == "2010") {{ 'selected' }} @endif value="2010">2010</option>
									<option @if (old('year') == "2011") {{ 'selected' }} @endif value="2011">2011</option>
									<option @if (old('year') == "2012") {{ 'selected' }} @endif value="2012">2012</option>
									<option @if (old('year') == "2013") {{ 'selected' }} @endif value="2013">2013</option>
									<option @if (old('year') == "2014") {{ 'selected' }} @endif value="2014">2014</option>
									<option @if (old('year') == "2015") {{ 'selected' }} @endif value="2015">2015</option>
									<option @if (old('year') == "2016") {{ 'selected' }} @endif value="2016">2016</option>
									<option @if (old('year') == "2017") {{ 'selected' }} @endif value="2017">2017</option>
									<option @if (old('year') == "2018") {{ 'selected' }} @endif value="2018">2018</option>
									<option @if (old('year') == "2019") {{ 'selected' }} @endif value="2019">2019</option>
									<option @if (old('year') == "2020") {{ 'selected' }} @endif value="2020">2020</option>
									<option @if (old('year') == "2021") {{ 'selected' }} @endif value="2021">2021</option>
									<option @if (old('year') == "2022") {{ 'selected' }} @endif value="2022">2022</option>
									<option @if (old('year') == "2023") {{ 'selected' }} @endif value="2023">2023</option>
									<option @if (old('year') == "2024") {{ 'selected' }} @endif value="2024">2024</option>
									<option @if (old('year') == "2025") {{ 'selected' }} @endif value="2025">2025</option>
									<option @if (old('year') == "2026") {{ 'selected' }} @endif value="2026">2026</option>
									<option @if (old('year') == "2027") {{ 'selected' }} @endif value="2027">2027</option>
									<option @if (old('year') == "2028") {{ 'selected' }} @endif value="2028">2028</option>
									<option @if (old('year') == "2029") {{ 'selected' }} @endif value="2029">2029</option>
									<option @if (old('year') == "2030") {{ 'selected' }} @endif value="2030">2030</option>
									<option @if (old('year') == "2031") {{ 'selected' }} @endif value="2031">2031</option>
									<option @if (old('year') == "2032") {{ 'selected' }} @endif value="2032">2032</option>
									<option @if (old('year') == "2033") {{ 'selected' }} @endif value="2033">2033</option>
									<option @if (old('year') == "2034") {{ 'selected' }} @endif value="2024">2034</option>
									<option @if (old('year') == "2035") {{ 'selected' }} @endif value="2035">2035</option>
									<option @if (old('year') == "2036") {{ 'selected' }} @endif value="2036">2036</option>
									<option @if (old('year') == "2037") {{ 'selected' }} @endif value="2037">2037</option>
									<option @if (old('year') == "2038") {{ 'selected' }} @endif value="2038">2038</option>
									<option @if (old('year') == "2039") {{ 'selected' }} @endif value="2039">2039</option>
									<option @if (old('year') == "2040") {{ 'selected' }} @endif value="2040">2040</option>
								</select>
							</div>
						</div>
						
					</div>
								
					<div class="row">
					<div class="col-md-6">
							<div class="form-group">
								<label for="month">Select Month</label>
								<select name="month" id="month" class="form-control">
									<option></option>
									<option @if (old('month') == "January") {{ 'selected' }} @endif value="January">January</option>
									<option @if (old('month') == "February") {{ 'selected' }} @endif value="February">February</option>
									<option @if (old('month') == "March") {{ 'selected' }} @endif value="March">March</option>
									<option @if (old('month') == "April") {{ 'selected' }} @endif value="April">April</option>
									<option @if (old('month') == "May") {{ 'selected' }} @endif value="May">May</option>
									<option @if (old('month') == "June") {{ 'selected' }} @endif value="June">June</option>
									<option @if (old('month') == "July") {{ 'selected' }} @endif value="July">July</option>
									<option @if (old('month') == "August") {{ 'selected' }} @endif value="August">August</option>
									<option @if (old('month') == "September") {{ 'selected' }} @endif value="September">September</option>
									<option @if (old('month') == "October") {{ 'selected' }} @endif value="October">October</option>
									<option @if (old('month') == "November") {{ 'selected' }} @endif value="November">November</option>
									<option @if (old('month') == "November") {{ 'selected' }} @endif value="December">December</option>
								</select>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label for="bank">Select Bank</label>
								<select name="bank" id="bank" class="form-control">
									<option selected></option>
									@foreach($bank as $bk)
										<option @if (old('bank') == $bk->bankID) {{ 'selected' }} @endif value="{{$bk->bankID}}">{{$bk->bank}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="bankgroup">Bank Group</label>
								<input type="Text" name="bankgroup" placeholder="Enter Bank Group" id="bankgroup" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<!--<div class="form-group" id="workingstatehide">
								<label for="workingstate">Current working state</label>
								<select name="workingstate" id="workingstate" class="form-control">
									<option selected></option>
									@foreach($workingstate as $ws)
										<option value="{{$ws->State}}">{{$ws->State}}</option>
									@endforeach
							   </select>
							</div>-->
						</div>
					</div>			
					<div align="right" class="form-group">
						<button name="action" id="action" class="btn btn-success" type="submit">View Report</button>
					</div>
				</div>
        </div><!-- /.col -->
    </div><!-- /.row -->
  </form>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
  	(function () {
	$('#reporttype').change( function(){
			if ($('#reporttype').val() != 'TAX'){
				$('#workingstatehide').hide();
			}
			if ($('#reporttype').val() == 'TAX'){
				$('#workingstatehide').show();
			}	
	});}) ();

</script>
@endsection