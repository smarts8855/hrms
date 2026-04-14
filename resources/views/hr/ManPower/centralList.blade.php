@extends('layouts.layout')
@section('pageTitle')
	 MANPOWER
@endsection

@section('content')
<div class="box box-default" style="border-top: none;">
	<form action="" method="post">
	{{ csrf_field() }}
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
          <span class="pull-right" style="margin-right: 30px;">
          	 <div style="float: left;">
          	 	<div class="wrap">
    				   <div class="search"> 
               <button type="submit" class="btn btn-default" style="padding: 6px; float: right; border-radius: 0px;">
                <i class="fa fa-search"></i>
              </button>
				       <input type="text" id="autocomplete_central" name="q" class="form-control" placeholder="Search By Name or File No." style="padding: 5px; width: 300px;"><!--searchTerm-->
				       <input type="hidden" id="fileNo"  name="fileNo">
                <input type="hidden" id="monthDay"  name="monthDay" value="">
				      </div>
				      </div>
          	 </div>
          </span>
        </form>
        <form method="post" action="{{url('/manpower/view/central')}}">
          {{ csrf_field() }}
            <!--<span class="hidden-print">
                 <span class="pull-right" style="margin-left: 5px;">
                  <div style="float: left; width: 100%; margin-top: -20px;">
                     <button type="submit" class=" btn btn-default" style="padding: 6px; border-radius: 0px;">Staff Due for Increment Today</button>
                  </div>
                  <input type="hidden" id="monthDay"  name="monthDay" value="{{date('Y-m-d')}}">
                  <input type="hidden" id="fileNo"  name="fileNo" value="">
                  <input type="hidden" id="filterDivision"  name="filterDivision" value="">
                </span>
                <a href="{{url('/map-power/view/central')}}" title="Refresh" class="pull-right">
                  <i class="fa fa-refresh"></i> Refresh
                </a>
            </span>-->
        </form>
    </div>

    <div style="margin: 10px 20px;">
    	<div align="center">
        <h3><b>{{strtoupper('JIPPIS')}}</b></h3>
        <big><b>{{strtoupper($headFile . ' AS AT ' . date('l jS \of F Y'))}}</b></big>
      </div>
    	<span class="pull-right" style="margin-right: 30px;">Printed On: {{date('D M, Y')}} &nbsp; | &nbsp; Time: {{date('h:i:s A')}}</span>
    
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

	<div class="box-body">
		<div class="row">
			{{ csrf_field() }}

			<div class="col-md-12">
				<table class="table table-striped table-condensed table-bordered input-sm">
					<thead>
          <tr class="input-sm">
  						<th>S/N</th>
  						<th width="250" class="">FULL NAME</th>
  						<th>DATE OF BIRTH</th>
  						<th>SEX</th>
              <th>MARITAL STATUS</th>
              <th>L.G.A OF ORIGIN</th>
              <th>STATE OF ORIGIN</th>
              <th>DATE OF FIRST <BR /> APPOINTMENT</th>
              <th>RANK</th> 
              <th>DATE OF PRESENT <BR /> APPOINTMENT</th>
              <th>DIVISION</th>
              <th>FILE NO</th>
              <th>QUALIFICATION</th>
              <th class="hidden-print"></th>
              </tr>
					</thead>
					<tbody>
						@php $key = 1; @endphp
            @foreach($getCentralList as $list)
  						<tr>
                  <td>{{($getCentralList->currentpage()-1) * $getCentralList->perpage() + $key++}}</td> 
                  <td>{{strtoupper($list->surname .' '. $list->first_name .' '. $list->othernames)}}</td> 
                  <td width="90">{{$list->dob}}</td>
                  <td>
                    @php 
                        if(strtoupper(($list->gender == "MALE")))
                        {
                          $sex = 'M';
                        }else if(strtoupper(($list->gender == "FEMALE")))
                        {
                          $sex = 'F';
                        }else
                        {
                          $sex = '';
                        }
                    @endphp
                    {{$sex}}
                  </td> 
                  <td>{{$list->maritalstatus}}</td>
                  <td></td> 
                  <td></td>
                  <td>{{$list->appointment_date}}</td>  
                  <td>{{$list->section .' '. 'GL'.$list->grade .'|'.'S'.$list->step}}</td> 
                  <td>{{$list->firstarrival_date}}</td> 
                  <td>{{strtoupper($list->division)}}</td> 
                  <td>{{'JIPPIS/P/'.$list->fileNo}}</td> 
                  <td>@php
                      $getEducation = $list->fileNo;
                      $getQualification = DB::table('tbleducations')
                      ->where('fileNo', $getEducation)
                      ->get();
                      @endphp
                      @foreach($getQualification as $Qlist)
                        {{$Qlist->degreequalification}},
                      @endforeach 
                  </td> 
                    @include('layouts._alertIncrement')
                   <!--$this-><td class="hidden-print"></td> was include _alertIncrement-->  
              </tr>
            @endforeach
					</tbody>
				</table>

        <div align="right">
          Showing {{($getCentralList->currentpage()-1)*$getCentralList->perpage()+1}}
                  to {{$getCentralList->currentpage()*$getCentralList->perpage()}}
                  of  {{$getCentralList->total()}} entries
        </div>

				<div class="hidden-print">{{ $getCentralList->links() }}</div>
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
      $("#autocomplete_central").autocomplete({
        serviceUrl: murl + '/staff/search/json',
        minLength: 10,
        onSelect: function (suggestion) {
            $('#fileNo').val(suggestion.data);
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
       $('#fileNo').val($.datepicker.formatDate('yy-m-d', theDate));
    },
  });

</script>
@stop

@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@stop







