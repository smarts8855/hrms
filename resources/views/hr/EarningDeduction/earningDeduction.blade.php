@extends('layouts.layout')
@section('pageTitle')
Earning and Deduction Set-up
  
@endsection



@section('content')

<div id="editModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Particular</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="editpartModal" name="editpartModal"
                    role="form" method="POST" action="{{url('/earning-deduction/update')}}">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-2 control-label">Description</label>
                    </div>
                    <div class="col-sm-9">
                    <textarea rows="4" cols="50" id="descriptions" name="descriptions"></textarea>
                    </div>
                    <div class="col-sm-3">
                    <select class="form-control" id="partStatus" name="partStatus">  
                        <option value='0'>Inactive</option>
                        <option value='1'>Active</option>     
                    </select>
                    </div>
                    <input type="hidden" id="partid" name="partid" value="">
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
    

<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col--> 
          @include('Share.message')
        
        <form class="form-horizontal" role="form" method="post" action="{{url('/earning-deduction/add')}}">
        {{ csrf_field() }}

        <div class="col-md-12"><!--2nd col-->
          <!-- /.row -->
          <div class="form-group">
          <div class="col-md-4">          
                <label class="control-label">Earning/Deduction</label>
                <select class="form-control" id="particulars" name="particulars">
                <option value=""  >-select Particular</option>
                @foreach($getep as $list)
                <option value="{{$list->ID}}" {{$ID==$list->ID? "selected":""}} >{{$list->Particular}}</option>
                @endforeach         
                </select>
            </div>
            
            <div class="col-md-4">
                <label class="control-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="">
            </div>

            <div class="col-md-4">
                <br>
                <button type="submit" class="btn btn-success" name="add">
                    <i class="fa fa-btn fa-floppy-o"></i> Add
                </button>
            </div>
        </div>
            </div>
          <!-- /.col --> 
        </div>
        <!-- /.row -->

        </form>

            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table id="mytable" class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            	 
                            
                            <th >S/N</th>
                            <th >Earning/Deduction</th>
                            <th >Description</th>
                            <th >Status</th> 
                            <th >Edit</th> 
                        </tr>
                    </thead>
                    @php $i=1;@endphp
                    @foreach($getedj as $list)
                    @php if($list->status==0)
                    {
                       $astatus='Inactive';
                    }else {
                    $astatus='active';
                    }
                    @endphp
                    
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$list->Particular}}</td>
                        <td>{{$list->description}}</td>
                        <td>{{$astatus}}</td>
                        <td>
                            <a style="color: blue; cursor: pointer;" 
                            onclick="editfunc('{{$list->ID}}','{{$list->description}}', '{{$list->status}}')">Edit</a>
                        </td>
                            
                    </tr>
                    @endforeach
                </table>
        
            </div>
          
          <hr />
        </div>
       
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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script>
    function editfunc(x,y,z)
    {
    $(document).ready(function(){
        $('#partid').val(x);
        $('#descriptions').val(y);
        $('#partStatus').val(z);
        $("#editModal").modal('show');
     });
    }
    
    $(document).ready(function() {
    $('#mytable').DataTable();
} );
     
</script>
@stop

