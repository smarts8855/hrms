@extends('layouts.layout')

@section('pageTitle')
 	Search Gazette
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
				   <form method="POST" action="{{url('search-gazette')}}">
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
<style> 
  .textbox { 
    border: 1px;
    background-color: #33AD0A; 
    outline:0; 
    height:25px; 
    width: 275px; 
  } 
  $('.autocomplete-suggestions').css({
    color: 'red'
  });

  .autocomplete-suggestions{
    color:#fff;
    font-size: 15px;
  }
</style> 
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
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
 