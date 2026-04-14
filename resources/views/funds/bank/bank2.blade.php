@extends('layouts.layout')
@section('pageTitle')
  Add New Bank
  
@endsection

@section('content')
  <form method="post" action="{{ url('/bank/store') }}">

  <div class="box-body">
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
			{{ csrf_field() }}
            
				<div class="col-md-12"><!--2nd col-->
								<div class="row">
								  <div class="col-md-4">
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
									<div class="col-md-4">
										<div class="form-group">
										  <label for="bankCode">Bank's Code</label>
										  <input type="Text" name="bankCode" placeholder="0" id="bankCode" class="form-control">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="sortCode">Sort Code</label>
										  <input type="Text" name="sortCode" placeholder="0" id="sortCode" class="form-control">
										</div>
									</div>
								</div>
					
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="sortcode"></label>
											<div align="right">
											 @permission('can-edit')
												<button class="btn btn-success" type="submit"> Update</button>
											 @endpermission
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
@endsection