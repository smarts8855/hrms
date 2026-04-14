@extends('layouts.layout')

@section('pageTitle')

Add New Function

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

        <form method="post" action="{{ url('/function/add') }}" class="form-horizontal">

          {{ csrf_field() }} 

          <!--<div class="form-group">

                        <label for="section" class="col-md-3 control-label">Select Role</label>

                        <div class="col-md-9">

                          <select name="role" class="form-control" id="role">

                          <option value="">Select One</option>

                          @foreach($roles as $list)

                         

                            <option value=""></option>

                           

                            @endforeach

                          </select>

                        </div>

                      </div>-->

          

          <div class="form-group">

            <label for="section" class="col-md-3 control-label">Function Name</label>

            <div class="col-md-9">

              <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>

            </div>

          </div>

          <div class="form-group">

            <label for="section" class="col-md-3 control-label">Function Rank</label>

            <div class="col-md-9">

              <input id="name" type="text" class="form-control" name="rank" value="{{ old('name') }}" required>

            </div>

          </div>

          <div class="form-group">

            <div class="col-sm-offset-3 col-sm-9">

              <button type="submit" class="btn btn-success btn-sm pull-right">Add Function</button>

            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

</div>

<div id="page-wrapper" class="box box-default">

<div class="box-body">

  <h2 class="text-center">ALL Function</h2>

  <div class="row"> {{ csrf_field() }}

    <div class="col-md-12">

      <table class="table table-striped table-condensed table-bordered input-sm">

        <thead>

          <tr class="input-sm">

            <th>S/N</th>

            <th>FUNCTION NAME</th>
            <th>FUNCTION RANK</th>
            <th>DATE CREATED</th>

            <th></th>

          </tr>

        </thead>

        <tbody>

        

        @php $key = 1; @endphp

        @foreach($functions as $list)

        <tr>

          <td>{{($functions->currentpage()-1) * $functions->perpage() + $key ++}}</td>

          <td>{{strtoupper($list->function_name)}}</td>
          <td>{{$list->function_rank}}</td>
          <td>{{$list->created_at}}</td>

          <td><a href="#" id="{{$list->functionID}}" title="Edit" class="btn btn-success fa fa-edit edit"></a></td>

        </tr>

        @endforeach

        </tbody> 

      </table>

       <hr />

      <div align="right">

          Showing {{($functions->currentpage()-1)*$functions->perpage()+1}}

                  to {{$functions->currentpage()*$functions->perpage()}}

                  of  {{$functions->total()}} entries

      </div>

      <div class="hidden-print">{{ $functions->links() }}</div>

    </div>

  </div>

  <!-- /.col --> 

  

</div>



<!-- modal bootstrap -->
<form action="{{url('/function/update')}}" method="post">
{{ csrf_field() }} 
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Update Function</h4>
            </div>
            <div class="modal-body">
           
                    <div class="row">
                    <div class="form-group">

                        <label for="section" class="col-md-3 control-label">Function Name</label>
                        <div class="col-md-9">
                          <input id="function" type="text" class="form-control" name="name" value="" required>
                          <input id="id" type="hidden" class="form-control" name="functionID" value="" required>
                        </div>

                      </div>
                      </div> 

                       <div class="row">
                       <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Function Rank</label>
                        <div class="col-md-9">
                          <input id="functionRank" type="text" class="form-control" name="functionRank" value="" required>
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

<!--// modal Bootstrap -->
</form>



@endsection 

@section('scripts')

<script type="text/javascript" src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>


<script type="text/javascript">
$(document).ready(function(){
 $('table tr td .edit').click(function(){
  var id = $(this).attr('id');
//alert(id);
$.ajax({
  url: murl +'/function/modify',
  type: "post",
  data: {'id': id, '_token': $('input[name=_token]').val()},
  success: function(data){
console.log(data.function_name);
   $('#function').val(data.function_name);
   $('#id').val(data.functionID);
   $('#functionRank').val(data.function_rank);
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