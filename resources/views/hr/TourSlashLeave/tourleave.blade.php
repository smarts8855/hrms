@extends('layouts.layout')
@section('pageTitle')
Tour and Leave Manager
@endsection



@section('content')

<div id="editModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Variable</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="editpartModal" name="editpartModal"
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-2 control-label">Amount</label>
                    </div>
                    <div class="col-sm-12">
                            <input type="number" value="" name="amount-edit"  class="form-control" placeholder="e.g 11000"> 
                    </div>
                    <input type="hidden" id="edit-hidden" name="edit-hidden" value="">
                    <input type="hidden" id="courtid1" name="court" value="">
                    <input type="hidden" id="divid1" name="division" value="">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>


        <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Caution</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal" 
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-9 control-label"><b>Are you sure you want to delete this record?</b></label>
                    </div>
                    <input type="hidden" id="deleting" name="deleting" value="">
                    <input type="hidden" id="courtid" name="court" value="">
                    <input type="hidden" id="divid" name="division" value="">
                    <input type="hidden" id="filn" name="fileNo" value="">
                    <input type="hidden" id="typ" name="type" value="">
                </div>
            </div>
                <div class="modal-footer">
                   <button class="btn btn-success" >Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
    

<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
    </div>

    <div class="col-md-12">
              	@if (count($errors) > 0)
	                <div class="alert alert-danger alert-dismissible" role="alert">
		              	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		              		<span aria-hidden="true">&times;</span>
		                </button>
		                <strong>Error!</strong> 
		                @foreach ($errors->all() as $error)
		                    <p>{{ $error }}</p>
		                @endforeach
	                </div>
                @endif
                @if ($error != "")
	                <div class="alert alert-danger alert-dismissible" role="alert">
		              	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		              		<span aria-hidden="true">&times;</span>
		                </button>
		                <strong>Error!</strong> 
		                    <p>{{ $error }}</p>
	                </div>
                @endif               
                @if ($success != "")
                    <div class="alert alert-success alert-dismissible" role="alert">
              			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                    	{{ $success }}</div>                        
                @endif
                @if(session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
              			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                    	{{ session('err') }}</div>                        
                @endif
            </div>


    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col--> 
          @include('Share.message')
        
        <form class="form-horizontal" id="form1" role="form" method="post" action="">
        {{ csrf_field() }}

            <div class="col-md-12"><!--2nd col-->
            <!-- /.row -->
             @if ($CourtInfo->courtstatus==1)
            <div class="form-group">
            <div class="col-md-4">          
                    <label class="control-label">Court</label>
                    <select required class="form-control" id="court" onchange="getDivisions()" name="court" required>
                    <option value=""  >-select Court</option>
                    @foreach($courtList as $list)
                    <option value="{{$list->id}}" {{ ($court == $list->id) ? "selected":""}} >{{$list->court_name}}</option>
                    @endforeach         
                    </select>
                </div>
             @else
            <input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
          @endif 
          @if ($CourtInfo->divisionstatus==1)  
                <div class="col-md-4">
                    <label class="control-label">Division</label>
                    <select required class="form-control" id="division" name="division" onchange="getStaff()" required>
                    <option value=""  >-select Division </option>                
                    @foreach($courtdivision as $list)
                    <option value="{{$list->divisionID}}" {{ ($division) == $list->divisionID ? "selected" :""}}>{{$list->division}}</option>
                    @endforeach        
                    </select>
                </div>
 	@else
              <input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">
        @endif
                <div class="col-md-4">
                    <label class="control-label"> Staff ID </label>
                    <select required id="fileNo" name="fileNo"  onchange="getTable()" class="form-control" >
                        <option value="" >-select Staff</option>
                        @foreach($courtstaff as $list)
                            <option value="{{ $list->fileNo }}" {{ ($fileNo === $list->fileNo) ? "selected" :"" }}>{{$list->surname}} {{ $list->first_name }} {{ $list->othernames }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-2">
                    <label class="control-label"> Tour or Leave </label>
                    <select required id="type" name="type" onchange="getTable()"  class="form-control" >
                        <option value="" >-select Type</option>
                        <option value="Tour" {{ ( $type == "Tour" ) ? "selected" : "" }}>Tour</option>
                        <option value="Leave" {{ ( $type == "Leave" ) ? "selected" : "" }}>Leave</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="control-label"> Gezette No.</label>
                    <input required id="gezette" name="gezette" type="text" placeholder="e.g. ***/5695" value="{{$gezette}}"  class="form-control">
                </div>
                
                <div class="col-md-2">
                    <label class="control-label"> Start Date </label>
                    <input required id="start-date" name="start-date" readonly="readonly" type="text" value="{{ ($startdate)? $startdate : date('d-m-Y') }}"  class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="control-label"> Due Date </label>
                    <input required id="due-date" value="{{ ($duedate)? $duedate : date('d-m-Y') }}" name="due-date" type="text" readonly="readonly" class="form-control">
                    <!-- <button class="btn btn-sm btn-info col-md-4" onclick="return getDuration()">Calc </button> -->
                </div>

                <div class="col-md-1">
                    <label class="control-label"> &nbsp &nbsp&nbsp</label>
                    <button class="btn btn-sm btn-info form-control" onclick="return getDuration()">Calc </button>
                    <!-- <input required id="return-date" value="{{ date('d M, Y') }}" name="return-date" type="text" readonly="readonly"  class="form-control"> -->
                </div>

                <div class="col-md-2">
                    <label class="control-label"> Return Date </label>
                    <input required id="return-date" value="{{($returndate)? $returndate : date('d-m-Y') }}" name="return-date" type="text" readonly="readonly"  class="form-control">
                </div>

                <div class="col-md-1">
                    <label class="control-label"> Duration </label>
                    <input required id="duration" name="duration" value="{{ $duration }}" type="number"   class="form-control">
                </div>
                
                <div class="col-md-2">
                    <label class="control-label"> &nbsp &nbsp </label>
                    <button class="btn btn-success form-control">Submit</button>
                </div>
                
               
            <!---</div>-->
        
        </form>
        <!-- /.row -->
        <div id="tblr">
        <form method="post"  id="form2">
        <div class="row">     
        {{ csrf_field() }}
            <div class="col-md-12">
            <div class="clearfix"></div>
            <hr>
            <!-- <h2 style="display: none;" id="print-head">STAFF EARNING & DEDUCTION </h2> -->
                
            </div>
            <div class="col-md-12">
            
                <div class="col-md-6">
                    <!-- <h4>MONTHLY EARNING & DEDUCTION</h4> -->
                    </div>
                    <div class="col-md-6 " >
                        <!-- <div class="col-md-12" style="margin:2px;"><label class="text-primary" for="check-all"><input  type="checkbox" class="checkitem" name="check-all" id="check-all">CheckAll</label></div>
                        <div class="col-md-12" style="margin:2px;"><span onclick="return reject()" class="btn btn-sm btn-warning">Reject</span></div>
                        <div class="col-md-12" style="margin:2px;"><span onclick="return approve()" class="btn btn-sm btn-success">Approve</span></div>
                        <div class="col-md-12" style="margin:2px;"><span onclick="return delet()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></span></div> -->
                    </div>
                </div>
            </div>

        
            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">                           
                  
                            <th><b>TYPE</b></th>
                            <th><b>GAZETTE NO.</b></th>
                            <th><b>START DATE</b></th>
                            <th><b>DURATION</b></th>
                            <th><b>DUE DATE</b></th>
                            <th><b>RESUMPTION DATE</b></th>
                            <th><b>ACTION</b></th>
                        </tr>
                    </thead>
                    @php $sum = 0; @endphp
                    <tbody>
                
                    @foreach($tablecontent as $list)
                        
                            <tr>
                            	<td>{{ $list->type }}</td>
                                <td>{{ $list->gazette }}</td>
                                <td>{{ DATE_FORMAT(DATE_CREATE($list->start_date), 'd-m-y') }}</td>
                                <td>{{ $list->duration }} working days</td> 
                                <td>{{ DATE_FORMAT(DATE_CREATE($list->due_date), 'd-m-y') }}</td>
                                <td>{{ DATE_FORMAT(DATE_CREATE($list->return_date), 'd-m-y') }}</td>
                                <td>
                                    <button onclick="return deletefunc('{{ $list->id }}', '{{ $list->courtID }}', '{{ $list->divisionID }}', '{{ $list->type }}', '{{ $list->fileNo }}')"  style="margin:5px" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                                    <!-- <button style="margin:5px" onclick="return editfunc()" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button> -->
                                </td>   
                            </tr>
                        
                    @endforeach
                    </tbody>                    
                </table>
        
            </div>

        
          </form>
          <hr />
       
       
   

        
        </div>
        <button class="btn btn-primary" onclick="return myFunc()">Print</button>
  </div>
</div>



@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<style type="text/css">
    .modal-dialog {
width:13cm
}

.modal-header {

background-color: #006600;

color:#FFF;

}

#partStatus{
    width:2.5cm
}

</style>
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>

   $("#check-all").change(function(){
       $(".checkitem").prop("checked", $(this).prop("checked"))
   })
   $(".checkitem").change(function(){
       if($(this).prop("checked") == false){
           $("#check-all").prop("checked", false)
       }
       if($(".checkitem:checked").length == $(".checkitem").length){
           $("#check-all").prop("checked", true)
       }
   })

   function myFunc(){
		var printme = document.getElementById('tblr');
       // console.log(printme);
		var wme = window.open("", "", "width=900,height=700");
        document.getElementById('print-head').style.display = 'block';
		wme.document.write(printme.outerHTML);
		wme.document.close();
		wme.focus();
		wme.print();
		wme.close();
        return false;
	}

   

   


    function editfunc(x,y,z,a)
    {
        // document.getElementById('edit-hidden').value = x;
        // document.getElementById('deleteid').value = null;
        // document.getElementById('courtid1').value = z;
        // document.getElementById('divid1').value = a;
        $("#editModal").modal('show')
        return false;
    }

    function deletefunc(x,a,b,c,d)
    {
        //$('#deleteid').val() = x;
        // document.getElementById('edit-hidden').value = null;
        document.getElementById('deleting').value = x;
        document.getElementById('courtid').value = a;
        document.getElementById('divid').value = b;
        document.getElementById('typ').value = c;
        document.getElementById('filn').value = d;     
        $("#DeleteModal").modal('show');
        return false;
    }

    function getDivisions()
    {
        
        
        if($('#court').val() !== "")
        {
            $('#form1').submit();
        }
    }

    function getStaff()
    {
        
        if($('#division').val() !== ""){
            $('#form1').submit();
        }
    }


    function getDuration()
    {
        
        var startdate = document.getElementById('start-date').value;
        var enddate  = document.getElementById('due-date').value;
        
        $.get("/tours/z/"+startdate+"/"+enddate,
        function(data, status){
            // alert("Data: " + data + "\nStatus: " + status);
            data = data;
            console.log(data);
            document.getElementById('start-date').value = data.substring(0, 10);
            document.getElementById('due-date').value = data.substring(11,21);
            document.getElementById('duration').value = data.substring(33);
            document.getElementById('return-date').value = data.substring(22,32);
        });
        return false;
    }
    $("#start-date").datepicker({
			changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd-mm-yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
				$("#start-date").val(dateFormatted);
        	},
		});

    $("#due-date").datepicker({
			changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd-mm-yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
				$("#due-date").val(dateFormatted);
        	},
		});

    $("#return-date").datepicker({
			changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd-mm-yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
				$("#return-date").val(dateFormatted);
        	},
		});
    
    function getTable() 
    {
        if($('#fileNo' ).val() !== ""){
            $('#form1').submit();
        }
    }

    function getData()
    {  
        if($('#month' ).val() !== ""){
            $('#form1').submit();
        }
     }


    function checkForm()
    {
        var court = $('#court').val();
            division = $('#division').val();
            fileno = $('#fileNo').val();
            fname = $('#fname').val();
            oname = $('#oname').val();
            sname = $('#sname').val();
            desc = $('#cvdesc').val();
            amount = $('#amount').val();
            if(court == ""){
                alert('You have empty fields!');
            } else {
                if(division == ""){
                    alert('You have empty fields');
                } else {
                    if(fileno == ""){
                        alert('you have empty fields!');
                    } else {
                        if(fname == ""){
                            alert('you have empty fields!'); 
                        } else {
                            if(oname == ""){
                                alert('you have empty fields');
                            } else {
                                if(sname == ""){
                                    alert('you have empty fields!');
                                } else {
                                    if(desc == ""){
                                        alert('you have empty fields!');
                                    } else {
                                        if(amount == ""){
                                            alert('you have empty fields!');
                                        } else {
                                           $('#form1').submit();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return false;
    }
</script>
@stop

