@extends('layouts.layout')

@section('pageTitle')
    STAFF CLAIM
@endsection

@section('content')

        
<div class="box-body">
    <div class="box box-default">
    <div class="box-body box-profile">
    <div class="box-body">
    <div class="row">
        <div style="margin: 0px 5%;"> 	@if (count($errors) > 0)
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Error!</strong> 
                                            @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                        @endif

                                        @if(session('success'))
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Successful!</strong> 
                                            {{ session('success') }}
                                        </div>                        
                                        @endif
                                         @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Error!</strong> 
                                            {{ session('error') }}
                                        </div>                        
                                        @endif </div>
        
        <div class="noprint box-body">
        <div style="margin-left: 5%;"><h4 class="noprint text-lefttext-success"><b>STAFF SECTION</b></h4></div>
        <hr />
              <form class="form-horizontal" action="{{route('add-section')}}" method="post">
		{{ csrf_field() }} 
		  <div class="col-md-12" style="border-right: 1px dash #ddd;">
		       
		
		        

		        
			    <div class="col-sm-6">
			      <label for="amount">Users</label>
			       <select class="form-control" id="users" name="users" style="font-size:13px;font-weight:bold;color:#000;" required>
                                <option value="">--Select--</option>
                                 @foreach($users as $list)
                                     <option value="{{ $list->id }}" {{(old('users') == $list->id) ? "selected" : ""}}>{{ $list->name }}</option>  
                                 @endforeach
                                
                              </select>
			    </div>
			    
			    <div class="col-sm-6">
			      <label for="amount">Sections</label>
			       <select class="form-control" id="section" name="section" style="font-size:13px;font-weight:bold;color:#000;" required>
                                <option value="">--Select--</option>
                                 @foreach($section as $list)
                                     <option value="{{ $list->code }}" {{(old('section') == $list->code) ? "selected" : ""}}>{{ $list->section }}</option>  
                                 @endforeach
                                
                              </select>
			    </div>
			   
		        <div style="margin-left:15px;"><input type="submit" id="subButton" class="btn btn-primary btn-lg" placeholder="Title" value="Add" name="Add"></div>
		        
		</div>
      		
              </form>
  
      </div>
      
      <div class="box-body">
      <hr />
      	<table class="table table-hover table-stripped table-condensed table-bordered table-responsive">
      	   <thead style="background: darkseagreen; color:white;">
      	   	<tr class="text-uppercase text-center">
      	   	     <th>S/N</th>
      	   	     <th>Section</th>
      	   	     <th>Staff</th>
      	   	     
      	   	     <th>Action</th>
      	   	     
      	   	    
      	   	</tr>
      	   </thead>
      	   <tbody>
      	   @php $count = 1; @endphp
      	   @foreach($staff_section as $list)
      	   	<tr>
      	   	   <td>{{ $count++ }}</td>
      	   	   <td>{{ $list->section }}</td>
      	   	   <td>{{ $list->name}}</td>
      	   	   <td>
      	   	    
      	   	    <a onclick="editfunc('{{ $list->secID}}','{{ $list->uID}}','{{ $list->code}}')"><button class="btn btn-xs btn-default"> <i class="fa fa-edit"></i> </button></a>
      	   	    <a onclick="delfunc({{ $list->secID}})"><button class="btn btn-xs btn-default"> <i class="fa fa-trash"></i> </button></a>
      	   	   
      	   	   </td>
      	       </tr>
      	   @endforeach
      	    
      	   </tbody>
      	</table>
      	<hr>
      	    
      </div>
    	<hr />
    </div>
   
</div>
</div>
</div>

<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" enctype="multipart/form-data" action="{{ route('update-section') }}">
        {{ csrf_field() }}
      <div class="modal-header">
          <h4>Edit</h4>
          <!--
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
        -->
      </div>
    
      <div class="modal-body">
            
                                
                                <div class="row">    
                                    
                                    <div class="form-group col-md-6">
                                        <label>Department:<span style="color:red">*</span> </label>
                                            <select class="form-control" id="dept_id" name="dept_id">
                                                    <option value="">Select</option>
                                                 	 @foreach($section as $list)
                                        				<option value="{{ $list->code }}" {{(old('dept_id') == $list->code) ? "selected" : ""}}>{{ $list->section }}</option>  
                                        			 @endforeach
                            		       </select>    
                                            
                            		       
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <input type="hidden" name="sectionID" id="id" class="form-control form-control-lg form-control-a" required>
                                        
                                        <label>Staff:<span style="color:red">*</span> </label>
                                           <select class="form-control" id="user_id" name="user_id">
                                                    <option value="">Select</option>
                                                 	 @foreach($users as $list)
                                        				<option value="{{ $list->id }}" {{(old('user_id') == $list->id) ? "selected" : ""}}>{{ $list->name }}</option>  
                                        			 @endforeach
                            		       </select>
                                    </div>
                                </div>
                               
       <div class="pull-left" style="margin-left:10px;">
         <button type="submit" class="btn btn-success">Update</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      </div>
     
      
     </form>
     <p>&nbsp;</p>
    </div>

  </div>
</div>

<!--Add more staff-->
    
<!--//end add more staff-->
@include('StaffClaim.modalBodyUploadFile', ['modalHeader' => 'Upload Files', 'modalMessage' => 'You are about to upload additional document file', 'modalField' =>'<input type="file" class="form-control input-lg"  id="file" name="file" required />'])
@endsection


