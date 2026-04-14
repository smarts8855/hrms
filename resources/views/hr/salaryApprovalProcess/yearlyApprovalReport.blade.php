@extends('layouts.layout')
@section('pageTitle')
Payroll Summary
@endsection
@section('content')
<div class="containerf" style="background:#FFF; float:left; width:100%">
    
    <form method="post" action="{{ url('/approval-report') }}" style="margin-top:40px;">
     
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
          <strong>Error!</strong> 
          {{ session('err') }}
        </div>                        
        @endif
      </div>
      {{ csrf_field() }}    
      <div class="col-md-12">
        <div class="row"> 

          <div class="col-md-10">
            <div class="form-group">
              <label >Select a Year</label>
              <select name="year" id="section" class="form-control">
                <option value="">Select Year</option>
                @for($i=2011;$i<=2040;$i++)
                 <option value="{{$i}}" @if(old('year') == $i) selected @endif>{{$i}}</option>
                @endfor
              </select>
            </div>
          </div>
           <div class="col-md-1">
            <div class="form-group">
              <label></label>
              <div >
                <button type="submit" class="btn btn-success pull-right">Display</button>
              </div>
            </div>           
          </div>
        </div>
      </div>
    
</form>
<div class="">
    <div class="col-md-12">
        
        <h3>Monthly Approval Proccess Report</h3>
        
    <table class="table table-responsive table-striped" style="margin-top:30px">
        <thead>
            <th>SN</th>
            <th>Month</th>
            <th>Comment</th>
        </thead>
        
        <tbody>
            <?php
            $n = 1;
            ?>
            @foreach($report as $list)
            <tr>
                <td>{{$n++}}</td>
                <td>{{$list->month}}</td>
                <td>{{$list->comment}}</td>
                
            </tr>
            @endforeach
            
        </tbody>
    
    </table>
        
    </div>
</div>
</div>


@endsection
@section('styles')
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

