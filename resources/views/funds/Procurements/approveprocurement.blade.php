@extends('layouts.layout')
@section('pageTitle')
Payment Approval
@endsection

@section('content')

<div id="vim" class="modal fade">
        <div class="modal-dialog" role="document"> 
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">All Minutes</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal" 
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12" id="z-space">
                    
                    </div>
                </div>
            </div>
            </form>
                <div class="modal-footer">
                    <!--<button type="Submit" class="btn btn-success" id="putedit"></button>-->
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            
                
            </div>
            
          </div>
        </div>
<div id="archiveModal" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Document Archiving</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="control-label"><b>Enter Reason for archive</b></label>
                    </div>
                    <div class="col-sm-12">
                            <textarea  name="comment"   class="form-control" > </textarea>
                    </div>
                    <input type="hidden" id="acid" name="id">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success" name= "archive">Continue</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>



        
        <!--instruct-->
        <div id="instructModal" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Send minutes for this action</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="instructform" role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                			
					<div class="col-sm-12" id="z-space1">
                    
                    </div>
                    <hr>
                    <a id="hrefid" href="" target="_blank" class="btn btn-info">Preview details</a>
                    
                    <div class="col-sm-12">
			                <div class="form-group">
                            <label class="control-label"><h5>Minutes </h5></label>
                            <select  class="form-control" name="commentid" id="commentid" onchange="CreateDecription()">
                                 <option value="">New Minute</option>
                                @foreach($DefaultComment as $list)
                                <option value="{{ $list->id }}">{{ $list->comment }} </option>
                                @endforeach
                               
                           </select>
                            </div>
                        </div>
                    <div id="divResults">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label class="control-label"><h5>Enter remark </h5></label>
                            <textarea  name="instruction" id="instruction"  class="form-control" placeholder="e.g Pay a sum amount of XXXXX" > </textarea>
                            </div>
                        </div>
                    </div>
                    
					<div class="col-sm-12">
                    <label class="control-label"><b>Refer to</b></label>
                    </div>
                    <div class="col-sm-12">
                          <select required  name="attension" class="form-control">
						  <option value="">Select</option>
						  @foreach($ApprovalReferal as $list)
						  <option value="{{$list->code}}">{{$list->description}}</option>
						  @endforeach
                        </select>
                    </div>
                    <input type="hidden" id="contid" name="contid" value="">
					
                <input type="hidden" value="{{$status}}" name="status">
                <input type="hidden" value="{{$contracttype}}"  name="contracttype">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success" name="s_remark">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            
                </form>
            </div>
            
          </div> 
        </div>
        <!--end of instruct-->
        
        
        <!--reject-->
        <div id="rejectModal" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Reason for Rejection</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="rejectform" 
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="control-label"><b>Please enter a reason for rejection</b></label>
                    </div>
                    <div class="col-sm-12">
                            <textarea  name="rejection" id="rejection"  class="form-control" placeholder="e.g Pay a sum amount of XXXXX" > </textarea>
                    </div>
                    <input type="hidden" id="chosen3" name="chosen3" value="">
                    <input type="hidden" value="" id="co3" name="contracttype2">
                <input type="hidden" value="{{$status}}" name="status2">
                <input type="hidden" value="2" id="type" name="type">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
        <!--end of reject-->
        
        
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
          @include('funds.Share.message')
        
        <form class="form-horizontal" id="form1" role="form" method="post" action="">
        {{ csrf_field() }}

            <div class="col-md-12"><!--2nd col-->
            <!-- /.row -->
            <div class="form-group">
            <div class="col-md-4">          
                    <label class="control-label">Account Type</label>
                    <select required class="form-control" id="contracttype" onchange="getTable()" name="contracttype" required>
                    <option value=""  >-select Account Type</option>
                    @foreach($contractlist as $list)
                    <option value="{{$list->ID}}" {{ ($contracttype == $list->ID || $list->ID == old('contracttype')) ? "selected":""}} >{{$list->contractType}}</option>
                    @endforeach         
                    </select>
                </div>
            </div>
            </div>
          <!-- /.col --> 
        </div>
        </form>
        <!-- /.row -->
        <form method="post"  id="form2">
        <div class="row">     
        {{ csrf_field() }}

                <div class="col-md-12"><!--2nd col-->
             
            </div>

        
            <div class="table-responsive col-md-12" >
                <table id="res_tab" class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th>S/N</th>
                            <th>Action</th>
                            <th>File No</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Balance</th>
                            <th>Beneficiary</th>
                            <th>Created By</th>                            
                            <th>Award/Approved Date</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    @php $i = 1; @endphp
                    <tbody>
                    @foreach($tablecontent as $list)
                    <tr @if($list->isrejected==1) style="background-color: red; color:#FFF;" @endif>
                            <td>{{ $i++ }}</td>
                            <td id="{{$list->ID}}" >
                                <!-- Example split danger button -->
                            <div class="dropdown">
                                  <button class="btn btn-danger btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Action
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                     <li><a  style="cursor: pointer;" 
                                 	onclick="return instruct('{{$list->ID}}','{{$list->comments}}','{{$list->comments2}}','{{$list->comments3}}')">Remark</a></li>
                                        <li><a   style="cursor: pointer;" onclick="return Archive('{{$list->ID}}')">Archive</a></li>
                                  </ul>
                                </div>
                            </td>
                            <td>{{ $list->fileNo }}</td>
                            <td>{{ $list->ContractDescriptions }}</td>
                            <td>&#8358; {{ number_format($list->contractValue,2) }}</td>
                            <td> &#8358; {{ number_format($list->contractBalance,2) }} </td>
                            @if ($list->voucherType==2)
                            <td>{{ $list->beneficiary}}</td>
                            @else
                            <td>{{ $list->contractor }}</td>
                            @endif
                            <td>{{ $list->name }}</td>
                            <td>{{ $list->dateAward }} </td>
                            <td>
                                @if($list->paymentStatus == 0)
                                    <b><span class="text-danger">Pending</span></b>
                                @elseif($list->paymentStatus == 2)
                                    <b><span class="text-success">Completed</span></b>
                                @else
                                    <b><span class="text-info">Part Payment</span></b>
                                @endif
                            </td>
                            
                                                         
                        </tr>
                    @endforeach
                    </tbody>                    
                </table>
        <br><br><br><br><br>
            </div>
            
          </form>
          <hr />
        </div>
       <br><br><br>
  </div>
