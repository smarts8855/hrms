@extends('layouts.layout')

@section('pageTitle')
  Staff Due For Arrears
@endsection
             
@section('content')
 
  <div class="box-body">
        <div class="row">
            <div class="col-md-12"><!---1st col-->
<h4 class="" style="text-transform:uppercase">Quarterly Allowance</h4>
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
                  <div class="alert alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                      </button>
                      <strong>Success!</strong>
		{{ session('err') }}
	        </div>
            @endif

            </div>


				<div class="col-md-12" style="padding-top:15px;"><!---2nd col-->
	<form method="post" action="{{ url('/quarterly-allowance/create') }}" style="margin-top:10px; padding-top:20px;">

            {{ csrf_field() }}
            
             @if ($CourtInfo->courtstatus==1)
        <div class="col-md-12" style="padding-top:20px;">
            <div class="form-group">
            <label for="staffName">Court</label>
            <select name="court" id="court" class="form-control court">

               <option>Select court</option>
               @foreach($court as $courts)
               @if($courts->id == session('anycourt'))
               <option value="{{$courts->id}}" selected="selected">{{$courts->court_name}}</option>
               @else
               <option value="{{$courts->id}}">{{$courts->court_name}}</option>
               @endif
               @endforeach
            </select>
            </div>
            </div>
          @else
            <input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
          @endif

 

									<div class="col-md-4">
										<div class="form-group">
										  <label for="fileNo">Grade</label>
										 <select name="grade" id="grade" class="form-control">
										 <option value="">Select</option>
										 @for($i=1;$i<=17; $i++)
										 <option value="{{$i}}">{{$i}}</option>
										 @endfor
										 </select>
										</div>
									</div>
                 <div class="col-md-4">
                    <div class="form-group">
                      <label for="fileNo">Gross</label>
                      <input type="Text" name="gross" class="form-control"  id="gross"  value="{{old('gross')}}"/>
                    </div>
                  </div>
								<div class="col-md-4">
								<div class="form-group">
								<label>Tax</label>
                                                                 <input type="Text" name="tax" class="form-control" id="tax" value="{{old('tax')}}"/>
								</div>
								</div>

									

					         <div align="right" class="box-footer">
						 <button class="btn btn-success" name="submit" type="submit"> Update</button>
						 </div>
				</form>
				
				<div class="col-md-12 table-responsive" style="padding-top: 0px; margin-top: 5px; font-size: 15px; background:#FFF;">
        <table class="table table-responsive" style="font-size: 15px;border-top: 1px solid #333;">
         
          <tr  style="border-top: 1px solid #333;">  
          @php
          $key = 1;
          @endphp
          <th>S/N</th>
          <th>Level</th>
          <th>Gross</th>
          <th>Tax</th>
          </tr> 
          @if($allowance != '')
           @foreach($allowance as $list)  
           <tr>
           <td>{{$key++}}</td>
           <td>{{$list->grade}}</td>
           <td>{{number_format($list->gross,2)}}</td>
           <td>{{number_format($list->tax,2)}}</td>
           </tr>
           @endforeach
            @else  
            <tr>
           <td colspan ="3">
               <div class="text-center text-danger">No record available<</div>
           </td>
          
           </tr>
            @endif            
        </table>
        <div class="hidden-print "></div>
      </div>
		</div>
        </div>
    </div><!-- /.row -->
  
  
  
  
 
  
 
  
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript">

  $(document).ready(function(){

  $("#grade").on('change',function(e){
  	 e.preventDefault();
    var id = $(this).val();
  //alert(id);
    $token = $("input[name='_token']").val();
   $.ajax({
    headers: {'X-CSRF-TOKEN': $token},
    url: murl +'/quarterly-allowance/get-data',

    type: "post",
    data: {'grade':id},
    success: function(data){
    //location.reload(true);
    console.log(data);
    $('#gross').val(data.gross);
    $('#tax').val(data.tax);
    }
  });

});
});

   

</script>



@endsection
