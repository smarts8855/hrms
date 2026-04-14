@extends('layouts.layout')
@section('pageTitle')
Rejected Personnel Voucher 
@endsection

@section('content')

<div id="editModal" class="modal fade">
    <div class="modal-dialog " role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h4 class="modal-title">Edit Record</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" id="editpartModal" name="editpartModal"
                role="form" method="POST" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
        <div class="modal-body">  
            <div class="form-group" style="margin: 0 10px;">
                <div class="col-sm-12">
                <label class=" control-label">File No:</label>
                </div>
                <div class="col-sm-12">
                        <input type="text" value="" name="fileno" id="efileno" readonly class="form-control" > 
                </div>
                <div class="col-sm-12">
                <label class=" control-label">Approval Page:</label>
                </div>
                <div class="col-sm-12">
                        <input type="text" value="" name="approvalpage" id="eapprovalpage"  class="form-control" > 
                </div>
                <div class="col-sm-12">
                <label class=" control-label">Account Head</label>
                </div>
                <div class="col-sm-12">
                        <select name="contracttype" id="econtracttype"  class="form-control" >
                            <!-- pitoff -->
                            @if(isset($userRoleId) && ($userRoleId->roleID === 21))
                            <option value="6">Personnel</option>
                            @else
                                @foreach($contractlist as $list)
                                    <option value="{{$list->ID}}" {{(old('contracttype') == $list->ID) ? "selected" : ""}}>{{$list->contractType}}</option>
                                @endforeach
                            @endif
                            <!-- pitoff end -->
                        </select>
                </div><div class="col-sm-12">
                <label class="control-label">Claim Description</label>
                </div>

                <div class="col-sm-12">
                        <textarea  name="description" id="edescription"  class="form-control" > </textarea>
                </div>
                <div class="col-sm-12">
                <label class="control-label">Total Claim</label>
                </div>
                
                <div class="col-sm-12">
                        <input type="text" value="" name="claimvalue" id="econtractvalue" placeholder=""  class="form-control" > 
                </div>
                <div class="col-sm-12">
                <label class="control-label">Claim Beneficiary</label>
                </div>
                
                <div class="col-sm-12">
                        <input type="text" value="" name="benef" id="ebenef" placeholder=""  class="form-control" > 
                </div>
                
                <div class="col-sm-12">
                <label class="control-label">Approval Date</label>
                </div>
                
                <div class="col-sm-12">
                        <input type="text" value="" name="approvaldate" id="eapprovaldate" autocomplete="off"  class="form-control" > 
                </div>
                <div class="col-sm-12">
                <label class="control-label">Upload project file</label>
                </div>
                
                <div class="col-sm-12">
                        <input type="file"  name="filex"  autocomplete="off"  class="form-control" > 
                </div>
                <div class="col-sm-12">
                <label class=" control-label">Reassing to</label>
                </div>
                
                <div class="col-sm-12">
                    <select name="attension" id="actionbyid"  class="form-control" >
                        <!-- pitoff -->
                        @if(isset($userRoleId) && ($userRoleId->roleID === 21))
                            <option value="HC">{{'CHECKING'}}</option>
                            <option value="HEC">{{'EXPENDITURE CONTROL'}}</option>
                            <option value="HAUD">{{'AUDIT'}}</option>
                            <option value="HCPO">{{'CPO'}}</option>
                        @else
                            @foreach($officers as $list)
                            <option value="{{$list->code}}">{{$list->description}}</option>
                            @endforeach
                        @endif
                        <!-- pitoff end -->
                        </select>
                </div>
                
            </div>

        </div>
            <div class="modal-footer">
                <button type="Submit" name="update" class="btn btn-success">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <input type="hidden" value="13" name="companyid">
            <input type="hidden"  name="cid" id="cid">
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
          @include('funds.Share.message')
        
        {{-- <form class="form-horizontal" id="form1" role="form" method="post" action=""> --}}
        {{-- {{ csrf_field() }} --}}

          <!-- /.col --> 
        </div>
        </form>
        <!-- /.row -->
        {{-- <form method="post"  id="form2"> --}}
        <div class="row">     
        {{-- {{ csrf_field() }} --}}

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
                            {{-- <th>Balance</th> --}}
                            <th>Beneficiary</th>
                            <th>Award/Approved Date</th>
                            <!--<th>Awaiting by</th>-->
                            <th>Edit/Reassign</th>                            
                            
                        </tr>
                    </thead>
                    @php $i = 1; @endphp
                    <tbody>
                   
                    @foreach($tablecontent as $list)
                    {{-- @if($list->is_raised==0) --}}
                     
                     
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
                                    <!--pitoff -->
                                        @php $mycontractID = DB::table('tblpaymentTransaction')->where('contractID', $list->ID)->first(); @endphp
                                    <!-- end pitoff -->
                                     <li><a  style="cursor: pointer;" href="/display/comment/{{$list->ID}}" target="_blank">View Minutes</a></li>
                                     <li><a   style="cursor: pointer;" href="/display/voucher/{{$mycontractID->ID}}">View Voucher</a></li>
                                  </ul>
                                </div>
                                    
                              
                                  
                            </td>
                            <td>{{ $list->fileNo }}</td>
                            <td>{{ $list->ContractDescriptions }}</td>
                            <td>&#8358; {{ number_format($list->contractValue) }}</td>
                            {{-- <td> &#8358; {{ number_format($list->contractBalance) }} </td> --}}
                            @if ($list->voucherType==2)
                            <td>{{ $list->beneficiary}}</td>
                            @else
                            {{-- <td>{{ $list->contractor }}</td> --}}
                            @endif
                            <td>{{ $list->dateAward }} </td>
                            <!--<td>{{ $list->awaitingActionby }}</td>-->
                            
               
                            <td>
                                <button onclick="return editPersonnelV('{{ $list->ID }}', '{{$list->fileNo}}', '{{$list->contract_Type}}','{{$list->ContractDescriptions}}','{{ $list->contractValue }}','{{$list->beneficiary}}','{{ $list->dateAward }}','{{ $list->awaitingActionby }}','{{ $list->ref_no }}')" class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button>
                                <button onclick="return delPVoucher('{{ $list->ID }}')" class="btn btn-danger btn-xs"><i class="fa fa-trash "></i></button>
                            </td>
                            
                            
                            <!--decline modal-->
                            <div id="deleteModal" class="modal fade">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title">Voucher has been rejected are u sure you want to delete?</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <form class="form-horizontal" 
                                            role="form" method="POST" action="">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="vPid" name="vPid">
                                        <div class="modal-footer">
                                            <button type="submit" name="deleteVoucher" class="btn btn-success">Delete</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                                        </div>
                                    
                                    </form>
                                    </div>
                                    
                                </div>
                                </div>
                                <!--end of decline modal-->
                                                         
                        </tr>
                    {{-- @endif --}}
                    @endforeach
                    </tbody>                    
                </table>
        <br><br><br><br><br>
            </div>
            
          {{-- </form> --}}
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
$('#res_tab').DataTable({
    "iDisplayLength": 100
  });

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
   

    //pitoff
   function editPersonnelV(id,fileno,cont,desc,amt,ben,appdate,actby,ref_no)
    {
        document.getElementById('cid').value = id;
        document.getElementById('efileno').value = fileno;
        document.getElementById('econtracttype').value = cont;
        document.getElementById('edescription').value = desc;
        document.getElementById('econtractvalue').value = amt;
        document.getElementById('ebenef').value = ben;
        document.getElementById('actionbyid').value = actby;
        document.getElementById('eapprovaldate').value = appdate;
        document.getElementById('eapprovalpage').value = ref_no;
        $("#editModal").modal('show')
    }

    function delPVoucher(vID){
        document.getElementById('vPid').value = vID;
        $("#deleteModal").modal('show')
    }
    //end pitoff

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
    
    function  ReloadForm()
      { 
      document.getElementById('form1').submit();
      return;
      }


    function Archive(id)
    {
        document.getElementById('acid').value = id;
        $("#archiveModal").modal('show');
    }

    function getTable()
    {
        if($('#status' ).val() !== ""){
            $('#form1').submit();
        }
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

