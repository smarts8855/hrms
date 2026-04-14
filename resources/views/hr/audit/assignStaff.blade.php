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
       
      </div>
    </div>
  </div>
</div>
<div id="page-wrapper" class="box box-default">
<div class="box-body">
  <h2 class="text-center">Assign Staff</h2>
  <div class="row">
      <form method="post" action="{{url('/assign/user')}}">
       {{ csrf_field() }}
    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
        
                <table class="table table-bordered">
              <thead>
                    <tr>
                        <th>Active Month</th>
                        <th>Year</th>
                        <th>View Minutes</th>
                        <th>Next Action</th>
                        <th></th>
                    </tr>
              <thead>
              <tbody>
            @if($ifPushed > 1)
              <tr>
             <td>{{$activemonth->month}} </td>
             <td>{{$activemonth->year}}  </td>
              <td>
                 @if($view == 1)
                 <a href='{{url("/display/minutes/$activemonth->year/$activemonth->month")}}' target="_blank" class="btn btn-success btn-sm">View Minutes</a>
                 @endif
              </td>
              
               <td>
                <select name="staff" class="form-control">
                    <option value="">Select Staff to Assign</option>
                    @foreach($staffsections as $list)
                    <option value="{{$list->user_id}}"> {{$list->name}} </option>
                    @endforeach
                </select>
                <input type="hidden" value="{{$activemonth->year}}" name="year" />
                <input type="hidden" value="{{$activemonth->month}}" name="month" />
                
                <input type="submit" value="Assign/Re-assign" class="btn btn-Success" />
                 
             </td>
             
             <td>
                 @if($staff != '')
                 <strong>Assigned to: {{$staff->staffname}}</strong>
                 @endif
                 <br/>
                 @if($auditedComment != '')
                 <strong class="btn btn-success" style="cusor:pointer;" id="viewComment">Audit Staff Comment</strong>
                 @endif
             </td>
             
             </tr>
             
             @endif
              </tbody>
        </table>
       <hr />
       
      
      <div class="hidden-print"></div>
    </div>
    </form>
    
  </div>
  <!-- /.col --> 
  
</div>

<!-- confirm modal bootstrap -->


<div id="commentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Comment</h4>
            </div>
            <div class="modal-body">
           
           <p>@if(!empty($auditedComment)){{$auditedComment->comment}} @endif</p>
           <span>On @if(!empty($auditedComment)){{$auditedComment->updated_at }} @endif</span>
                   
            <div class="modal-footer">
                
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>
</div>

<!--// Confirm modal Bootstrap -->




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