@extends('layouts.layout')
@section('pageTitle')
	STAFF REPORT
@endsection

@section('content')
<div class="box box-default" style="border-top: none;">
	<form action="{{url('/staff-report/view')}}" method="post">
	{{ csrf_field() }}
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle')</h3>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href="{{url('/staff-report/view')}}" title="Refresh"><i class="fa fa-refresh"></i> Refresh</a>
      
          <span class="pull-right" style="margin-right: 40px;">
          	 <div style="float: left;">
          	 	<div class="wrap">
    				   <div class="search">
    				      <input type="text" id="autocomplete" name="q" class="form-control" placeholder="Search By Name or File No." style="padding: 5px;">
    				      <input type="hidden" id="fileNo"  name="fileNo">
    				      <button type="submit" class="btn btn-default" style="margin-right: -27px; margin-top: -34px; padding: 6px; float: right; border-radius: 0px;">
    				        <i class="fa fa-search"></i>
    				     </button>
    				   </div>
    				  </div>
          	 </div>
          </span>

          <span class="pull-right" style="margin-right: 0px;">
          <div style="float: left; width: 100%;">
                <select name="filterDivision" id="filterDivision" class="form-control hidden-print">
                  <option value="" selected="selected">Select Division</option>
                    <option value=""></option>
                    @foreach($getDivision as $getDiv)
                      <option  value="{{$getDiv->divisionID}}">{{$getDiv->division}}</option>
                    @endforeach
                </select>
              </div>
          </span>
        </div>
    </form>

    <div style="margin: 10px 20px;">
    	<div align="center"><h4><big><b>{{strtoupper('NATIONAL INDUSTRIAL COURT')}}</b></big></h4></div>
      <br />
      <big><b>{{strtoupper('OPEN REGISTRY - All Staff Records ' . $filterDivision)}}</b></big>
    	<span class="pull-right" style="margin-right: 30px;">AS AT: {{date('jS l F, Y')}}.</span>
    
   <br />
    @if(session('err'))
      <div class="col-sm-12 alert alert-warning alert-dismissible hidden-print" role="alert">
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
				<table class="table table-striped table-condensed table-bordered">
					<thead>
						<th>S/N</th>
            <th>Date</th>
						<th>File Number</th>
						<th>Surname</th>
						<th>First Name</th>
						<th>Other Names</th>
            <th>Grade</th>
            <th>Step</th>
            <th>Division</th>
					</thead>
					<tbody>
						@php $key = 1; @endphp
						@foreach ($users as $user)
					        <tr class="input-sm">
					        	<td>{{ ($users->currentpage()-1) * $users->perpage() + $key ++}}</td>
                    <td>{{ $user->date}}</td>
					       		<td>{{ strtoupper('JIPPIS/P/') . $user->fileNo }}</td>
					       		<td>{{ $user->surname }}</td>
					       		<td>{{ $user->first_name }}</td>
					       		<td>{{ $user->othernames }}</td>
                    <td>{{ $user->grade }}</td>
                    <td>{{ $user->step }}</td>
                    <td>{{ $user->division }}</td>
					        </tr>
					    @endforeach
					</tbody>
				</table>
          <div align="right" class="hidden-print">
            Showing {{($users->currentpage()-1)*$users->perpage()+1}}
                  to {{$users->currentpage()*$users->perpage()}}
                  of  {{$users->total()}} entries
          </div>
          {{ $users->links() }}
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
        minLength: 10,
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