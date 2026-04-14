@extends('layouts.layout')
@section('pageTitle')
  <strong>Add Title</strong>
  
@endsection

@section('content')

<div id="editModal" class="modal fade">
    <div class="modal-dialog box box-default" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Title</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" id="editTitleModal" name="editTitleModal"
                role="form" method="POST" action="{{url('/title/update')}}">
                {{ csrf_field() }}
        <div class="modal-body">  
            <div class="form-group" style="margin: 0 10px;">
                <label class="col-sm-2 control-label">Title</label>
                <input type="text" class="col-sm-9 form-control" id="titleChange" name="titleChange">
                <input type="hidden" id="titleid" name="titleid" value="">
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


<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col--> 
          @include('Share.message')
        
        <form class="form-horizontal" role="form" method="post" action="{{url('/title/add')}}">
        {{ csrf_field() }}
        <div class="box-body">
            <div class="row">
                <div class="col-md-5">
                   <label>Add Title</label>
                   <input type="text" class="form-control" id="title"
                    name="title" placeholder="">
               </div>
               <div class="col-md-3">
               <br>
                   <button type="submit" class="btn btn-success" name="Add">
                       <i class="fa fa-btn fa-floppy-o"></i> Add
                   </button>						
               </div>
                       
           </div>
       <div class="table-responsive" style="font-size: 12px; padding:10px;">
           <table id="mytable" class="table table-bordered table-striped table-highlight" >
           <thead>
           <tr bgcolor="#c7c7c7">
               <th width="1%">S/N</th>	 
               <th >TITLE</th>
               <th >EDIT</th>
               <th >DELETE</th>
           </tr>
           </thead>
           @php $i=1;@endphp
           @foreach($getAllTitles as $list)
           <tr>
           <td>{{$i++}}</td>
           <td>{{$list->title}}</td>
           <td><a style="color: blue; cursor: pointer;" onclick="editfunc('{{$list->title}}', '{{$list->ID}}')">Edit</a></td>
           <td><a style="color: blue;" href="{{url('/title/remove/'.$list->ID.'/'.$list->title)}}" 
            onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>         
           </tr>
           @endforeach            
            </table>
       </div>
       </div>
        

        </form>
          <hr />
        </div>
       
  </div>
</div>
  </div>
</div>

@endsection

@section('styles')
<style type="text/css">
    .modal-dialog {
width:10cm
}

.modal-header {

background-color: #006600;

color:#FFF;

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
        $('#titleChange').val(x);
        $('#titleid').val(y);
        $("#editModal").modal('show');
     });
    }
    
    $(document).ready(function() {
    $('#mytable').DataTable();
} );
</script>

@stop

