@extends('layouts.layout')
@section('pageTitle')
Add New Bank
@endsection

@section('content')
	<div class="box box-default">

		<form method="post" action="{{ url('/banklist/store') }}">
		{{ csrf_field() }}
		    <div class="col-md-12 text-success"><!--2nd col-->
                <big><b>@yield('pageTitle')</b></big>
            </div>
            <br />
            <hr >

		<div class="row" style="margin: 5px 10px;">
			<div class="col-md-12">
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
			

			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="bankName">Enter New Bank</label>
							<input type="Text" name="bankName" placeholder="Enter Bank Name" id="" class="form-control">
						</div>
					</div>
				</div>			
				<div align="right" class="form-group">
				   @permission('can-edit')
						<button name="action" class="btn btn-success" type="submit"> Add New Bank</button>
				   @endpermission
				</div>
			</div>
		</div><!-- /.col -->
</form>

	<div class="box-body">
		<hr>
		<div align="center"><strong>AVAILABLE BANKS</strong></div>
		<br />

		<table class="table table-hover table-striped table-responsive table-condensed">
			<thead>
				<tr>
					<th>Bank Name</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($allbanklist as $bl)
				<tr>
					<td>{{$bl -> bank}}</td>
					<th>
						<div align="right">
							<a href="{{url('/banklist/remove/'.($bl->bankID))}}" title="Remove" class="btn btn-danger deleteBankList" id="delete{{$bl->bankID}}"> <i class="fa fa-trash"></i> </a>
						</div>
					</th>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>
</div>

@stop
