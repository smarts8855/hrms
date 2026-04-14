@extends('layouts.layout')

@section('pageTitle')
  File Movement/Transfer
@endsection

<style type="text/css">

    .length
    {
    	width: 80px;
    }
    .remove
    {
    	padding-top: 12px;
    	cursor: pointer;
    }

</style>

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>

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

		                @if(session('err'))
		                    <div class="alert alert-warning alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		                        </button>
		                        <strong>Not Allowed ! </strong>
								{{ session('err') }}
						    </div>
		                @endif

		            </div>
					{{ csrf_field() }}

				<div class="col-md-12"><!--2nd col-->
					<div class="row">
						<div class="col-md-12">
						 <div class="row">
						  <div class="col-md-12">
						    <div class="box box-default">
						      <div class="box-header with-border hidden-print">
						        <h3 class="box-title">Search By First Name, Surname or File Number <span id='processing'></span></h3>
						      </div>
						      <form method="post" action="{{ url('staff/store') }}">
                                <div class="form-group">
                                    {{ csrf_field() }}
                                    <input type="text" id="search" name="q" class="form-control dos">
                                    <input type="hidden" id="nameID" name="nameID" />
                                </div>
						      </form>
						    </div>
						  </div><!-- /.col -->
						</div><!-- /.row -->


						</div><!-- /.col -->
						</div><!-- /.row -->



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
<script>
    $('.select2').select2();
</script>
<script type="text/javascript">
    $(document).ready(function() {
                var route = "{{ route('profile.search') }}";
                $('#search').typeahead({
                    source: function(query, process) {
                        return $.get(route, {
                            query: query
                        }, function(data) {
                            console.log(data)
                            return process(data);
                        });
                    }
                });
            }
</script>

@endsection
