@extends('layouts.layout')
@section('pageTitle')
	 PERSONAL EMOLUMENT RECORD HISTORY
@endsection

@section('content')
<div class="box box-default" style="border-top: none;">
	<form action="{{url('/personal-emolument/view-record/filter')}}" method="post">
	{{ csrf_field() }}
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
          <span class="pull-right" style="margin-right: 30px;">
          	 <div style="float: left;">
          	 	<div class="wrap">
    				   <div class="search"> &nbsp;
    				   <a href="{{url('/staff/personal-emolument/view/')}}" title="Refresh"><i class="fa fa-refresh"></i> Refresh</a>
    				   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				      <input type="text" id="autocomplete" name="q" class="searchTerm" placeholder="Search By Name or File No.">
				      <input type="hidden" id="fileNo"  name="fileNo">
				      <button type="submit" class="searchButton">
				        <i class="fa fa-search"></i>
				     </button>
				   </div>
				</div>
          	 </div>
          </span>
        </div>
    </form>

    <div style="margin: 10px 20px;">
    	<big><b>{{strtoupper('PERSONAL EMOLUMENT RECORD- All Staff Records ')}}</b></big>
    	<span class="pull-right" style="margin-right: 30px;">Printed On: {{date('D M, Y')}}.</span>
    

    @if(session('err'))
		<div class="alert alert-warning alert-dismissible hidden-print" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		</button>
		<strong>Error!</strong> 
		{{ session('err') }} 
		</div>                        
	@endif

	</div>

	<form method="post" action="{{ url('staff/store') }}">
	<div class="box-body">
		<div class="row">
			{{ csrf_field() }}

			<div class="col-md-12">
				<table class="table table-striped table-condensed table-bordered input-sm">
					<thead>
						<th>S/N</th>
            <th>last Update</th>
						<th>File No.</th>
						<th>Full Name</th>
						<th>Rank/Grade</th>
						<th>Bank</th>
            <th>Division</th>
            <th>A/No.</th>
            <th>Section</th>
            <th>1st App. Date</th>
            <th>Incrt. Date</th>
            <th class="hidden-print"></th>
					</thead>
					<tbody>
						@php $key = 1; @endphp
						@foreach ($users as $user)
					        <tr>
					        	<td>{{ ($users->currentpage()-1) * $users->perpage() + $key ++}}</td>
                    <td>{{ $user->updated_at}}</td>
					       		<td>{{ $user->fileNo }}</td>
					       		<td>{{ $user->surname.' '.$user->first_name.' '.$user->othernames }}</td>
					       		<td>{{ $user->grade }}</td>
					       		<td>{{ $user->bank }}</td>
                    <td>{{ $user->division }}</td>
                    <td>{{ $user->AccNo }}</td>
                    <td>{{ $user->section }}</td>
                    <td>{{ $user->appointment_date }}</td>
                    <th>{{ $user->incremental_date }}</th>
                    <td class="hidden-print">
                      <a href="{{url('/staff/personal-emolument/report/'.$user->fileNo)}}" class="hidden-print"><i class="fa fa-print"></i></a>
                    </td>
					        </tr>
					    @endforeach
					</tbody>
				</table>
        <div align="right">
            Showing {{($users->currentpage()-1)*$users->perpage()+1}}
                  to {{$users->currentpage()*$users->perpage()}}
                  of  {{$users->total()}} entries
          </div>
				<div class="hidden-print">{{ $users->links() }}</div>
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</form>
</div>
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
 	<script type="text/javascript">
  $(function() {
      $('#searchName').attr("disabled", true);
      $("#autocomplete").autocomplete({
        serviceUrl: murl + '/staff/search/json',
        minLength: 2,
        onSelect: function (suggestion) {
            $('#fileNo').val(suggestion.data);
            $('#searchName').attr("disabled", false);
            showAll();
        }
      });
  });
</script>
@endsection

@section('stypes')
	<style type="text/css">
		@import url(https://fonts.googleapis.com/css?family=Open+Sans);

body{
  background: #f2f2f2;
  font-family: 'Open Sans', sans-serif;
}

.search {
  width: 100%;
  position: relative; 
}

.searchTerm {
  float: left;
  width: 100%;
  border: 3px solid #00B4CC;
  padding: 5px;
  height: 20px;
  border-radius: 5px;
  outline: none;
  color: #9DBFAF; 
}

.searchTerm:focus{
  color: #00B4CC;
}

.searchButton {
  position: absolute;  
  right: -50px;
  width: 40px;
  height: 36px;
  border: 1px solid #00B4CC;
  background: #00B4CC;
  text-align: center;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  font-size: 20px;
}

/*Resize the wrap to see the search bar change!*/
.wrap{
  width: 30%; 
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
@stop
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
@endsection
@section('styles')
<style> 
  .textbox { 
    border: 1px;
    background-color: #33AD0A; 
    outline:0; 
    height:25px; 
    width: 275px; 
  } 
  $('.autocomplete-suggestions').css({
    color: '#0f3'
  });

  .autocomplete-suggestions{
    color:#fff;
    font-size: 13px;
  }
</style> 
@endsection