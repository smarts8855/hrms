@extends('layouts.layout')
@section('pageTitle')
   User Modification
@endsection
@section('content')


<div id="editModal" class="modal fade">
    <div class="modal-dialog box box-default" role="document">
        <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">User Modification  </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form class="form-horizontal" id="editLgaModal" name="editLgaModal" role="form" method="POST" >
            {{ csrf_field() }}
    <div class="modal-body">  
        <div class="form-group" style="margin: 0 10px;">
            <label class="control-label">User Name</label>
            <input type="text" class="col-sm-9 form-control" id="username" readonly>
        </div>
        <div class="form-group" style="margin: 0 10px;">
            <label class="control-label">Names</label>
            <input type="text" class="col-sm-9 form-control" id="names" name="name" required>
        </div>
        <div class="form-group" style="margin: 0 10px;">
            <label class="control-label">Email</label>
            <input type="text" class="col-sm-9 form-control" id="email" name="email">
        </div>
        <div class="form-group" style="margin: 0 10px;">
            <label class="control-label">Divisions</label>
            <select name="division" id="division" class="form-control" required>
                <option value=''>-Select Division-</option>
                @foreach($divisionList as $b)
                <option value="{{$b->divisionID}}">{{$b->division}}</option>
                @endforeach 
            </select>
        </div>
        <div class="form-group" style="margin: 0 10px;">
            <label class="control-label">Roles</label>
            <select name="role" id="role" class="form-control" required>
                <option value=''>-Select Role-</option>
                @foreach($Rolelist as $b)
                <option value="{{$b->roleID}}">{{$b->rolename}}</option>
                @endforeach 
            </select>
        </div>
        <div class="form-group" style="margin: 0 10px;">
            <label class="control-label">Password</label>
            <input type="text" class="col-sm-9 form-control" id="password" name="password">
        </div>
        <div class="form-group" style="margin: 0 10px;">
            <label class="control-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value=''>-Select Status-</option>
                <option value="1">Active</option>
                <option value="0">InActive</option>
            </select>
        </div>
        <div class="form-group" style="margin: 0 10px;">
            <label class="control-label">Is Global</label>
            <select name="global" id="global" class="form-control" required>
                <option value=''>-Select Status-</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="modal-footer">
            <input type="hidden" id="id" name="id">
            <button type="Submit" name="edit" class="btn btn-success">Save changes</button>
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
        
                <table class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">
                               
                            <th > S/N</th>
                            <th > Username</th>
                            <th > Name</th>
                            <th> Email </th>
                            <th > Division</th>
                            <th > Role</th>
                            <th> Is global </th>
                            <th > Status</th>
                            <th > Action</th>   
                        </tr>
                    </thead>
                    @php $i=1;@endphp
                        @foreach ($users as $con)
                        <tr>
                        <td>{{$i++}}</td>
                        <td>{{$con->username}}</td>
                        <td>{{$con->name}}</td>
                        <td>{{$con->email_address}}</td>
                        <td>{{$con->division}}</td>
                        <td>{{$con->rolename}}</td>
                        <td>
                            @if($con->is_global == 1)
                                Yes
                            @else
                                No
                            @endif
                        </td>
                        <td>
                            @if($con->status == 1)
                                Active
                            @else
                                Inactive
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary fa fa-edit" onclick="editfunc('{{$con->id}}', '{{$con->username}}', '{{$con->name}}','{{$con->email_address}}','{{$con->roleID}}','{{$con->status}}', '{{$con->divisionID}}', '{{$con->is_global}}' )" class="" id=""> Edit</button>
                        </td>
                        @endforeach
                    </tr>
                </table>
          <hr />
          <div>
            {{$users->links()}}
        </div>
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
<script>
    function editfunc(id,usernane,names,email,roleID,status,division,global)
    {
    $(document).ready(function(){
        $('#username').val(usernane);
        $('#names').val(names);
        $('#email').val(email);
        $('#role').val(roleID);
        $('#status').val(status);
        $('#division').val(division);
        $('#global').val(global);
         $('#id').val(id);
        $("#editModal").modal('show');
     });
    }

    function delfunc(a)
  {
  $(document).ready(function(){
  $('#conID').val(a);
  $("#delModal").modal('show');
  });
  }

    
</script>

    </script>

@stop
