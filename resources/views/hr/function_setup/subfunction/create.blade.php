@extends('layouts.layout')

@section('pageTitle')

Add Sub Function

@endsection

<style type="text/css">
  .row
  {
    margin-bottom: 10px;
  }

</style>


@section('content')

<div id="page-wrapper" class="box box-default">

  <div class="container-fluid">

    <div class="col-md-12 text-success"><!--2nd col--> 

      <big><b>@yield('pageTitle')</b></big> </div>

    <br />

    <hr >

    <div class="row">

      <div class="col-md-9"> <br>

        @if (count($errors) > 0)

        <div class="alert alert-danger alert-dismissible" role="alert">

          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>

          <strong>Error!</strong> @foreach ($errors->all() as $error)

          <p>{{ $error }}</p>

          @endforeach </div>

        @endif                       

        

        @if(session('message'))

        <div class="alert alert-success alert-dismissible" role="alert">

          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>

          <strong>Success!</strong> {{ session('message') }}</div>

        @endif

        @if(session('error_message'))

        <div class="alert alert-error alert-dismissible" role="alert">

          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>

          <strong>Error!</strong> {{ session('error_message') }}</div>

        @endif

        <form method="post" action="{{ url('/sub-function/add') }}" class="form-horizontal">

          {{ csrf_field() }}

          <div class="form-group">

            <label for="section" class="col-md-3 control-label">Select Function</label>

            <div class="col-md-9">

              <select name="function" id="function" class="form-control">

                <option value="">Select</option>

                @foreach($functions as $list)
                @if($list->functionID == session('functionId'))
                <option value="{{$list->functionID}}" selected="selected">{{$list->function_name}}</option>
                @else
                <option value="{{$list->functionID}}">{{$list->function_name}}</option>
                @endif
                @endforeach

                          

              </select>

            </div>

          </div>

          <div class="form-group">

            <label for="section" class="col-md-3 control-label">Sub Function/Display Name</label>

            <div class="col-md-9">

              <input id="name" type="text" class="form-control" name="subFunction" value="{{ old('name') }}" required>

            </div>

          </div>

          <div class="form-group">

            <label for="section" class="col-md-3 control-label">RANK</label>

            <div class="col-md-9">

              <input id="route" type="text" class="form-control" name="rank" required >

            </div>

          </div>

          <div class="form-group">

            <label for="section" class="col-md-3 control-label">Short Code</label>

            <div class="col-md-9">

              <input id="" type="text" class="form-control" name="shortCode" required >

            </div>

          </div>

          <div class="form-group">

            <div class="col-sm-offset-3 col-sm-9">

              <button type="submit" class="btn btn-success btn-sm pull-right">Add</button>

            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

</div>

<div id="page-wrapper" class="box box-default">

<div class="box-body">

  <h2 class="text-center">All Sub Function</h2>

  <div class="row"> {{ csrf_field() }}

    <div class="col-md-12">

      <table class="table table-striped table-condensed table-bordered input-sm">

        <thead>

          <tr class="input-sm">

            <th>S/N</th>

            <th>FUNCTION</th>

            <th>SUB FUNCTION</th>

            <th>SHORT CODE</th>

            <th>DATE CREATED</th>

            <th></th>

          </tr>

        </thead>

        <tbody>

        @php $key = 1; @endphp

        @foreach($subfunctions as $list)

        <tr>

          <td>{{($subfunctions->currentpage()-1) * $subfunctions->perpage() + $key ++}}</td>

          <td>{{strtoupper($list->function_name)}}</td>

          <td>{{strtoupper($list->sub_function_name)}}</td>

          <td>{{strtoupper($list->short_code)}}</td>

          <td>{{$list->created_at}}</td>

          <td><a href="#" title="Edit" id="{{$list->subfunctionID}}" class="btn btn-success fa fa-edit edit"></a></td>

        </tr>

        @endforeach

        </tbody>

      </table>

      <hr />

      <div align="right">

          Showing {{($subfunctions->currentpage()-1)*$subfunctions->perpage()+1}}

                  to {{$subfunctions->currentpage()*$subfunctions->perpage()}}

                  of  {{$subfunctions->total()}} entries

      </div>

      <div class="hidden-print">{{ $subfunctions->links() }}</div>

    </div>

  </div>

  <!-- /.col --> 

</div>

<!-- modal bootstrap -->
<form action="{{url('/sub-function/update')}}" method="post">
{{ csrf_field() }} 
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Update Sub Module</h4>
            </div>
            <div class="modal-body">
           
            <div class="row">      
            <div class="form-group">
            <label for="section" class="col-md-3 control-label">Select Function</label>
            <div class="col-md-9">
            <select name="function" class="form-control">
              @foreach($functions as $list)
              @if($list->functionID == session('functionId'))
             <option value="{{$list->functionID}}" selected="selected">{{$list->function_name}}</option>
              @else
              <option value="{{$list->functionID}}">{{$list->function_name}}</option>
              @endif
              @endforeach
            </select>
            </div>
          </div>

        </div>

          <div class="row"> 
          <div class="form-group">
           
            <label for="section" class="col-md-3 control-label">Sub Function Name</label>
            <div class="col-md-9">
              <input id="subFunction" type="text" class="form-control" name="subFunction" value="" required>
              <input id="id" type="hidden" class="form-control" name="subFunctionID" value="" required>
          </div>
        </div>
      </div>

           <div class="row"> 
          <div class="form-group">
            <label for="section" class="col-md-3 control-label">Rank</label>
            <div class="col-md-9">
               <input id="rank" type="text" class="form-control" name="rank" value="" required>
            </div>
          </div>
        </div>

      <div class="row"> 
       <div class="form-group">
          <label for="section" class="col-md-3 control-label">Short Code</label>
            <div class="col-md-9">
              <input id="short" type="text" class="form-control" name="shortCode" required value="">
          </div>
        </div>
      </div>       

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
</form>
<!--// modal Bootstrap -->


@endsection 

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function(){
  
$("#function").on('change',function(){
  var id = $(this).val();
//alert(id);
  $token = $("input[name='_token']").val();
 $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/sub-function/setsession') }}",

  type: "post",
  data: {'function':id},
  success: function(data){
  location.reload(true);
  }
});

   

});
 });
</script>


<script type="text/javascript">
$(document).ready(function(){
 $('table tr td .edit').click(function(){
  var id = $(this).attr('id');
//alert(id);
$.ajax({
  url: murl +'/sub-function/modify',
  type: "post",
  data: {'id': id, '_token': $('input[name=_token]').val()},
  success: function(data){
console.log(data.short_code);
   $('#subFunction').val(data.sub_function_name);
   $('#id').val(data.subfunctionID);
   $('#short').val(data.short_code);
   $('#rank').val(data.sub_function_rank);
  }
});

});
});
</script>

<script>

  $(document).ready(function(){
$('table tr td .edit').click(function()
{

$("#myModal").modal('show');
})

  });
</script>

@stop