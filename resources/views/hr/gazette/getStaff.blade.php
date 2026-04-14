@extends('layouts.layout')

@section('pageTitle')
 	Find Staff And Gazette
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		  <div class="box-body">
		        <div class="row">

		            @includeIf('Share.message')

				<div class="col-md-12"><!--2nd col-->
				   <form method="POST" action="{{url('gazette-new-staff-appointment')}}">
						@csrf
							<div class="row">
                                <div class="col-md-2"></div>
								<div class="col-md-8">
									<div class="form-group">
										<label for="description">Staff Name:</label>

										<input id="autocomplete" name="q" class="form-control input-lg" placeholder="Search By First Name, Surname or File Number">
               							<input type="hidden" id="fileNo"  name="fileNo">
										<span class="textbox"></span>
									</div>

									<div class="form-group">
										<label for="description">Gazette For:</label>

										<select name="gazetteStatus" id="" class="form-control">
											<option value="0"> --Select Gazette Status-- </option>
											@if (isset($gazetteStatus))
											@foreach ($gazetteStatus as $stat)
												<option value="{{$stat->id}}">{{$stat->status_name}}</option>
											@endforeach
											@endif
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
										<button type="submit" name="searchName" id="searchName" class="btn btn-default btn-lg"><i class="fa fa-search"></i> Search</button>
										
									</div>
								</div>
								</div>
							</div>
						</form>	
						
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		    
	</div>
</div>

@endsection


@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery-duplifer.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>


<script type="text/javascript">
  $(function() {
      $('#searchName').attr("disabled", true);
      $("#autocomplete").autocomplete({
        serviceUrl: murl + '/profile/searchUser',
        minLength: 2,
        onSelect: function (suggestion) {
            $('#fileNo').val(suggestion.data);
            $('#searchName').attr("disabled", false);
            showAll();
        }
      });
  });
</script>
@endsection
 