@section('styles')
 <style>
 #subButton
 {
   margin-top:25px;	
 }
 
 *{
  box-sizing: border-box;
 }
 #myInput, #myInput2 {
  background-image: url('../funds.njc.gov.ng/Images/search-icon-png-27.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable, #myTable2 {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable2 th, #myTable td, #myTable2 td {
  text-align: left;
  padding: 12px;
}

#myTable tr, #myTable2 tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover, #myTable2 tr.header, #myTable2 tr:hover {
  background-color: #f1f1f1;
}

 </style> 
@endsection
 
@section('scripts') 
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>
function delfunc(x)
    {
        //$('#deleteid').val() = x;
       
        //document.getElementById('replyid').value = x;
        var del = confirm('Are you sure?');
        
        if(del==true)
        {
            document.location="delete-section/"+x;
        }
        
        //$("#ReplyModal").modal('show');
    }
    
function editfunc(a,b,c)
    {
        document.getElementById('id').value = a;
        document.getElementById('user_id').value = b;
        document.getElementById('dept_id').value = c;
        
        $("#editModal").modal('show')
    }
</script>
 <script>
    function myFunction() {
	  var input, filter, table, tr, td, i, txtValue;
	  input = document.getElementById("myInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("myTable");
	  tr = table.getElementsByTagName("tr");
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[0];
	    if (td) {
	      txtValue = td.textContent || td.innerText;
	      if (txtValue.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    }       
	  }
   }
   
   /*for Add more staff*/
   function myFunction2() {
	  var input, filter, table, tr, td, i, txtValue;
	  input = document.getElementById("myInput2");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("myTable2");
	  tr = table.getElementsByTagName("tr");
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[0];
	    if (td) {
	      txtValue = td.textContent || td.innerText;
	      if (txtValue.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    }       
	  }
   }
   
     /*--show add more staff modal--*/
      $('.moreStaff').click(function(e){ 
      	 var addMoreID = $(this).attr('id');
      	  $('#addMoreStaffClaimID').val($('#getAddClaimID' +  addMoreID ).val());
         $('#showMoreStaff').modal({
        	show: 'true'
    	}); 
    	// Format Amount with comman
	$('.claimAmountFormat').keyup(function(event) {
		x = $(this).val().replace(/[ ]*,[ ]*|[ ]+/g, '');
                $(this).val(x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
	});
      //end text format
       
    });  
    
   /* AJAX call for staff deletion from list*/
   	$(document).ready(function(){
            $('.removeStaff').click(function(e){
            	var selectedID = $(this).attr('id');
            	//show confirmation modal
            	var getSelectedStaff = $('.selectedName' + selectedID).val();
            	$('#removeName').html('');
            	$('#removeName').html( getSelectedStaff );
             	$('#removeOne').modal({
        		show: 'true'
    		});
    		//
              $('#removeNow').click(function(e){
              $('#cancelRemove').attr("disabled", "true");
              $('#removeNow').attr("disabled", "true");
                 $.ajax({
                    url: '{{ url("/remove-staff-from-list") }}',
                    method: 'post',
                    data: {
                       'getSelectedStaffID' : selectedID,
                       '_token': $('input[name=_token]').val()
                    },
                    success: function(response){
                        alert(getSelectedStaff + ' ' + response.successMessage);
                        $('#cancelRemove').removeAttr('disabled');
              		$('#removeNow').removeAttr('disabled');
                    	$('.deleted'+selectedID).hide();
                    	$("#removeOne").modal.hide();
                    	location.reload(); 
                    },
                    error: function (jqXHR, status, err) {
                        alert(err + '. Sorry, an error occurred! Refresh this page and try again.' );
                        $('#cancelRemove').removeAttr('disabled');
              		$('#removeNow').removeAttr('disabled');
              		$("#removeOne").modal.hide();
                    }
                  });
                });
            });
    
            ///end staff deletion from list
      
           /* AJAX call for Claim deletion*/

      	  $('.deleteClaim').click(function(e){
            	 var getClaimID = $(this).attr('id');
                 $('.deleteClaim').attr("disabled", "true");
                 $('.cancelClaim').attr("disabled", "true");
                 $.ajax({
                    url: '{{ url("/remove-staff-claim") }}',
                    method: 'post',
                    data: {
                       'claimID' : getClaimID,
                       '_token': $('input[name=_token]').val()
                    },
                    success: function(data){
                        alert(data);
              		$('.cancelClaim').removeAttr('disabled');
                    	$('#removeClaim' + getClaimID).hide();
                    	$('.deleteClaim').removeAttr('disabled');
                    	//location.reload(); 
                    },
                    error: function (jqXHR, status, err) {
                        alert(err + '. Sorry, an error occurred! Click ok to allow this page to refresh. Then, you can try again' );
                        $('.deleteClaim').removeAttr('disabled');
              		$('.cancelClaim').removeAttr('disabled');
                    	location.reload();
                    }
                  }); 
            });
            
            //SHOW UPLOAD MODAL FOR USER
            $('.showStaffClaimUploadModalForm').click(function(e){
            	var staffClaimID = $(this).attr('id');
            	$('#staffClaimID').val(staffClaimID);
            	//show confirmation modal
             	//$('#showUploadModal').modal({
        		//show: 'true'
    		//});
            });
       }); //document ready
      ///end claim deletion
      
      // Format Amount with comman
	$('.claimAmountFormat').keyup(function(event) {
		x = $(this).val().replace(/[ ]*,[ ]*|[ ]+/g, '');
                $(this).val(x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
	});
      //end text format

  </script> 
@endsection

 


