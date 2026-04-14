@extends('layouts.layout')
@section('pageTitle')
 Staff Designation
@endsection

@section('content')
<div id="page-wrapper" class="box box-default">
  <div class="container-fluid">
    
    <hr >
    <div class="row">
      <div class="col-md-9"> <br>
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Error!</strong> @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach </div>
        @endif                       
        
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
       
       <h3>Salary Audit Report</h3>
       
       <form method="post" action="{{url('/salary-audit/report')}}">
           {{ csrf_field() }}
           <div class="row">
             <div class="col-md-10">
				<div class="form-group">
				<label for="bank">Year</label>
				<select name="year" id="section" class="form-control">
                <option value="">Select Year</option>
                @for($i=2011;$i<=2040;$i++)
                 <option value="{{$i}}" @if(session('yr') == $i) selected @endif>{{$i}}</option>
                @endfor
              </select>
					</div>
				</div>
				
				<div class="col-md-1">
				<div class="form-group">
				<label>&nbsp;</label>
				<input type="submit" value="Submit" class="btn btn-success" />
				</div>
				</div>
          </div>  
       </form>
       
      </div>
    </div>
  </div>
</div>
<div id="page-wrapper" class="box box-default">
<div class="box-body">
  <h2 class="text-center"></h2>
  <div class="row">
      
    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
        
                <table class="table table-bordered">
              <thead>
                <tr>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Processed By</th>
                </tr>
              <thead>
              <tbody>
           
           @foreach($report as $list)
              <tr>
             <td>{{$list->month}} </td>
             <td>{{$list->year}}  </td>
              <td>{{$list->staffname}}</td>
             </tr>
             @endforeach
             
           
              </tbody>
        </table>
       <hr />
       
      
      <div class="hidden-print"></div>
    </div>
   
    
  </div>
  <!-- /.col --> 
  
</div>






@endsection 

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<style type "text/css">
<!--
/* @group Blink */
.blink {
	-webkit-animation: blink .75s linear infinite;
	-moz-animation: blink .75s linear infinite;
	-ms-animation: blink .75s linear infinite;
	-o-animation: blink .75s linear infinite;
	 animation: blink .75s linear infinite;
	 color:red;
}
@-webkit-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-moz-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-ms-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-o-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
/* @end */
-->
</style>
@stop

@section('scripts')

<script type="text/javascript" src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>

 function getPetitionByType()
    {
        var petitionValue =  $('#petitionType').val();
        if(petitionValue != "" ){
            $('#petitionForm').submit();
            
            
        }
    }

</script>

<script>

 function getPetitionByStatus()
    {
        var petitionValue =  $('#petitionStatus').val();
        if(petitionValue != "" ){
            $('#petitionForm').submit();
        }
    }
    
    
$( function(){
   $("#from").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
   $("#to").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    });
 $(document).ready(function() {
    $('#').DataTable();
  } );

  $(document).ready(function() {
      $('#mytable').DataTable( {
          dom: 'Bfrtip',
          "pageLength": 100
          buttons: [
              {
                  extend: 'print',
                  customize: function ( win ) {
                      $(win.document.body)
                          .css( 'font-size', '10pt' )
                          .prepend(
                              ''
                          );
   
                      $(win.document.body).find( 'table' )
                          .addClass( 'compact' )
                          .css( 'font-size', 'inherit' );
                  }
              }
          ]
      } );
  } );

</script>

<script>
    $(document).ready(function(){
  
    $("#viewComment").click(function(){
       
        $("#commentModal").modal('show');
    });
});
</script>

@stop