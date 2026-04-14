@extends('layouts.layout')
@section('pageTitle')
HOD Approval Dashboard
@endsection

@section('content')
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        <div class="box-header with-border hidden-print">
          <h1 class="box-title"> Welcome: <b style="border-radius: 25px;padding:6px;">{{ $userdetail->surname }}, {{ $userdetail->first_name}} {{ $userdetail->othernames}}; </b></h1> You are not permitted to perform activity on this page.
          <br>
          @php
            
            //use Carbon\Carbon;
            //$dt=Carbon::now();
            //$t=$dt->daysInMonth;
            //echo $t.'<br>';
            //$r=$dt->isWeekday();
            //echo $r.'<br>';
            //$rs=$dt->isWeekend();
            //echo $rs;
            //dd($rs);
            
          @endphp
        </div>
         @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Successful!</strong> {{ session('message') }}</div>
        @endif
        @if(session('error_message'))
        <div class="alert alert-error alert-dismissible" role="alert">
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
	
		
<div class="box-body">
 	

</div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
  function viewfunc(x,y)
    {
         document.getElementById('id').value = x;
         document.getElementById('comment').innerHTML = y;
                
        $("#viewModal").modal('show')
    }
  
  function apprfunc(x)
    {
        document.getElementById('ids').value = x;
        //document.getElementById('deleteid').value = null;
        //document.getElementById('courtid1').value = z;
       // document.getElementById('divid1').value = a;
        //document.getElementById('mmt').value = n;
        
        $("#apprModal").modal('show')
    }
    
   function rejectfunc(x)
    {
        document.getElementById('id2').value = x;
        //document.getElementById('deleteid').value = null;
        //document.getElementById('courtid1').value = z;
       // document.getElementById('divid1').value = a;
        //document.getElementById('mmt').value = n;
        
        $("#rejectModal").modal('show')
    }
    
    function cancelfunc(x)
    {
        document.getElementById('id3').value = x;
        //document.getElementById('deleteid').value = null;
        //document.getElementById('courtid1').value = z;
       // document.getElementById('divid1').value = a;
        //document.getElementById('mmt').value = n;
        
        $("#cancelModal").modal('show')
    }
    
	function  ReloadForm()
	{
	//alert("ururu")	;	
	document.getElementById('thisform').submit();
	return;
	}
	function  DeletePromo(id)
	{
		var cmt = confirm('You are about to delete a record. Click OK to continue?');
              if (cmt == true) {
					document.getElementById('delcode').value=id;
					document.getElementById('thisform').submit();
					return;
 
              }
	
	}
	function  View(id)
	{
		document.getElementById('viewid').value=id;
		document.getElementById('viewnewid').value=1;
		document.getElementById('thisform').submit();
		return;
 
              
	
	}
  	$( function() {
    $( "#startdate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#enddate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#approvedate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#incrementalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#firstArrivalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );
  </script>
@endsection
