@extends('layouts.layout')
@section('pageTitle')
	{{strtoupper('PENSION REPORT')}}
@endsection

@section('content')
<div class="box box-default" style="border-top: none;">


    <div style="margin: 10px 20px;">
    	<big><b>{{strtoupper(' ')}}</b></big>
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

	
	<div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div>
          <div>
            <h4>PENSION REPORT - 
              <b>{{$staff->surname .' '. $staff->first_name .' '. $staff->othernames}} FOR {{$getYear}}</b>
            </h4>
          </div>

          <table class="table table-striped table-condensed table-bordered">
              <tr>
                <td width="200"><strong>MONTH</strong></td>
                <td width="90" align="center"><strong>JAN</strong></td>
                <td width="90" align="center"><strong>FEB</strong></td>
                <td width="90" align="center"><strong>MAR</strong></td>
                <td width="90" align="center"><strong>APR</strong></td>
                <td width="90" align="center"><strong>MAY</strong></td>
                <td width="90" align="center"><strong>JUN</strong></td>
                <td width="90" align="center"><strong>JUL</strong></td>
                <td width="90" align="center"><strong>AUG</strong></td>
                <td width="90" align="center"><strong>SEP</strong></td>
                <td width="90" align="center"><strong>OCT</strong></td>
                <td width="90" align="center"><strong>NOV</strong></td>
                <td width="90" align="center"><strong>DEC</strong></td>
                <td>Total</td>
              </tr>
              <tr>
                <td>Employee Pension</td>
                <td align="center">{{number_format($result['JANUARY']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['FEBRUARY']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center"> 
                  {{number_format($result['MARCH']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center"> 
                  {{number_format($result['APRIL']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center"> 
                  {{number_format($result['MAY']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['JUNE']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['JULY']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['AUGUST']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['SEPTEMBER']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['OCTOBER']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['NOVEMBER']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['DECEMBER']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                <?php $sum=0;
                  $sum=$result['JANUARY']['employee_pension']+$result['FEBRUARY']['employee_pension']+$result['MARCH']['employee_pension']+$result['APRIL']['employee_pension']+$result['MAY']['employee_pension']+$result['JUNE']['employee_pension']+$result['JULY']['employee_pension']+$result['AUGUST']['employee_pension']+$result['SEPTEMBER']['employee_pension']+$result['OCTOBER']['employee_pension']+$result['NOVEMBER']['employee_pension']+$result['DECEMBER']['employee_pension'];?>
                  {{number_format($sum, 2, '.', ',')}}
                  </td>
              </tr>
              <tr>
                <td>Employer Pension</td>
                <td align="center">{{number_format($result['JANUARY']['employee_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['FEBRUARY']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center"> 
                  {{number_format($result['MARCH']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center"> 
                  {{number_format($result['APRIL']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center"> 
                  {{number_format($result['MAY']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['JUNE']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['JULY']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['AUGUST']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['SEPTEMBER']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['OCTOBER']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['NOVEMBER']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                  {{number_format($result['DECEMBER']['employer_pension'], 2, '.', ',')}}
                </td>
                <td align="center">
                <?php $sum=0;
                  $sum=$result['JANUARY']['employer_pension']+$result['FEBRUARY']['employer_pension']+$result['MARCH']['employer_pension']+$result['APRIL']['employer_pension']+$result['MAY']['employer_pension']+$result['JUNE']['employer_pension']+$result['JULY']['employer_pension']+$result['AUGUST']['employer_pension']+$result['SEPTEMBER']['employer_pension']+$result['OCTOBER']['employer_pension']+$result['NOVEMBER']['employer_pension']+$result['DECEMBER']['employer_pension'];?>
                  {{number_format($sum, 2, '.', ',')}}
                  </td>
              </tr>

              <tr>
                <th>Total</th>
                <th align="center">{{number_format($result['JANUARY']['total'], 2, '.', ',')}}
                </th>
                <th align="center">
                  {{number_format($result['FEBRUARY']['total'], 2, '.', ',')}}
                </th>
                <th align="center"> 
                  {{number_format($result['MARCH']['total'], 2, '.', ',')}}
                </th>
                <th align="center"> 
                  {{number_format($result['APRIL']['total'], 2, '.', ',')}}
                </th>
                <th align="center"> 
                  {{number_format($result['MAY']['total'], 2, '.', ',')}}
                </th>
                <th align="center">
                  {{number_format($result['JUNE']['total'], 2, '.', ',')}}
                </th>
                <th align="center">
                  {{number_format($result['JULY']['total'], 2, '.', ',')}}
                </th>
                <th align="center">
                  {{number_format($result['AUGUST']['total'], 2, '.', ',')}}
                </th>
                <th align="center">
                  {{number_format($result['SEPTEMBER']['total'], 2, '.', ',')}}
                </th>
                <th align="center">
                  {{number_format($result['OCTOBER']['total'], 2, '.', ',')}}
                </th>
                <th align="center">
                  {{number_format($result['NOVEMBER']['total'], 2, '.', ',')}}
                </th>
                <th align="center">
                  {{number_format($result['DECEMBER']['total'], 2, '.', ',')}}
                </th>
                <th align="center">
                <?php $sum=0;
                  $sum=$result['JANUARY']['total']+$result['FEBRUARY']['total']+$result['MARCH']['total']+$result['APRIL']['total']+$result['MAY']['total']+$result['JUNE']['total']+$result['JULY']['total']+$result['AUGUST']['total']+$result['SEPTEMBER']['total']+$result['OCTOBER']['total']+$result['NOVEMBER']['total']+$result['DECEMBER']['total'];?>
                  {{number_format($sum, 2, '.', ',')}}
                  </th>

              </tr>
          
              </table>
          </div><!-- /.row -->

      <div align="left" class="form-group hidden-print">
        <label for="month">&nbsp;</label><br />
        <a href="{{url('/pension/report')}}" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
      </div>
  </div>
  </div>
		


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
        serviceUrl: murl + '/data/searchUser',
        minLength: 2,
        onSelect: function (suggestion) {
            $('#fileNo').val(suggestion.data);
            $('#searchName').attr("disabled", false);
            //showAll();
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
.table tr th
{
  text-align: center;
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