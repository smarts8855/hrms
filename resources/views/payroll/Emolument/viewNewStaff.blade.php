@extends('layouts.layout')
@section('pageTitle')
	List Of All New Staff
@endsection

@section('content')
<div class="box box-default" style="border-top: none;">
	<form action="{{url('/variation/view-record/filter')}}" method="post">
	{{ csrf_field() }}
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
          <span class="pull-right" style="margin-right: 20px; margin-left: 30px;">
             <div style="float: left;">
              <div class="wrap">
               <div class="search"> 
               <button type="submit" class="btn btn-default" style="padding: 6px; float: right; border-radius: 0px;">
                <i class="fa fa-search"></i>
              </button>
               <input type="text" id="autocomplete" name="q" class="form-control" placeholder="Search By Name/Order/File No." style="padding: 5px; width: 250px;"><!--searchTerm-->
               <input type="hidden" id="fileNo"  name="fileNo">
              </div>
              </div>
             </div>
          </span>
          <a href="{{url('/staff/variation/view/')}}" title="Refresh" class="pull-right">
            <i class="fa fa-refresh"></i> Refresh
          </a>
        </div>
    </form>

    <div style="margin: 10px 20px;">
    	<big><b>{{strtoupper('list of all new staff in ' . Session::get('division') )}}</b></big>
    	<span class="pull-right" style="margin-right: 30px;">Printed On: {{date('D M, Y')}}.</span>
    
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
				<table class="table table-striped table-condensed table-bordered input-sm">
					<thead>
						<th>S/N</th>
						<th>File No.</th>
						<th>Surname</th>
            <th>Other Names</th>
            <th>Division</th>
            <th>Grade Level</th>
					</thead>
					<tbody>
						@php $key = 1; @endphp
						@foreach ($newStaff as $user)
					     <tr>
					        	<td>{{ ($newStaff->currentpage()-1) * $newStaff->perpage() + $key ++}}</td>
					       		<td>{{'JIPPIS/P/' . $user->fileNo }}</td>
					       		<td>{{ $user->surname }}</td>
                    <td>{{ $user->first_name.' '.$user->othernames }}</td>
                     <td>{{ $user->division }}</td>
                    <th>{{'GL'.$user->grade .'|'.'S'.$user->step}}</th>
					     </tr>
					    @endforeach
					</tbody>
				</table>

        <a href="{{url('/personal-emolument/create')}}" class="btn btn-info btn-sm hidden-print">Raise Emolument Form for these staff(s)</a>
         <div align="right">
          Showing {{($newStaff->currentpage()-1) * $newStaff->perpage() + 1}}
                  to {{$newStaff->currentpage() * $newStaff->perpage()}}
                  of  {{$newStaff->total()}} entries
        </div>
        <div class="hidden-print">{{ $newStaff->links() }}</div>
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</form>
</div>

@stop

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
      $('#searchName').attr("disabled", true);
      $("#autocomplete").autocomplete({
        serviceUrl: murl + '/variation/staff/search/json',
        minLength: 2,
        onSelect: function (suggestion) {
            $('#fileNo').val(suggestion.data);
            $('#searchName').attr("disabled", false);
            showAll();
        }
      });
  });

  $("#searchDate").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd MM, yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('yy-mm-d', theDate);
       //$('#fileNo').val($.datepicker.formatDate('yy-m-d', theDate));
    },
  });

</script>
@stop

@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@stop


