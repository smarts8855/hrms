@extends('layouts.layout')

@section('pageTitle')
Staff Rate Function
@endsection

@section('content')


  <div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Salary Rate</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form-horizontal" id="editRateModal" name="editRateModal"
                  role="form" method="POST" action="{{url('/salary-rate')}}">
                  {{ csrf_field() }}
          <div class="modal-body"> 
              <div class="form-group" style="margin: 0 10px;">
                  <label class="col-sm-4 control-label">Salary Rate</label>
                  <input type="number" class="col-sm-9 form-control" id="rateChange" name="rateChange"/ required>
                  <input type="hidden" id="salaryid" name="salaryid" value=""/>
              </div>
              <div class="modal-footer">
                  <button type="Submit" class="btn btn-success">Save changes</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
              </div>
              </form>
          </div>
        </div>
    </div>

  

<div class="box-body">
    <div class="box box-default">
    <div class="box-body box-profile">
    <div class="box-body">
    <div class="row">
      <div class="col-sm-12">
        @include('Share.message')
        <h4 class="noprint">Staff Rate Function</h4>
        <div class="noprint box-body">
            
          <div class="table-responsive" style="font-size: 12px; padding:10px;">
            <table id="mytable" class="table table-bordered table-striped table-highlight" >
               
            <thead>
            <tr bgcolor="#c7c7c7">
                <th width="1%">S/N</th>	 
                <th >Short Code</th>
                <th >Description</th>
                <th >Rate</th>
                <th >Action</th>
            </tr>
            </thead>
            @php $i=1;@endphp
            @foreach($salaryRates as $list)
            <tr>
            <td>{{$i++}}</td>
            <td>{{$list->code}}</td>
            <td>{{$list->description}}</td>
            <td>{{$list->rate}}</td>
            <td><a onclick="editfunc('{{$list->rate}}','{{$list->id}}')" >Edit</a></td>
            
            </tr>
            @endforeach            
             </table>
        </div>
  
        </div>
      </div>
      
    
    </div>
   
   
</div>
</div>
</div>

@endsection

@section('styles')
 <style>
 .modal-dialog
 {
  
   width: 400px
 }
 </style> 
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script>
  
   function editfunc(x,y)
    {
    $(document).ready(function(){

        
        $('#rateChange').val(x);
        $('#salaryid').val(y);
        $("#editModal").modal('show');
     });
    }

    $(document).ready(function() {
    $('#mytable').DataTable();
} );
    

</script>

@endsection

 


