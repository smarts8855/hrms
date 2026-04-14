@extends('layouts.layout')
@section('pageTitle')
Staff Earnings / Deductions
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
                            <input type="number" value="{{ $amount }}" name="amount-edit"  class="form-control" placeholder="e.g 11000"> 
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
              <h4 class="modal-title">Delete Variable</h4>
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
                    <input type="hidden" id="deleteid" name="deleteid" value="">
                    <input type="hidden" id="courtid" name="court" value="">
                    <input type="hidden" id="divid" name="division" value="">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Yes</button>
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
            <div class="form-group">
            @if ($CourtInfo->courtstatus==1)
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
                    <label class="control-label"> Year </label>
                    <select required id="year" name="year"  onchange="getTable()" class="form-control" >
                        <option value="" >-select Year</option>
                        @for($i = date('Y'); $i >= 1900; $i--)
                            <option value="{{$i}}" {{ ($year == $i ) ? "selected" : ""}}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="control-label"> Month </label>
                    <select required id="month" name="month" onchange="getTable()"  class="form-control">
                        <option value="" >-select Month</option>
                        <option value="JANUARY" {{ (  $month == "JANUARY" ) ? "selected" : "" }}>January</option>
                        <option value="FEBRUARY" {{ ( $month == "FEBRUARY" ) ? "selected" : "" }}>February</option>
                        <option value="MARCH" {{ ( $month == "MARCH" ) ? "selected" : "" }}>March</option>
                        <option value="MAY" {{ ( $month == "MAY" ) ? "selected" : "" }}>May</option>
                        <option value="JUNE" {{ ( $month == "JUNE" ) ? "selected" : "" }}>June</option>
                        <option value="JULY" {{ ( $month == "JULY" ) ? "selected" : "" }}>July</option>
                        <option value="SEPTEMBER" {{ ( $month == "SEPTEMBER" ) ? "selected" : "" }}>September</option>
                        <option value="OCTOBER" {{ ( $month == "OCTOBER" ) ? "selected" : "" }}>October</option>
                        <option value="NOVEMBER" {{ ( $month == "NOVEMBER" ) ? "selected" : "" }}>November</option>
                        <option value="DECEMBER" {{ ( $month == "DECEMBER" ) ? "selected" : "" }}>December</option>                    
                    </select>
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
            <h2 style="display: none;" id="print-head">STAFF EARNING & DEDUCTION </h2>
                <div class="table-responsive col-md-6" style="font-size: 12px; padding:10px;">
                    <table class="table table-bordered table-striped table-highlight" >
                        <tbody>
                        <tr>
                            <td>STAFF FILE NO.:</td>
                            <td><b id="fileno-tab">{{ $fileNo }}</b></td>
                        </tr>
                        <tr>
                            <td>FULLNAME:</td>
                            <td><b id="name-tab">{{ strtoupper($staff->surname) }} {{ strtoupper($staff->first_name) }} {{ strtoupper($staff->othernames) }}</b></td>
                        </tr>
                        <tr>
                            <td>YEAR:</td>
                            <td><b id="year-tab">{{ $year }}</b></td>
                        </tr>
                        <tr>
                            <td>MONTH:</td>
                            <td><b id="month-tab">{{ $month }}</b></td>
                        </tr>
                        </tbody>                    
                    </table>
            
                </div>
            </div>
            <div class="col-md-12">
            
                <div class="col-md-6"><h4>MONTHLY EARNING & DEDUCTION</h4></div>
                    <div class="col-md-6 " >
                        <!-- <div class="col-md-12" style="margin:2px;"><label class="text-primary" for="check-all"><input  type="checkbox" class="checkitem" name="check-all" id="check-all">CheckAll</label></div>
                        <div class="col-md-12" style="margin:2px;"><span onclick="return reject()" class="btn btn-sm btn-warning">Reject</span></div>
                        <div class="col-md-12" style="margin:2px;"><span onclick="return approve()" class="btn btn-sm btn-success">Approve</span></div>
                        <div class="col-md-12" style="margin:2px;"><span onclick="return delet()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></span></div> -->
                    </div>
                </div>
            </div>

        
            <div class="table-responsive col-md-6" style="font-size: 12px; padding:10px;">
                <table class="table table-bordered table-striped table-highlight" >
                    <thead>
                    <tr bgcolor="" style="text-align:center"><b>EARNING</b></tr>
                        <tr bgcolor="#c7c7c7">
                            <th><b>DESCRIPTION</b></th>
                            <th><b>AMOUNT</b></th>
                        </tr>
                    </thead>
                    @php $sum = 0; @endphp
                    <tbody>
                
                    @foreach($controlvariablecontent as $list)
                        @if($list->particularID == 1)
                            <tr>
                                <td>{{ $list->description }}</td>
                                <td>{{$list->amount }}</td>
                                @php  $sum = $list->amount + $sum; @endphp                 
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td>TOTAL</td>
                        <td><b>{{ $sum }}</b></td>
                    </tr>
                    </tbody>                    
                </table>
        
            </div>

            <div class="table-responsive col-md-6" style="font-size: 12px; padding:10px;">
                <table class="table table-bordered table-striped table-highlight" >
                    <thead>
                    <tr bgcolor="" style="text-align:center"><b>DEDUCTION</b></tr>
                        <tr bgcolor="#c7c7c7">
                            <th><b>DESCRIPTION</b></th>
                            <th><b>AMOUNT</b></th>
                        </tr>
                    </thead>
                    @php $sum = 0; @endphp
                    <tbody>
                   
                    @foreach($controlvariablecontent as $list)
                        @if($list->particularID == 2)
                            <tr>
                                <td>{{ $list->description }}</td>
                                <td>{{ $list->amount }}</td>
                                @php  $sum = $list->amount + $sum; @endphp                 
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td><b>{{ $sum }}</b></td>
                    </tr>
                    </tbody>                    
                </table>
        
            </div>
          </form>
          <hr />
       
       
   

        <!-- /.row -->
        <form method="post"  id="form2">
        <div class="row">     
        {{ csrf_field() }}

                <div class="col-md-12">
                    <div class="col-md-6"><h4>OCCASIONAL EARNING & DEDUCTIONS</h4></div>
                    <div class="col-md-6 " >
                    
                        <!-- <div class="col-md-0 checkbox pull-right" style="margin:2px;"><label class="text-primary" for="check-all"><input  type="checkbox" class="checkitem" name="check-all" id="check-all">CheckAll</label></div>
                        <div class="col-md-0 pull-right" style="margin:2px;"><span onclick="return reject()" class="btn btn-sm btn-warning">Reject</span></div>
                        <div class="col-md-0 pull-right" style="margin:2px;"><span onclick="return approve()" class="btn btn-sm btn-success">Approve</span></div>
                        <div class="col-md-0 pull-right" style="margin:2px;"><span onclick="return delet()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></span></div> -->
                    </div>
                </div>
            </div>

                <div class="table-responsive col-md-6" style="font-size: 12px; padding:10px;">
                    <table class="table table-bordered table-striped table-highlight" >
                        <thead>
                            <tr style="text-align:center"><b>EARNING</b></tr>
                            <tr bgcolor="#c7c7c7">
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        @php $sum = 0; @endphp
                        <tbody>                   
                        @foreach($earningtablecontent as $list)
                            @if($list->particularID == 1)                 
                                <tr>
                                    <td>{{ $list->description }}</td>
                                    <td>{{ $list->amount }}</td>
                                    @php  $sum = $list->amount + $sum; @endphp
                                </tr>
                            @endif
                        @endforeach                    
                        <tr>
                            <td>TOTAL</td>
                            <td><b>{{ $sum }}</b></td>
                        </tr>
                        </tbody>                    
                    </table>
            
                </div>

                <div class="table-responsive col-md-6" style="font-size: 12px; padding:10px;">
                    <table class="table table-bordered table-striped table-highlight" >
                        <thead>
                            <tr style="text-align:center"><b>DEDUCTION</b></tr>
                            <tr bgcolor="#c7c7c7">
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        @php $sum = 0; @endphp
                        <tbody>
                    
                        @foreach($earningtablecontent as $list)
                            @if($list->particularID == 2)                 
                                <tr>
                                    <td>{{ $list->description }}</td>
                                    <td>{{ $list->amount }}</td>
                                    @php  $sum = $list->amount + $sum; @endphp
                                </tr>
                            @endif
                        @endforeach
                        
                        <tr>
                            <td>TOTAL</td>
                            <td><b>{{ $sum }}</b></td>
                        </tr>
                        </tbody>                    
                    </table>            
                </div>
         
          <hr />
        </div>
        </form>
        </div>
        <button class="btn btn-primary btn-sm" onclick="return myFunc()">Print</button>
        <button class="btn btn-success btn-sm" onclick="return Export2Doc()">Export</button>
  </div>
