@extends('layouts.layout')
@section('pageTitle')
 Upload Attachment
@endsection

@section('content')
<div id="page-wrapper" class="box box-default">
  <div class="container-fluid">
    <div class="col-md-12 text-success"><!--2nd col--> 
    </div>
    <br />
    	<div class="box box-default" style="padding: 1px 20px;">
          <h3 class="box-title">
          	<b>@yield('pageTitle')</b>
          </h3>

        </div>
    <div class="row">
    
      <div class="col-md-12"> <br>
            
         <div class="row page-row " style="padding-left:24px;">
                       <!-- <article class="welcome col-md-8"> -->
                            <div class="title-heading1 mb60">
                                <h3>Staff Attachment Form</h3>
                            </div>
                            
                            <p>
                                <span class="pull-left">
                                    <small style="color:red">All Fields with * are important</small>
                                </span>
                            </p>
                            
                            <form action="{{url('attachment/save')}}" method="post" class="col-md-11" style="margin-top:30px;"enctype="multipart/form-data">
                            {{ csrf_field() }}

                                    <div class="col-xs-12">
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

                                        @if(session('message'))
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Submission Successful!</strong> 
                                            {{ session('message') }}
                                        </div>                        
                                        @endif

                                    </div>

                                 <div class="col-md-10">
			               
			                <div class="row">
			                  
			                  		                  
			                  <div class="col-md-12 mb-7">
			                   <div class="form-group">
				                <label for="type">Staff Name <span style="color:red">*</span></label>
				                
    				                     @if($staffid==$id)
				                    <input type="text" id="search" name="search" class="form-control" placeholder="Search for staff names..">
                                         @elseif($staffid->ID==$id)
                                    <input type="text" id="search" name="search" value="{{ $staffid->surname }}, {{ $staffid->first_name }} {{ $staffid->othernames }}" class="form-control" placeholder="Search for staff names..">
                                    <input type="hidden" id="staffid" name="staffid" value="{{ $staffid->ID }}" class="form-control">
                                         @endif
                               
                                <div id="getResult" class="panel panel-default" style="width:400px; height: 200px; overflow-y:auto; position:absolute; left:20px; top:55px; z-index:1; display:none;">
	                            <div id="getList"></div>
	                            </div>
                            
				           <!--//form-group-->
				          </div>
				          </div>
				          
				          <div class="col-md-12 mb-7">
			                    <div class="form-group">
			                     <label for="type">File Description <span style="color:red">*</span></label>
			                       @if( $id==0 )
			                            <textarea id="desc" name="desc" class="form-control" style="height:70px;" disabled >{{ old('desc') }}</textarea>
			                       @else
			                            <textarea id="desc" name="desc" class="form-control" style="height:70px;" required >{{ old('desc') }}</textarea>
			                       @endif
			                      <div class="validation"></div>
			                    </div>
			                  </div>
			                  
			                   
			                 
			                   			 
			 		   <div class="col-md-12 mb-7">
			                    <div class="form-group">
			                     <label for="title">Attach Document<span style="color:red">*</span></label>
			                      @if( $id==0 )
			                        <input type="file" name="filename[]" multiple="multiple" disabled>
			                      @else
			                        <input type="file" name="filename[]" multiple="multiple" required>
			                      @endif
			                    </div>
			                  </div> 
			                  
			                  		                  
			                  <div class="col-md-12">
			                  @if( $id==0 )
			                    <button type="submit" class="btn btn-default" style="cursor:pointer" disabled>Upload</button>
			                  @else
			                    <button type="submit" class="btn btn-success" style="cursor:pointer">Upload</button>
			                    <button onclick="urlPush()" class="btn btn-primary" style="cursor:pointer">Refresh</button>
			                  @endif
			                  </div>
			                </div>
			              </form>
			                <br>
			                <br>
			            </div>
			          
         
         
      </div>
    </div>
  </div>
</div>

<div id="page-wrapper" class="box box-default">
<div class="box-body">
  <h4 class="text-center">STAFF ATTACHMENT</h4>
  <div class="row"> {{ csrf_field() }}
    <div class="table-responsive col-md-12">
      <table id="mytable" class="table table-bordered table-striped table-highlight">
        <thead>
          <tr bgcolor="#c7c7c7">
            <th>S/N</th>
            <th>STAFF</th>
            <th>DESC</th>
            <th>ATTACHMENT</th>
            <!--<th></th>-->
                       
          </tr>
        </thead>
               
        <tbody>
         @php
          $i=1;
          @endphp
            @php $filepath="/staffattachments/" @endphp 
            @if($id!=0)
                @foreach( $staffDETAILS as $p )
                               
                   <tr>
                   <td>{{ $i++ }}</td>
                   <td>{{ $p->surname }}, {{  $p->first_name }} {{  $p->othernames }} </td>
                   <td>{{ $p->filedesc }}</td>
                  
                   <td>
                    <a href="{{ $filepath }}{{ $p->filepath}}">{{$p->filepath}}</a><br>
                   </td>
                   
                   <!--<td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Preview Petition" class="btn btn-primary float-right glyphicon glyphicon-edit btn-xs"></a></td>-->
                   
                   </a>
                   </td>
                   
                   </tr>
                @endforeach
            @endif
         
        </tbody>
                   
      </table>
       <hr />
       <div align="right">
      </div>
      <div class="hidden-print"></div>
    </div>
  </div>

  <!-- /.col --> 
  
