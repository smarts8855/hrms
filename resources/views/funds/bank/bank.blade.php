@extends('layouts.layout')
@section('pageTitle')
  Add New Bank
  
@endsection

@section('content')
  <form method="post" action="{{ url('/bank/store') }}">
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
                                  
                         <h4 class="" style="text-transform:uppercase">Add New Bank</h4>

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

								  <div class="col-md-3">
										<div class="form-group">
										  <label for="bankName">Bank's Name</label>
										  <select name="bankName" id="bankName" class="form-control">
													<option>Select Bank</option>
													@foreach($bank_name as $bank_name)
														<option value="{{$bank_name->bankID}}">{{$bank_name->bank}}</option>
													@endforeach
										  </select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
										  <label for="bankCode">Bank's Code</label>
										  <input type="Text" name="bankCode" placeholder="0" id="bankCode" class="form-control" value="{{old('bankCode')}}">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
										  <label for="sortCode">Sort Code</label>
										  <input type="Text" name="sortCode" placeholder="0" id="sortCode" class="form-control" alue="{{old('sortCode')}}">
										</div>
									</div>
								</div>
					
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="sortcode"></label>
											<div align="right">
											 @permission('can-edit')
												<button class="btn btn-success" type="submit">Update</button>
											 @endpermission
											</div>
										</div>
									</div>
								</div>
				</div>
        </div><!-- /.col -->
    </div><!-- /.row -->
  </form>

<div class="panel-body" style="background:#fff;">
  <table class="table table-responsive table-bordered">
              <thead>
                    <tr>  
                        <th>Court</th>
                        <th>Bank</th>
                        <th>Bank Code</th>
                        <th>Sort Code</th> 
                    </tr>
              </thead>
              <tbody>
              @foreach ($allCode as $list)
              <tr>
             <td>{{$list->court_name}}</td>
             <td>{{$list->bank}}</td>
             <td>{{$list->bank_code}}</td>
             <td>{{$list->sort_code}}</td>
             </tr>
            @endforeach
              </tbody>
        </table>

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