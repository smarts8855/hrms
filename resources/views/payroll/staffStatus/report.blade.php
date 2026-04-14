@extends('layouts.layout')

@section('pageTitle')
 FEDERAL GOVERNMENT OF NIGERIA
	PAYMENT VOUCHER
@endsection

@section('content')
<div align="left" style="padding:0 2%;">
    <form method="post" action="{{ url('/approve') }}">
        <div class="row">
            <div class="col-md-12">
                <div align="center"><h2><strong> JIPPIS </strong></h2></div>
            </div>
        </div>
        <hr />
      <div align="center"><h5><strong>List of Staff transferred to {{$curDivision}} division</strong></h5></div>
      <br />
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
        <div class="col-md-12">
          
          <table class="table table-responsive table-bordered">
              <thead>
                    <tr>
                        <th><div align="center">APPROVE/REJECT STAFF</div></th>
                        <th><div align="center">FILE NO</div></th>
                        <th><div align="center">FULL NAME</div></th>
                        <th><div align="center">RANK</div></th>
                        <th><div align="center">DIVISION FROM</div></th>
                        <th><div align="center">DATE</div></th>
                    </tr>
              <thead>
              <tbody>
               @foreach($staffPending as $staff)
                    <tr>
                        <td class="text-center"><input type="checkbox" tabindex="1" value="{{$staff -> fileNo}}" name="action[]" /> &nbsp; </td>
                        <td class="text-center">{{$staff -> fileNo}}</td>
                        <td class="text-left">{{$staff -> surname .' '. $staff -> first_name .' '. $staff -> othernames}}</td>
                        <td class="text-center">{{$staff -> rank}}</td>
                        <td class="text-center">{{$staff -> division}}</td>
                        <td class="text-center">{{$staff -> date}}</td>
                    </tr>
             @endforeach
                    <tr>
                        <td colspan="6">
                        <div align="left">
                            {{'TOTAL PENDING: ' . $totalStaff}}
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                        <div align="left">
                            <input name="approve" id="approve" class="btn btn-success" type="submit" value="Approve Staff" />
                            <input name="reject" id="reject" class="btn btn-success" type="submit" value="Reject Staff" />
                        </div>
                        </td>
                    </tr>
              </tbody>
        </table>
    </div>
    </div>
    <br/>
    <br/>
    </form>
  </div><!--end main div=center-->
@endsection










