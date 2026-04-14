@extends('layouts.layout')
@section('pageTitle')
  Annual Leave Application

@endsection

@section('content')
<div id="removeModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <p class="modal-title">Delete Application</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" action="{{ url('remove/application') }}" method="post"  role="form">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    
                    <div class="col-sm-12">
                     <center><p>Are you sure?</p></center>
                    
                    </div>
                    <input type="hidden" id="removeid" name="id" value="">
                    
                   
                </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-xs">Yes</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">No</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
<div id="viewModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Comment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal"
                    role="form">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    
                    <div class="col-sm-12">
                     <center><h5 id="comment"></h5></center>
                    
                    </div>
                    <input type="hidden" id="id" name="id" value="">
                    
                   
                </div>
            </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Close</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
       	  
        <div class="box-header with-border hidden-print">
          <h1 class="box-title"><i class="fa fa-user"></i>Welcome: <b style="border-radius: 25px;padding:6px;">{{ $userdetail->surname }}, {{ $userdetail->first_name}} {{ $userdetail->othernames}}</b></h1>.
          <br>
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
	<form method="post" id="form1" name="form1" class="form-horizontal">
		{{ csrf_field() }}
		<div class="box-body">
		    
		    <p><i>You are not authorised to do anything on this page!</i></p>
			 
	            
		</div>
	          
	</form>	

		
	
	
</div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>
 
 $(document).ready(function() {
    $('#').DataTable();
  } );

  $(document).ready(function() {
      $('#mytable').DataTable( {
          dom: 'Bfrtip',
          //"pageLength": 1,
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
  <script type="text/javascript">
    
   function removefunc(x)
    {
        document.getElementById('removeid').value = x;
                        
        $("#removeModal").modal('show')
    }


    function viewfunc(x,y)
    {
         document.getElementById('id').value = x;
         document.getElementById('comment').innerHTML = y;
                
        $("#viewModal").modal('show')
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
  <script>
       $(document).ready(function(){

    $("#select1").change(function(e){
    
        //var recordid = e.target.value;
        //alert(recordid);
        
        //var x = document.getElementById("hidediv");
        
        $.get('/get-leavedays', function(data){
        //$('#divs2').empty();
        console.log(data);
        if(recordid==1)
        {
            $('#ok').append( '<i class="glyphicon glyphicon-ok" style="color:green" ></i>' );
            x.style.display = "none";
            $('#oks').empty();
        }
        else if(recordid==0)
        {
            $('#oks').append( '<i class="glyphicon glyphicon-remove" ></i>' );
            x.style.display = "none";
            $('#ok').empty();
            
        }
        //$.each(data, function(index, obj){
        //$('#divs2').append( '<option value="'+obj.id+'">'+obj.divname+'</option>' );
        });
        
        })
    })
  </script>
@endsection
