@extends('layouts.layout')
@section('pageTitle')
Add Court
@endsection

@section('content')

<div id="editModal" class="modal fade">
    <div class="modal-dialog box box-default" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Court Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" id="editpartModal" name="editpartModal" enctype="multipart/form-data"
                role="form" method="POST" action="{{url('/court/add-court/update')}}">
                {{ csrf_field() }}
        <div class="modal-body">  
            <div class="form-group">
                <div class="col-sm-9">
                    <label class="control-label">Court Name</label>
                    <input type="text" class="form-control" id="courtName" name="courtName">
                </div>
                <div class="col-sm-3">
                    <label class="control-label">Abrv</label>
                    <input type="text" class="form-control" id="court_abbriviation" name="court_abbriviation">
                </div>
                <input type="hidden" id="courtid" name="courtid" value="">
            </div>
            <div class="form-group" style="margin: 0 10px;">
                <div class="col-md-6">
                    <input type="file" name="courtImageEdit" accept="image/*" onchange="preview_image(event)">
                </div>
                <div id="imagewrapper" class="col-md-6" >
                           
                    <img id ="edit_image">
                </div>
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
        <div class="col-md-12">

    @include('Share.message')

    <form method="post"  role="form" id="addForm" name="addForm" enctype="multipart/form-data" action="{{url('court/add-court/insert')}}">
            {{ csrf_field() }}
            <div class="box-body">
                 <div class="row">
                     <div class="col-md-3">
                        <label>New Court</label>
                        <input type="text" class="form-control" id="court_name"
                         name="court_name" placeholder="">
                    </div>
                            
                    <div class="col-md-2">
                        <label>Abrv</label>
                        <input type="text" class="form-control" id="courtAbbr" 
                        name="courtAbbr" placeholder="">
                    </div>
                    
                    <div class="col-md-5">
                        <div class="col-md-12">
                            <label>logo</label>
                        </div>
                        <div class="col-md-6">
                        <input type="file" name="courtImage" accept="image/*" onchange="preview_image(event)">
                        </div>
                        <div id="imagewrapper" class="col-md-6" >
                           
                                <img id ="output_image" src="{{ asset("/courtLogo/noimage.png") }}">
                        </div>
                    </div>
                    <div class="col-md-1">
                    <br>
                        <button type="submit" class="btn btn-success" name="Create">
                            <i class="fa fa-btn fa-floppy-o">Create</i> 
                        </button>						
                    </div>
                            
                </div>
                
            <input id ="delcode" type="hidden"  name="delcode" >
            <div class="table-responsive" style="font-size: 12px; padding:10px;">
                <table id="mytable" class="table table-bordered table-striped table-highlight" >
                <thead>
                <tr bgcolor="#c7c7c7">
                    <th width="1%">S/N</th>	 
                    <th >Court Abbreviation</th>
                    <th >Court Name</th>
                    <th>Logo</th>
                    <th >Edit</th>
                    <th >Action</th>
                </tr>
                </thead>
                @php $i=1;
                
                @endphp

                
                @foreach($getAllCourts as $list)
                <tr>
                <td>{{$i++}}</td>
                <td>{{$list->courtAbbr}}</td>
                <td>{{$list->court_name}}</td>
                <td><img id ="dispImage" src="{{ asset('/courtLogo/'.$list->logoName) }}"></td>
                <td><a onclick="editfunc({{ json_encode([$list]) }})">Edit</a>
                <td><a href="{{url('court/add-court/delete'.$list->id)}}" 
                    onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>         
                </tr>
                @endforeach            
                 </table>
            </div>
            </div>
            
        </form>
        </div>
      </div>
        </div>
    </div>

</div>

@endsection

@section('styles')
<style type="text/css">
.modal-dialog {
width:11cm
}

.modal-header {

background-color: #006600;

color:#FFF;

}

img {
    max-width: 100%;
    max-height: 100%;
}
#imagewrapper{
    width: 150px;
    height:150px;
}
#dispImage{
    width: 50px;
    height:50px;
}

</style>
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type='text/javascript'>
    function preview_image(event) 
    {
        
     var reader = new FileReader();
     reader.onload = function()
     {
        if(event.target.name=='courtImage')
        {
            var output = document.getElementById('output_image');
            output.src = reader.result;
        }else if(event.target.name=='courtImageEdit'){
            var output = document.getElementById('edit_image');
            output.src = reader.result;
        }
       
     }
     reader.readAsDataURL(event.target.files[0]);
    }

    function editfunc(list)
    {
        $(document).ready(function()
        { 
           var path ="{{ asset('/courtLogo') }}";
            $('#courtid').val(list[0].id);
            $('#courtName').val(list[0].court_name);
            $('#court_abbriviation').val(list[0].courtAbbr);
            $("#edit_image").attr("src",path+'/'+list[0].logoName);
            $("#editModal").modal('show');
        });
    
    }
    
    $(document).ready(function() {
    $('#mytable').DataTable();
} );

    </script>
@stop