@extends('layouts.layout')
@section('pageTitle')
Payroll Report
@endsection
@section('content')

  <div class="box-body" style="background:#FFF;">
<div style = "clear:both"></div>
    <div class="row">
      <div class="col-md-12"><!--1st col-->
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
        @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> 
          {{ session('message') }}
        </div>                        
        @endif

         @if(session('err'))
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> 
          {{ session('err') }}
        </div>                        
        @endif

      </div>
      </div>
    </div>

  <div class="box-body" style="background:#FFF;">
<div class="container-fluid">
  <h3>Add Percentage</h3>
  <form method="post" action="{{ route('percentage-add') }}">
      {{ csrf_field() }}
  <div class="row">
    <input type="hidden" class="form-control" name="id" value="{{ $data->id}}"> 
    <div class="col-sm-4" >Pension: <input type="text" class="form-control" placeholder="Enter Pension" name="pension" id="input" value="{{ $data->pension}}" required></div>
    <div class="col-sm-4" >NHF: <input type="text" class="form-control" placeholder="Enter NHF" name="nhf" id="input" value="{{ $data->nhf}}" required></div>
    <div class="col-sm-4" >Union: <input type="text" class="form-control" placeholder="Enter Union" name="union" id="input" value="{{ $data->union_due}}" required></div>
    
  </div>
  <div class="row">
    <div class="col-sm-4" >Tax: <input type="text" class="form-control" placeholder="Enter Tax" name="tax" id="input" value="{{ $data->tax}}" required></div>
    <div class="col-sm-4" >NHIS: <input type="text" class="form-control" placeholder="Enter NHIS" name="nhis" id="input"value="{{ $data->nhis}}" required></div>
     <div class="col-sm-4" >NSITF: <input type="text" class="form-control" placeholder="Enter NSITF" name="nsitf" id="input"value="{{ $data->nsitf}}" required></div>
  </div>
  <br>
   <div class="row">
     
    <div class="col-sm-12" ><button type="submit" class="btn btn-success">Update</button></div>
    
  </div>
  </form>
</div>
    
  </div><!-- /.col -->
</div><!-- /.row -->





      

@endsection


@section('styles')

<style>
    #inputs{
        width:120px;
    }
</style>
@endsection


@section('scripts')

<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>


<script type="text/javascript">

$(document).ready(function(){
 
$("#court").on('change',function(e){
   e.preventDefault();
  var id = $(this).val();
//alert(id);
  $token = $("input[name='_token']").val();
 $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: murl +'/session/court',
 
  type: "post",
  data: {'courtID':id},
  success: function(data){
  location.reload(true);
  //console.log(data);
  }
});

});
 });
</script>


@endsection


