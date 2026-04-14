@extends('layouts.layout')
@section('pageTitle')
 Edit BAT Number
  
@endsection

@section('content')
  <form method="post" action="{{ url('/bat/update') }}">
{{ csrf_field() }}
  <div class="box-body" style="background:#fff;">
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

            </div>
			
            
				<div class="col-md-12" style="background:#fff;"><!--2nd col-->
                                  
                         <h4 class="" style="text-transform:uppercase"> Edit BAT Number</h4>

								
@if ($CourtInfo->courtstatus==1)
        <div class="row">
                                 <div class="col-md-3">
								<div class="form-group">
								<label for="bankName">Select Court </label>
								<select name="court" id="court" class="form-control" style="font-size: 13px;">

								<option value="">Select Court</option>
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

								  <div class="col-md-3">
									<div class="form-group">
									<input type="hidden" name="id" value="{{$batSingle->Id}}">
									  <label for="bankName">Year</label>
									<select name="year" id="year" class="form-control">
									<option>Select Year</option>
									@for($i=2019; $i <=2040; $i++)
									<option value="{{$i}}" @if($batSingle->year == $i) selected @endif>{{$i}}</option>
									@endfor
									</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
										 <label for="bankName">Month</label>
									<select name="month" id="section" class="form-control">
									<option value="">Select Month </option>
									<option value="JANUARY"  @if($batSingle->month == "JANUARY") selected @endif>January</option>
									<option value="FEBRUARY" @if($batSingle->month == "FEBRUARY") selected @endif>February</option>
									<option value="MARCH" @if($batSingle->month == "MARCH") selected @endif>March</option>
									<option value="APRIL" @if($batSingle->month == "APRIL") selected @endif>April</option>
									<option value="MAY" @if($batSingle->month == "MAY") selected @endif>May</option>
									<option value="JUNE" @if($batSingle->month == "JUNE") selected @endif>June</option>
									<option value="JULY" @if($batSingle->month == "JULY") selected @endif>July</option>
									<option value="AUGUST" @if($batSingle->month == "AUGUST") selected @endif>August</option>
									<option value="SEPTEMBER" @if($batSingle->month == "SEPTEMBER") selected @endif>September</option>
									<option value="OCTOBER" @if($batSingle->month == "OCTOBER") selected @endif>October</option>
									<option value="NOVEMBER" @if($batSingle->month == "NOVEMBER") selected @endif>November</option>
									<option value="DECEMBER" @if($batSingle->month == "DECEMBER") selected @endif>December</option>
									</select>
									</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
										  <label for="sortCode">BAT Number</label>
										  <input type="Text" name="batNo" placeholder="0" id="code" class="form-control" value="{{$batSingle->batNo}}">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="sortcode"></label>
											<div align="right">
											 
												<button class="btn btn-success" type="submit">Update</button>
											
											</div>
										</div>
									</div>
								</div>
					
								<div class="row">
									
								</div>
				</div>
				
				
				<div >
<div>
  <table class="table table-responsive table-bordered" style="margin-top:60px;">
              <thead>
                    <tr>  
                        <th>Year</th>
                        <th>Month</th>
                        <th>BAT Number</th>
                       <th>Edit</th>
                    </tr>
              </thead>
              <tbody>
              @foreach ($bat as $list)
              <tr>
             <td>{{$list->year}}</td>
             <td>{{$list->month}}</td>
             <td>{{$list->batNo}}</td>
             <td><a href="{{url("/bat/edit/$list->Id")}}" class="btn btn-success">Edit</a></td>
             </tr>
            @endforeach
              </tbody>
        </table>

   </div>
   </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
    
    
  </form>

<div class="panel-body" style="background:#fff;">

   </div>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
  	(function () {
			$('#bankName').change( function(){
				$.ajax({
					url: murl +'/bank/findBank',
					type: "post",
					data: {'bankName': $('#bankName').val(), '_token': $('input[name=_token]').val()},
					success: function(data){
						$('#bankCode').val(data.bank_code);
						$('#sortCode').val(data.sort_code);
					}
				})	
	});}) ();
	</script>

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