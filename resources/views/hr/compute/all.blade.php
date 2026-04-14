@extends('layouts.layout')
@section('pageTitle')
Compute Payroll 
@endsection

@section('content')
<form method="post" action="{{ url('/compute/computeAll') }}">

  <div class="box-body" style= "background:#FFF;">
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

        @if(session('msg'))

        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> 
          {{ session('msg') }}
        </div>                        
        @endif
        @if(session('err'))
        <div class="alert alert-error alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Error!</strong> 
          {{ session('err') }}
        </div>                        
        @endif

      </div>
      {{ csrf_field() }}

      <div class="col-md-4 col-md-offset-4"><!--2nd col-->


       <div class="row">

      <div class="col-md-12">
              <div class="form-group">
                <label>Select Court</label>
                <select name="court" id="court" class="form-control" style="font-size: 13px;">
                  <option value="">Select Court</option>
                  @foreach($courts as $court)
                  
                  <option value="{{$court->id}}">{{$court->court_name}}</option>
                
                  @endforeach
                </select>
                 
              </div>
            </div>

      </div>


       <div class="row">

      <div class="col-md-12">
              <div class="form-group">
                <label>Select Division</label>
               
                <select name="division" id="division" class="form-control" style="font-size: 13px;">
                 
                </select>
              </div>
            </div>

      </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="month">Month</label>
              <input type="Text" name="month" id="month" class="form-control" value="" readonly>
            </div>
          </div><div class="col-md-12">
          <div class="form-group">
            <label for="year">Year</label>
            <input type="Text" name="year" id="year" class="form-control" value="" readonly>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for=""></label>
            <div align="right">
              <input class="btn btn-success" name="btn" type="submit" value="Compute"/>
              <input class="btn btn-success" name="btn" type="submit" value="Re-Compute" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->
</form>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
   $(document).ready(function(){
  
$("#court").on('change',function(){
  var id = $(this).val();

  $token = $("input[name='_token']").val();
 $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/court/getActiveMonth') }}",

  type: "post",
  data: {'courtID':id},
  success: function(data){
  $('#year').val(data[0].year);
  $('#month').val(data[0].month);
console.log(data[0].year);
  }
});

   

});
 });
</script>

<script type="text/javascript">
   $(document).ready(function(){
  
$("#court").on('change',function(){
  var id = $(this).val();

  $token = $("input[name='_token']").val();
 $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/court/getDivisions') }}",

  type: "post",
  data: {'courtID':id},
  success: function(data){
     $('#division').empty();
     $('#division').append( '<option value="">All Divisions</option>' );
   $.each(data, function(data, obj){
       
 $('#division').append( '<option value="'+obj.divisionID+'">'+obj.division+'</option>' );
              
        
             });  
console.log(data[0].year);
  }
});

   

});
 });
</script>
@endsection
