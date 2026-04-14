@extends('layouts.layout')
@section('pageTitle')
STAFF INFORMATION
@endsection
@section('content')

	<div class="box-body hidden-print ">
	<div class="box box-default">
    	<div>
    	<div class="box-body">
    	<div >
    	<h5> @yield('pageTitle') </h5></div>
    	@if($showError)
		<div class="row">
			<div class="col-sm-12">
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

				@if(session('error'))
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
						</button>
						<strong>Input Error !</strong>
						{{ session('error') }}
					</div>
				@endif
			</div>
		</div><!-- /row -->
	@endif
	</div><!-- /div -->
	</div>
	</div>
	</div>
	
	<div class="box-body">
	<div class="box box-default">
    	<div class="">
    	<div class="box-body">
    	
		<br />
		<div> <h4 class="text-success">Enter Staff Details </h4></div>
		<hr/>
		<form method="post" action="{{ route('processStaffInfo') }}">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="file">Staff File No.</label>
						<input type="text" name="staffFileNo" class="form-control" value="{{ old('staffFileNo') }}" placeholder ="Required-Staff ID" required />
						@if ($errors->has('staffFileNo'))
						    <div class="text-danger">{{ $errors->first('staffFileNo') }}</div>
						@endif
					</div><br/>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="name">Staff Name</label>
						<input type="text" name="staffName" class="form-control" value="{{ old('staffName') }}" placeholder ="Required-Staff Name" required/>
						@if ($errors->has('staffName'))
						    <div class="text-danger">{{ $errors->first('staffName') }}</div>
						@endif
					</div><br />
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="email">Staff Email</label>
						<input type="email" name="staffEmail" class="form-control" value="{{ old('staffEmail') }}" placeholder ="Optional-Staff Email"/>
						@if ($errors->has('staffEmail'))
						    <div class="text-danger">{{ $errors->first('staffEmail') }}</div>
						@endif
					</div><br />
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="bank">Bank Name</label>
						<select name="bankName" class="form-control" required>
							<option value="" selected>Select</option>
							@forelse($bank as $bkList)
								<option value="{{ $bkList->bankID }}" {{ (old("bankName") == $bkList->bankID ? "selected":"") }}>{{ $bkList->bank }}</option>
							@empty
								<option value="" selected>No Bank Available</option>
							@endforelse
						</select>
						@if ($errors->has('bankName'))
						    <div class="text-danger">{{ $errors->first('bankName') }}</div>
						@endif
					</div><br />
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="account">Account Number</label>
						<input type="text" name="accountNumber" size="11" class="form-control" value="{{ old('accountNumber') }}" placeholder ="Required-Account Number" required/>
						@if ($errors->has('accountNumber'))
						    <div class="text-danger">{{ $errors->first('accountNumber') }}</div>
						@endif
					</div><br />
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="sort">Sort Code</label>
						<input type="text" name="sortCode" class="form-control" value="{{ old('sortCode') }}" placeholder ="Optional-Sort Code" />
						@if ($errors->has('sortCode'))
						    <div class="text-danger">{{ $errors->first('sortCode') }}</div>
						@endif
					</div><br />
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="department">Department</label>
						<select name="department" class="form-control" required>
							<option value="" selected>Select</option>
							@forelse($department as $deptList)
								<option value="{{ $deptList->id }}" {{ (old("department") == $deptList->id ? "selected":"") }}>{{ $deptList->department }}</option>
							@empty
								<option value="" selected>No Department Available</option>
							@endforelse
						</select>
						@if ($errors->has('department'))
						    <div class="text-danger">{{ $errors->first('department') }}</div>
						@endif
					</div><br />
				</div>
			</div><!--//row-->
			<hr />
			<div align="center" class="col-md-12">
				<button type="submit" name="processSubmit" class="btn btn-success">Submit</button>
			</div>
		</form>
		<br />
		<hr />
		<table class="table table-responsive table-hover table-stripped table-bordered table-condensed">
			<thead style="background: darkseagreen; color:white;">
				<tr class="text-uppercase text-center">
					<th>S/N</th>
					<th>File&nbsp;No.</th>
					<th>Full Name</th>
					<th>Bank</th>
					<th>Account&nbsp;No.</th>
					<th>Sort&nbsp;Code</th>
					<!--<th>Email</th>-->
					<th>Department</th>
					<th>Dept&nbsp;Head</th>
					<th>Username</th>
					<th>Created</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@php $key = 1; @endphp
			@forelse($allStaffDetails as $list)
				<tr>
					<td>{{ ($allStaffDetails->currentpage()-1) * $allStaffDetails->perpage() + $key ++ }}</td>
					<td>{{ $list->StaffFileNo }}</td>
					<td>{{ $list->full_name  }}</td>
					<td>{{ $list->bank 	}}</td>
					<td>{{ $list->account_no }}</td>
					<td>{{ $list->sort_code  }}</td>
					<!--<td>{{ $list->email 	 }}</td>-->
					<td>{{ $list->department }}</td>
					<td>{{ DB::table('users')->where('id', $list->head)->value('name') }}</td>
					<td>{{ $list->username   }}</td>
					<td>{{ $list->created_at }}</td>
					<td> <a href="#" title="Update Record" class="btn btn-sm btn-info" data-toggle="modal" data-target="#update{{$list->staffID}}">Update</a> </td>
				</tr>
				<!-- Modal Dialog for CONFIRMATION-->
					<div class="modal fade" id="update{{$list->staffID}}" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background: darkseagreen; color: white; border: 1px solid white;">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title"> Update Staff Details </h4>
								</div>
 								<form method="post" action="{{ route('processStaffInfoUpdate') }}">
								{{ csrf_field() }}
								<div class="modal-body col-sm-12" style="padding: 10px;">
									<input type="hidden" name="recordID" value="{{$list->staffID}}">
									<input type="hidden" name="userID" value="{{$list->userID}}">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="file">Staff File No.</label>
												<input type="text" name="staffFileNo" class="form-control" value="{{ $list->StaffFileNo }}" placeholder ="Required-Staff ID" />
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label for="name">Staff Name</label>
												<input type="text" name="staffName" class="form-control" value="{{ $list->full_name }}" placeholder ="Required-Staff Name" required/>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="email">Staff Email</label>
												<input type="email" name="staffEmail" class="form-control" value="{{ $list->email }}" placeholder ="Optional-Staff Email"/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="bank">Bank Name</label>
												<select name="bankName" class="form-control" required>
													<option value="{{ ($list->staffBankID ?  $list->staffBankID : 'selected') }}"> {{ ($list->bank ? $list->bank : 'Select') }}</option>
													@forelse($bank as $bkList)
														<option value="{{ $bkList->bankID }}" {{ (old("bankName") == $bkList->bankID ? "selected":"") }}>{{ $bkList->bank }}</option>
													@empty
														<option value="" selected>No Bank Available</option>
													@endforelse
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="account">Account Number</label>
												<input type="text" name="accountNumber" size="11" class="form-control" value="{{ $list->account_no }}" placeholder ="Required-Account Number" required/>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="sort">Sort Code</label>
												<input type="text" name="sortCode" class="form-control" value="{{ $list->sort_code }}" placeholder ="Optional-Sort Code" />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="department">Department</label>
												<select name="department" class="form-control" required>
													<option value="{{ ($list->staffDepartmentID?  $list->staffDepartmentID: '') }}">{{ ($list->department ? $list->department : 'Select') }}</option>
													@forelse($department as $deptList)
														<option value="{{ $deptList->id }}" {{ (old("department") == $deptList->id ? "selected":"") }}>{{ $deptList->department }}</option>
													@empty
														<option value="" selected>No Department Available</option>
													@endforelse
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="username">Staff Username (For Login)</label>
												<input type="text" name="username" class="form-control" value="{{ $list->username }}" placeholder ="Required-Username" required/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="sort">Staff Password (For Login)</label>
												<input type="password" name="password" class="form-control" value="DEFAULTPASSWORD" placeholder ="Optional-Password" />
											</div>
										</div>
									</div><!--//row-->
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">
										<i class="fa fa-crosshairs"></i> Cancel
									</button>
									<button type="submit" name="processUpdate" class="btn btn-success">
										<i class="fa fa-save"></i> Update
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			<!-- //DELETE Modal Dialog -->
			@empty
				<tr>
					<td colspan="12" class="text-danger text-center"> No record found yet !</td>
				</tr>
			@endforelse
			</tbody>
		</table>
		<br />
		<div align="right">
			Showing {{($allStaffDetails->currentpage()-1)*$allStaffDetails->perpage()+1}}
			to {{$allStaffDetails->currentpage()*$allStaffDetails->perpage()}}
			of  {{$allStaffDetails->total()}} entries
		</div>
		<div class="hidden-print">{{ $allStaffDetails->links() }}</div>
		<br />
	</div>
	</div>
	</div>
	</div>
@endsection

@section('scripts')
  	<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
 	<script type="text/javascript">

  	</script>
@endsection