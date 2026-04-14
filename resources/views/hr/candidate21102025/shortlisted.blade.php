@extends('layouts.layout')
@section('pageTitle')
Candidate Shortlisted for Appointment
@endsection

@section('content')
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>

	   
            @if(session('message'))
	        <div class="alert alert-success alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
	          <strong>Successful!</strong> {{ session('message') }}</div>
	        @endif
	        @if(session('error_message'))
	        <div class="alert alert-danger alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
	          <strong>Error!</strong> {{ session('error_message') }}</div>
	        @endif


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
	
            <div class="table-responsive" style="font-size: 12px; padding:10px;">
            <table class="table table-bordered table-striped table-highlight" >
            <thead>
            <tr bgcolor="#c7c7c7">
                            <th width="1%">S/N</th>	 
                            <th >Fullname</th>
                            <th >Sex</th>
                            <th >Address</th>
                            <th >State</th>
                            <th >LGA</th>
                            <th >Action</th>
            </tr>
            </thead>
                        @php $serialNum = 1; @endphp

                        @foreach ($data as $b)
                            <tr>
                            <td>{{ $serialNum ++}}</td>

                                <td>{{$b->surname}} {{$b->first_name}} {{$b->othernames}}</td>
                                <td>{{$b->sex}}</td>
                                <td>{{$b->address}}</td>
                                <td>{{$b->State}}</td>
                                <td>{{$b->lga}}</td>
                                <td> 
                                    
                                </td>

                            </tr>
                        @endforeach
            </table>
            </div>
             <a href="{{ url('/interview')}}" class="btn btn-warning">Go Back</a>
        </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>  
    <script>
        CKEDITOR.replace( 'editor' );
    </script>

<script type="text/javascript">
     
     $("#state").change(function(e){
    
    //console.log(e);
    var state_id = e.target.value;
   //var state_id = $(this).val();
    
    //alert(state_id);
    //$token = $("input[name='_token']").val();
    //ajax
    $.get('../get-lga-from-state?state_id='+state_id, function(data){
    $('#lga').empty();
    //console.log(data);
    $('#lga').append( '<option value="">Select One</option>' );
    $.each(data, function(index, obj){
    $('#lga').append( '<option value="'+obj.lgaId+'">'+obj.lga+'</option>' );
    });
    
    
    })
});
</script>
@endsection
