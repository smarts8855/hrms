@extends('layouts.layout')
@section('pageTitle')
  Approve Budget Appropriation
@endsection
@section('content')


<div id="editModal" class="modal fade">
 <div class="modal-dialog box box-default" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit Budget Details  </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form class="form-horizontal" id="editBModal" name="editBModal"
            role="form" method="POST" action="{{url('allocation/approval')}}">
            {{ csrf_field() }}
    
        <div class="modal-body">  
          <div class="form-group" style="margin: 0 10px;">
              
              <h4>Are you sure you want to approve this item?</h4>
              <input type="hidden" class="col-sm-9 form-control" id="B_id" name="B_id">
             
          </div> 
         
       
        <div class="modal-footer">
            <button type="Submit" name="edit" class="btn btn-success">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
     
        </form>
    </div>
      
          </div>
        </div>
      </div>
      
      
    <div id="delModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Contractor</h4>
        
      </div>
      <form class="form-horizontal" id="editLgaModal" name="editLgaModal"
              role="form" method="POST" action="{{url('allocation/approval')}}">
              {{ csrf_field() }}
      <div class="modal-body">  
          <div class="form-group" style="margin: 0 10px;">
              
              <h4>Are you sure you want to delete this item?</h4>
              <input type="hidden" class="col-sm-9 form-control" id="conID" name="B_id">
              <input type="hidden" class="col-sm-9 form-control" id="status" name="status">
             
          </div>
          <div class="modal-footer">
              <button type="Submit" name="delete" class="btn btn-success">Continue ?</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
       
          </form>
      </div>
        
            </div>
          </div>
        </div>


