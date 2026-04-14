@extends('layouts.layout')
@section('pageTitle')
Compute Payroll 
@endsection

@section('content')
<form method="post" action="{{ url('/compute/computeAll') }}">
{{ csrf_field() }}
  <div class="box-body" style= "background:#FFF;">
    
      

      


       <div class="row">
	
      <div class="col-md-12">
              <div class="form-group">
                <label>Select Court</label>
                <select name="court" id="court" class="form-control" style="font-size: 13px;">
                  <option value="">Select Court</option>
                  @foreach($CourtList as $b)                  
                  <option value="{{$b->id}}" {{ ($court) == $b->id? "selected":"" }}>{{$b->court_name}}</option>               
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
                 <option value="All">All Division</option>
                  @foreach($DivisionList as $b)                  
                  <option value="{{$b->divisionID}}" {{ ($division) == $b->divisionID? "selected":"" }}>{{$b->division}}</option>             
                  @endforeach
                </select>
              </div>
            </div>

      </div>

        <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="year">Year</label>
            <input type="Text" name="year" id="year" class="form-control" value="{{$year}}" readonly>
          </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
              <label for="month">Month</label>
              <input type="Text" name="month" id="month" class="form-control" value="{{$month}}" readonly>
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
     $('#division').append( '<option value="All">All Divisions</option>' );
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
