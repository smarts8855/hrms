@extends('layouts.layout')
@section('pageTitle')

@endsection
@section('content')
<div class="box-body" style="background:#FFF;">
	<div class="row">
<h4 class="col-md-8 col-md-offset-2" style="text-transform:uppercase;"> View New Salary Scale </h4>
	<div class="col-md-12">
           
	
	</div>
		<div class="col-md-12 col-md-offset-2">
			<div class="table-responsive">
			@php
			$ses = session('courtID');
			@endphp
				
            @foreach($emptype as $type)
			<a href = "{{url("/new/salaryScale/$type->id")}}"  class="btn btn-success" target="_blank" role="button">{{$type->employmentType}}</a>
            @endforeach
					
			 
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@endsection