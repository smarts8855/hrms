@extends('layouts.layout')
@section('pageTitle')
	VARIATION REPORT
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
    	<big><b>{{strtoupper('VARIATION REPORT- All Staff Records ')}}</b></big>
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
            <th>Date</th>
            <th>Order No</th>
						<th>File No.</th>
						<th>Full Name</th>
						<th>Rank</th>
						<th>New Salary</th>
            <th>Amount of V.</th>
            <th>Reason for V.</th>
            <th>Effective</th>
            <th>Remark</th>
            <th class="hidden-print"></th>
					</thead>
					<tbody>
						@php $key = 1; @endphp
						@foreach ($users as $user)
					        <tr>
					        	<td>{{ ($users->currentpage()-1) * $users->perpage() + $key ++}}</td>
                    <td>{{ $user->v_created_at}}</td>
                    <td>{{$user->variationorderno}}</td>
					       		<td>{{'JIPPIS/P/' . $user->fileNo }}</td>
					       		<td>{{ $user->surname.' '.$user->first_name.' '.$user->othernames }}</td>
					       		<td>{{$user->rank}}</td>
					       		<td>{{ $user->newsalary }}</td>
                    <td>{{ $user->amount }}</td>
                    <td>{{ $user->reason }}</td>
                    <td>{{ $user->effectivedate }}</td>
                    <th>{{'GL'.$user->grade .'|'.'S'.$user->step}}</th>
                    <td class="hidden-print">
                      <a href="{{url('/staff/variation/report/'.$user->fileNo.'/'.$user->id)}}" class="hidden-print">
                        <i class="fa fa-print fa-2x"></i>
                      </a>
                    </td>
					        </tr>
					    @endforeach
					</tbody>
				</table>
         <div align="right">
          Showing {{($users->currentpage()-1) * $users->perpage() + 1}}
                  to {{$users->currentpage() * $users->perpage()}}
                  of  {{$users->total()}} entries
        </div>
        <div class="hidden-print">{{ $users->links() }}</div>
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