</div>



@endsection

@section('styles')
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
	
   function gotoExport(){
   	console.log('here');
   	return $("#tblr").wordExport();
   }
   
   
   function Export2Doc(filename = ''){
    var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
    var postHtml = "</body></html>";
    var html = preHtml+document.getElementById('tblr').innerHTML+postHtml;

    var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
    });
    
    // Specify link url
    var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
    
    // Specify file name
    filename = filename?filename+'.doc':'document.doc';
    
    // Create download link element
    var downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob ){
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = url;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
    
    document.body.removeChild(downloadLink);
  }

   function approve(a = '')
   {
        if(a !== ''){
        document.getElementById('chosen').value = a;
           // alert(a);
        }
        co = document.getElementById('court').value;
        div = document.getElementById('division').value;
        document.getElementById('co').value = co;
        document.getElementById('di').value = div;
        document.getElementById('type').value = 1;
        document.getElementById('form2').submit();
       return false;
   }

   function reject(a = ''){
       
        if(a !== ''){
            document.getElementById('chosen').value = a;
        }
        co = document.getElementById('court').value;
        div = document.getElementById('division').value;
        document.getElementById('co').value     = co;
        document.getElementById('di').value     = div;
        document.getElementById('type').value   = 2;
        document.getElementById('form2').submit();
       return false;

   }

   function delet(a = ''){
    if(confirm('Are you sure you want to delete this record!')){
        if(a !== ''){
            document.getElementById('chosen').value = a;
        }
        //alert(a);
        co = document.getElementById('court').value;
        div = document.getElementById('division').value;
        document.getElementById('co').value = co;
        document.getElementById('di').value = div;
        document.getElementById('type').value = 3;
        document.getElementById('form2').submit();
    }
    //    return false;
   }


    function editfunc(x,y,z,a)
    {
        document.getElementById('edit-hidden').value = x;
        document.getElementById('deleteid').value = null;
        document.getElementById('courtid1').value = z;
        document.getElementById('divid1').value = a;
        $("#editModal").modal('show')
    }

    function deletefunc(x,y,z,a)
    {
        //$('#deleteid').val() = x;
        document.getElementById('edit-hidden').value = null;
        document.getElementById('deleteid').value = x;
        document.getElementById('courtid').value = z;
        document.getElementById('divid').value = a;
        $("#DeleteModal").modal('show');
    }

    function getDivisions()
    {
        
        document.getElementById('year').value = "";
        document.getElementById('month').value = "";
        document.getElementById('month-tab').value = "";
        document.getElementById('year-tab').value = "";
        document.getElementById('name-tab').value = "";
        document.getElementById('fileno-tab').value = "";
        if($('#court').val() !== "")
        {
            $('#form1').submit();
        }
    }

    function getStaff()
    {
        document.getElementById('year').value = "";
        document.getElementById('month').value = "";
        document.getElementById('month-tab').value = "";
        document.getElementById('year-tab').value = "";
        document.getElementById('name-tab').value = "";
        document.getElementById('fileno-tab').value = "";
        if($('#division').val() !== ""){
            $('#form1').submit();
        }
    }

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

