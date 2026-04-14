  @extends('layouts.layout')
  @section('pageTitle')
  E-payment
  @endsection
  @section('content')
  <form method="POST" action="{{ url('/council-members/create') }}" >
    <div class="box-body" style ="background:#fff;">
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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> 
            {{ session('msg') }}
          </div>                        
          @endif
        </div>
        {{ csrf_field() }}
        <div class="col-md-12">
         <h4 class="" style="text-transform:uppercase">Create Council Members</h4>
          <div class="row">
        

                @if ($CourtInfo->courtstatus==1)
        <div class="col-md-6">
              <div class="form-group">
                <label>Select Court</label>
                <select name="court" id="court" class="form-control" style="font-size: 13px;">
                  <option value="">Select Court</option>
                  @foreach($courts as $court)
                  @if($court->id == session('anycourt'))
                  <option value="{{$court->id}}" selected="selected">{{$court->court_name}}</option>
                @else
                <option value="{{$court->id}}" @if(old('court') == $court->id) selected @endif>{{$court->court_name}}</option>
                @endif
                  @endforeach
                </select>
                 
              </div>
            </div>

          @else
            <input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
          @endif

            @if ($CourtInfo->divisionstatus==1)
          <div class="col-md-6">
              <div class="form-group">
                <label>Select Division</label>  
                <select name="division" id="division_" class="form-control" style="font-size: 13px;">
                <option value="">Select Division</option>
                 @foreach($courtDivisions as $divisions)
                 <option value="{{$divisions->divisionID}}" @if(old('division') == $divisions->divisionID) selected @endif>{{$divisions->division}}</option>
                 @endforeach
                </select>
               </div>
              </div>
            @else
              <input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">
            @endif
            
            <div class="col-md-3">
            <div class="form-group">
              <label >Title</label>
              <input type="text" name="title" class="form-control" value="{{old('title')}}"> 
              
            </div>
          </div>
          
           <div class="col-md-3">
            <div class="form-group">
              <label >Surname</label>
              <input type="text" name="surname" class="form-control" value="{{old('surname')}}"> 
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label >First Name</label>
              <input type="text" name="firstName" class="form-control"  value="{{old('otherNames')}}"> 
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label >Other Names</label>
              <input type="text" name="otherNames" class="form-control" value="{{old('othernames')}}"> 
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="form-group">
              <label >P.V.No.</label>
              <input type="text" name="pvNumber" class="form-control" value="{{old('pvNumber')}}"> 
            </div>
          </div>
        
          <div class="col-md-4">
            <div class="form-group">
              <label> Bank </label>
              <select name="bank" id="section" class="form-control">
                <option value="">Select Bank </option>
                @foreach($banks as $list)
                <option value="{{$list->bankID}}" @if(old('bank') == $list->bankID) selected @endif>{{$list->bank}}</option>
                @endforeach
              </select>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="form-group">
              <label >Account Number</label>
              <input type="text" name="accountNumber" class="form-control"> 
            </div>
          </div>
         
          <div class="col-md-12">
            <div class="form-group">
              <div >
                <button type="submit" class="btn btn-success btn-sm pull-right">Create</button>
              </div>
            </div>           
          </div>
          
 
  </div><!-- /.row -->
  
  <div class="row">
  <div class="col-md-12">
  <table class="table">
  <thead>
  <tr>
  <th>SN</th>
  <th>Title</th>
  <th>Name</th>
  <th>Bank</th>
  <th>Account Number</th>
  </tr>
  </thead>
  @php
  $i = 1;
  @endphp
  <tbody>
  @foreach($cm as $list)
  
   <tr>
  <td>{{$i++}}</td>
  <td>{{$list->council_title}}</td>
  <td>{{$list->surname}} {{$list->first_name}} {{$list->othernames}}</td>
  <td>{{$list->bank}}</td>
  <td>{{$list->AccNo}}</td>
  <td><a href="{{url('/edit/council-member/'.$list->ID)}}" class="btn btn-success"><i class="fa fa-pencil"></i></a></td>
  </tr>
  
  @endforeach
  
 
  </tbody>
  
  </table>
  </div>
  </div>
</div><!-- /box body -->
</form>
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