<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col--> 
                    @if ($warning<>'')
                      <div class="alert alert-dismissible alert-danger">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>{{$warning}}</strong> 
                      </div>
                      @endif
                      @if ($success<>'')
                      <div class="alert alert-dismissible alert-success">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>{{$success}}</strong> 
                      </div>
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
        
        <form class="form-horizontal" role="form" id="thisform1" name="thisform1" method="post" action="{{url('allocation/approval')}}">
        {{ csrf_field() }}

        <div class="col-md-12"><!--2nd col-->
          <!-- /.row -->
          <div class="form-group">

            <div class="col-md-2">          
                <label class="control-label">Period</label>
                <select name="period" class="form-control" id="period" onchange="ReloadForm()" required>
                  <option Value="">Select Year</option>
                     @for ($i = 2024; $i < 2035; $i++)
                      <option value="{{ $i }}" {{ ($period) == $i ? "selected":"" }}>{{$i}}</option>
                      @endfor
                </select>  
            </div>
            

            <div class="col-md-2">          
                <label class="control-label">Allocation Type</label>
                <select class="form-control" id="allocationType" name="allocationType" onchange="ReloadForm()" required="">
                   <option value=""  > Choose One</option>     
                  @foreach($AllocationType as $list)
                  <option value="{{$list->ID}}" {{ ($allocationType) == $list->ID? "selected":"" }}>{{$list->allocation}}</option>
                  @endforeach
                </select>
            </div>


            <div class="col-md-2">          
                <label class="control-label">Account Type</label>
                <select class="form-control" id="economicGroup" name="economicGroup" onchange="ReloadForm()" required="">
                   <option value=""  >Choose One</option>     
                  @foreach($EconomicGroup as $list)
                  <option value="{{$list->ID}}" {{ ($economicGroup) == $list->ID? "selected":"" }}>{{$list->contractType}}</option>
                  @endforeach
                </select>
            </div>


            <div class="col-md-2">          
                <label class="control-label">Economic Head</label>
                <select class="form-control" id="economicHead" name="economicHead" onchange="ReloadForm()" required="">
                   <option value=""  >Choose One</option>     
                  @foreach($EconomicHead as $list)
                  <option value="{{$list->ID}}" {{ ($economicHead) == $list->ID? "selected":"" }}>{{$list->economicHead}}</option>
                  @endforeach
                </select>
            </div>

            <div class="col-md-2">          
                <label class="control-label">Status</label>
                <select name="stat" class="form-control" id="stat" onchange="ReloadForm()" required>
                 <option value="" >-select Status</option>
                        <option value="All" {{ ($stat === 'All') ? "selected" : ""}}>All</option>  
                        <option value="0" {{ ($stat === "0") ? "selected":""}}>Pending</option>
                        <option value="1" {{ ($stat === "1") ? "selected":""}}>Approved</option> 
                </select>  
            </div>

        </div>
            </div>
          <!-- /.col --> 
        </div>
        <!-- /.row -->

        </form>

            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table class="table table-bordered table-striped table-highlight" >
                  <form method="post" id="form2" name="form2">
                    {{ csrf_field() }}
                    <div class="col-md-6"></div>
                              <div class="col-md-6 " >
                                  <div class="col-md-0 checkbox pull-right" style="margin:2px;">
                                    <label class="text-primary" for="check-all">
                                      <input  type="checkbox" class="checkitem" id="toggle" value="select" onClick="do_this()">CheckAll
                                    </label>
                                  </div>
                                  
                                    <div class="col-md-0 pull-right" style="margin:2px;" >
                          <button  class="btn btn-success " type="submit" id="" value="" name="insert"> Approve <i class="fa fa-check"></i> </button>
                          </div>
                        </div>
                    <thead>
                        <tr bgcolor="#c7c7c7">
                               
                            
                            <th >S/N</th>
                            <th > AllocationType</th>
                            <th > Account Type</th>
                            <th > Economic Head</th>
                            <th > Economic Code</th>
                            <th > Period</th>
                            <th > Budget</th>
                            <th > Created By</th>
                            <th > Date</th>
                            <th > Status</th>

                            <th > Action</th>   
                        </tr>
                    </thead>
                    @php $i=1;@endphp
                   
                       
                        @foreach ($budget as $con)

                        <tr>
                        <td>{{$i++}}</td>
                        <td>{{$con->allocation}}</td>
                        <td>{{$con->contractType}}</td>
                        <td>{{$con->economicHead}}</td>
                        <td>{{$con->description}} | {{$con->economicCode}}</td>
                        <td>{{$con->Period}}</td>
                        <td>&#x20A6 {{number_format($con->allocationValue)}}</td>
                        <td>{{$con->createdByName}}</td>
                        <td>{{$con->createdDate}}</td>
                        
                        <td> 

                          @php 
                          if($con->AllocationStatus == 1)
                          { echo  "<h4 class='btn-success'> Approved</h4>";} 
                          else if($con->AllocationStatus == 0) 
                            { echo "<h4 class='btn-warning'> Pending</h4>";}
                          @endphp

                        <td>
                           @php 
                          if($con->AllocationStatus == 0)
                          {  @endphp
                            <button type="button" class="btn btn-success fa fa-edit" onclick="editfunc( '{{$con->b_id}}' )" class="" id=""> Approve</button>
                            <input type="checkbox" name="checkbox[]" id="B_id" value="{{$con->b_id}}">

                           @php

                          }

                          @endphp
                        </td>
                            
                        @endforeach
                    </tr>
                  </form>
                </table>
                  <div >
                   <div class="hidden-print">{{ $budget->links() }}</div>
                  Showing {{($budget->currentpage()-1)*$budget->perpage()+1}}
                          to {{$budget->currentpage()*$budget->perpage()}}
                          of  {{$budget->total()}} entries
                </div>
            </div>
          
          <hr />
        </div>
       
  </div>
</div>




@endsection

@section('styles')
<style type="text/css">
    .modal-dialog {
width:15cm
}

.modal-header {

background-color: #20b56d;

color:#FFF;

}

</style>
@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>


  function do_this(){

        var checkboxes = document.getElementsByName('checkbox[]');
        var button = document.getElementById('toggle');

        if(button.value == 'select'){
            for (var i in checkboxes){
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'deselect'
        }else{
            for (var i in checkboxes){
                checkboxes[i].checked = '';
            }
            button.value = 'select';
        }
    }


  function  ReloadForm()
  { 
  document.getElementById('thisform1').submit();
  return;
  }

  function  ReloadForm2()
  { 
  document.getElementById('editBModal').submit();
  return;
  }

    function editfunc(a)
    {
    $(document).ready(function(){
        $('#B_id').val(a);
        $("#editModal").modal('show');
     });
    }

    function delfunc(a,b)
  {
  $(document).ready(function(){
  $('#conID').val(a);
  $('#status').val(b);
  $("#delModal").modal('show');
  });
  }


  window.onload = function() {
    var selItem = sessionStorage.getItem("SelItem");  
    $('#periody').val(selItem);
    }
    $('#periody').change(function() { 
        var selVal = $(this).val();
        sessionStorage.setItem("SelItem", selVal);
    });





    
</script>



@stop