</div>



@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@stop

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
$('#res_tab').DataTable();
    $( function(){
        $("#todayDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'}); 
      });

    $( function(){
        $("#dateawd").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'}); 
      });

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

   function approve(a = '')
   {
        if(a !== ''){
        document.getElementById('chosen').value = a;
           // alert(a);
        }
        
            document.getElementById('type').value = 1;
            //document.getElementById('acceptform').submit();
            $('#AcceptModal').modal('show');
       return false;
   }

   function reject(a = ''){
        if(a !== ''){
            document.getElementById('chosen3').value = a;
        }
        co = document.getElementById('contracttype').value;
        sta = document.getElementById('status').value;
        document.getElementById('co3').value = co;
       $('#rejectModal').modal('show');
        //document.getElementById('form2').submit();
       return false;
   }
   
   function instruct(id ,list,list2,list3){
            document.getElementById('contid').value = id;
             document.getElementById('hrefid').href = "/display/comment/"+ id;
            space = document.getElementById('z-space1');
            space.innerHTML='';
        //alert(list);
         //alert(list2);
          //alert(list3);     
if(list3 == "0"){
   	
   } else {
   //alert(list3);
       	var c = JSON.parse(list3);
       	
       	for(i = 0; i < c.length; i++){
       	
       		space.innerHTML += '<p><b id="vi">'+ c[i].comment +'</b> - <small class="text-warning"> <i>'+c[i].name+', posted '+ c[i].date_added+' at '+ c[i].time +'</i></small></p><br>';
       	
       }
       
   }
   
   if(list2== "0"){
   	
   } else {
   	var b = JSON.parse(list2);
       	for(i = 0; i < b.length; i++){
       		space.innerHTML += '<p><b id="vi">'+ b[i].comment +'</b> - <small class="text-warning"> <i>'+b[i].name+', posted '+ b[i].date_added+' at '+ b[i].time +'</i></small></p><br>';
       	
       }
       
   }
   if(space.innerHTML==''){
   space.innerHTML = "Approval Remarks <br>";
   space.innerHTML += ' No reason found';
   }else{
   space.innerHTML = ' Approval Remarks <br> '+space.innerHTML;
   }
   
   if(list == "0"){
   	space.innerHTML += ' <br> Payment Remarks'; 
   	space.innerHTML += ' <br> No reason found';
   } else {
       	var a = JSON.parse(list);
       space.innerHTML += '<br> Payment Remarks <br>';
       for(i = 0; i < a.length; i++){
       		space.innerHTML += '<p><b id="vi">'+ a[i].comment +'</b> - <small class="text-warning"> <i>'+a[i].name+', posted '+ a[i].date_added+' at '+ a[i].time +'</i></small></p><br>';
       	
       }
   }
   
        $('#instructModal').modal('show');
       return false;
   }

   function delet(a = ''){
    if(confirm('Are you sure you want to delete this record!')){
        if(a !== ''){
            document.getElementById('chosen').value = a;
            //alert(a);
            }
            co = document.getElementById('contracttype').value;
            sta = document.getElementById('status').value;
            document.getElementById('co').value = co;
            document.getElementById('type').value = 3;
            document.getElementById('form2').submit();
    }
       return false;
   }

function vc(list){
   if(list == ""){
   	space = document.getElementById('z-space'); 
   	space.innerText = 'No reason found';
   } else {
   	
       	var a = JSON.parse(list);
       	//console.log(a);
       	space = document.getElementById('z-space');
       	space.innerHTML = '';
       	for(i = 0; i < a.length; i++){
       		space.innerHTML += '<p><b id="vi">'+ a[i].comment +'</b> - <small class="text-warning"> <i>'+a[i].name+', posted '+ a[i].date_added+' at '+ a[i].time +'</i></small></p><br>';
       	
       }
       //$('#vim').modal('show');
   }
    
      $("#vim").modal('show');
      return false;
   }

    function editfunc(a,b,c,d,e,f,g)
    {
        document.getElementById('file_no').value = b;

        var opt = document.getElementById('contr_type');//.value = c;
        for(i = 0;i<opt.length;i++){
            val = opt.options[i].value;
            ///console.log(val);
            if(val == c){
                opt.options[i].selected = "selected";
            }
        }
        
        document.getElementById('contr_desc').value = d;
        document.getElementById('contr_val').value = e;
        document.getElementById('edit-hidden').value = 1;

        var opt2 = document.getElementById('company');//.value = c;
        for(i = 0;i<opt2.length;i++){
            val2 = opt2.options[i].value;
            ///console.log(val);
            if(val2 == f){
                opt2.options[i].selected = "selected";
            }
        }
        
        document.getElementById('dateawd').value = g;
        $("#editModal").modal('show')
    }

     function deletefunc(x){
        //$('#deleteid').val() = x;
        
        document.getElementById('deleteid').value = x;
        $("#DeleteModal").modal('show');
    }

function restorefunc(x){
        
        document.getElementById('restoreid').value = x;
        $("#RestoreModal").modal('show');
    }
    
    function getDivisions()
    {
        document.getElementById('status').value = "";
        if($('#contracttype').val() !== "")
        {
            $('#form1').submit();
        }
    }

    function getStaff()
    {
        document.getElementById('status').value = "";
        if($('#division').val() !== ""){
            $('#form1').submit();
        }
    }

    function getTable()
    {
        if($('#status' ).val() !== ""){
            $('#form1').submit();
        }
    }
    
    function Archive(id)
    {
        document.getElementById('acid').value = id;
        $("#archiveModal").modal('show');
    }
function CreateDecription() {
    $('#divResults').empty();
    if(document.getElementById('commentid').value ==0){
        var tbl = '<div class="col-sm-12">';
            tbl +='<div class="form-group">';
            tbl +='<label class="control-label"><h5>Enter remark </h5></label>';
            tbl += '<textarea  name="instruction" id="instruction"  class="form-control" placeholder="e.g Pay a sum amount of XXXXX" > </textarea>';
            tbl +='</div>';
        tbl +='</div>';
        $('#divResults').append(tbl);
    }
  
}
 
</script>
@stop