</div>

<!-- modal bootstrap -->
<form action="{{url('/petition/add')}}" method="post">
{{ csrf_field() }} 
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Update Module</h4>
            </div>
            <div class="modal-body">
           
                    <div class="row" style="margin-bottom: 10px;">
                     <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Module Name</label>
                        <div class="col-md-9">
                          <input id="module" type="text" class="form-control" name="name" required>
                          <input id="id" type="hidden" class="form-control" name="moduleID" required>
                        </div>
                      </div>
                    </div>
                      
                    <div class="row">
                     <div class="form-group">
                       <label for="section" class="col-md-3 control-label">Rank</label>
                        <div class="col-md-9">
                          <input id="ranks" type="number" class="form-control" name="rank" value="" required>
                          
                        </div>
                      </div>
                    </div>    


            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!--// modal Bootstrap -->
</form>

@endsection 

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

<style>
    
#myInput {
  background-image: url('/css/searchicon.png'); /* Add a search icon to input */
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}

#myUL {
  /* Remove default list styling */
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#myUL li a {
  border: 1px solid #ddd; /* Add a border to all links */
  margin-top: -1px; /* Prevent double borders */
  background-color: #f6f6f6; /* Grey background color */
  padding: 12px; /* Add some padding */
  text-decoration: none; /* Remove default text underline */
  font-size: 18px; /* Increase the font-size */
  color: black; /* Add a black text color */
  display: block; /* Make it into a block element to fill the whole list */
}

#myUL li a:hover:not(.header) {
  background-color: #eee; /* Add a hover effect to all links, except for headers */
}
</style>
@stop

@section('scripts')

<script type="text/javascript" src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>


<script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#petitionDate').datepicker({
                    format: "yyyy/mm/dd"
                });  
            
            });
            
        $('#petitionDate').datepicker({
        autoclose: true,  
        format: "yyyy/mm/dd"
        }); 
</script>


<script type="text/javascript">
$(document).ready(function(){
 $('table tr td .edit').click(function(){
  var id = $(this).attr('id');
//alert(id);
$.ajax({
  url: murl +'/module/modify',
  type: "post",
  data: {'id': id, '_token': $('input[name=_token]').val()},
  success: function(data){
console.log(data.modulename);
   $('#module').val(data.modulename);
   $('#id').val(data.moduleID);
   $('#ranks').val(data.module_rank);
  }
});

});
});
</script>

<script>

  $(document).ready(function(){
$('table tr td .edit').click(function()
{

$("#myModal").modal('show');
})

  });
</script>
<script>
 function EnableField(){
     
      var fieldValue =  $('#fullname').val();
        if(fieldValue == "Enter New Petitioner" ){
     	  document.getElementById("yesno").style.display = 'block';
     	  document.getElementById("petitionerName").disabled = false;
     	  }
     	else{
     	  document.getElementById("yesno").style.display = 'none'
     	  document.getElementById("petitionerName").disabled = true;
     }
 }

</script>
<script>
    $(document).ready(function() {
    $('#').DataTable();
  } );

  $(document).ready(function() {
      $('#mytable').DataTable( {
          dom: 'Bfrtip',
          //"pageLength": 5,
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
    $("#staffid").change(function(e){
    
       var staffName= e.target.value;
       //alert(staffName);
       if( staffName!='')
        {
          if ("https:" == document.location.protocol) 
            {
		    //alert('secured');
		        
		    //location.href="https://petition.njc.gov.ng/petition/upload-petition/"+petivalue+"/"+petivalue;
                //location.href="https://staff/attachment-upload/"+staffName;
                document.location="/staff/attachment-upload/"+staffName;
                
            }
		  else 
		    {
		    //alert('not secured');
		         document.location="/staff/attachment-upload/"+staffName;
		    }
        }
        else
        {
            document.location="/staff/attachment-upload/"
        }
    });
</script>
<script>
    function urlPush()
    {
         //history.pushState('Judicial Payroll and Personnel Management System', 'Document Attachment', '/staff/attachment-upload');
         document.location="/staff/attachment-upload/";
         
    }
</script>

<script type="text/javascript">


		$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$('#search').keyup(function(){
			var search = $('#search').val();
			if(search==""){
				$('#getResult').css('display', 'none').hide();
			}
			else{
				var getQueries = "";
				$.get("{{ url('/') }}" + '/search/' + search,
					{search:search}, 
					function(data){
					if(data){
						$('#getResult').css('display', 'block');
					}else{
						$('#getResult').css('display', 'none')
					}
					if(search == ''){
					    $('#getResult').css('display', 'none').hide();
					}else{
					   $.each(data, function (index, value){
					        var id=value.ID;
						getQueries += '<ul style="margin-top:10px; list-style-type:none;">';
						getQueries += '<a href={{ url("staff/attachment-upload/")}}' +'/'+ value.ID + '>' + value.surname+ ' '+ value.first_name + ' ' + value.othernames + '</a>';
						getQueries += '</ul>';
					    });
    					    $('#getList').html(getQueries );
					}

				})
			}
		});
	
</script>

@stop
