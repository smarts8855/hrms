@extends('layouts.layout')
@section('pageTitle')
Payroll Monthly Comparison
@endsection
@section('content')

  <div class="box-body" style="background:#FFF;">
<div style = "clear:both"></div>
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
        @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> 
          {{ session('message') }}
        </div>                        
        @endif

         @if(session('err'))
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> 
          {{ session('err') }}
        </div>                        
        @endif

      </div>
      </div>
    </div>

  <div class="box-body" style="background:#FFF;">
    <div class="row">

    <h4 class="col-md-6" style="text-transform:uppercase">Net Earning Comparison</h4>

      <form method="post" >
      {{ csrf_field() }}
      <div class="col-md-12">
        <div class="row">
          @if ($CourtInfo->courtstatus==1)
        <div class="col-md-6">
              <div class="form-group">
                <label>Select Court</label>
                <select name="court" id="court" class="form-control" style="font-size: 13px;">
                  <option value="">Select Court</option>
                  @foreach($courts as $court)
                  @if($court->id == session('anycourt'))
                  <option value="{{$court->id}}" selected="selected">{{$court->court_name}}</option>
                @else
                <option value="{{$court->id}}" @if(old('court') == $court->id) selected @endif>{{$court->court_name}}</option>
                @endif
                  @endforeach
                </select>
                 
              </div>
            </div>
          @else
            <input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
          @endif

            @if ($CourtInfo->divisionstatus==1)
          <div class="col-md-6">
              <div class="form-group">
                <label>Select Division</label>  
                <select name="division" id="division_" class="form-control" style="font-size: 13px;">
                <option value="">Select Division</option>
                 @foreach($courtDivisions as $divisions)
                 <option value="{{$divisions->divisionID}}" @if(old('division') == $divisions->divisionID) @endif>{{$divisions->division}}</option>
                 @endforeach
                </select>
               </div>
              </div>
            @else
              <input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">
            @endif
            
            <div class="col-md-3">
            <div class="form-group">
              <label >Period1 Year</label>
              <select name="year1" id="section" class="form-control">
                <option value="">Select Year</option>
                @for($i=2011;$i<=2025;$i++)
                 <option value="{{$i}}" @if(old('year1') == $i||$year1 == $i) selected @endif>{{$i}}</option>
                @endfor
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label> Period 1 Month  </label>
              <select name="month1" id="section" class="form-control">
                <option value="">Select Month </option>
                <option value="JANUARY" @if(old('month1') == 'JANUARY' ||$month1 == 'JANUARY') selected @endif>January</option>
                <option value="FEBRUARY" @if(old('month1') == 'FEBRUARY'||$month1 == 'FEBRUARY') selected @endif>February</option>
                <option value="MARCH" @if(old('month1') == 'MARCH'||$month1 == 'MARCH') selected @endif>March</option>
                <option value="APRIL" @if(old('month1') == 'APRIL'||$month1 == 'APRIL') selected @endif>April</option>
                <option value="MAY" @if(old('month1') == 'MAY'||$month1 == 'MAY') selected @endif>May</option>
                <option value="JUNE" @if(old('month1') == 'JUNE'||$month1 == 'JUNE') selected @endif>June</option>
                <option value="JULY" @if(old('month1') == 'JULY'||$month1 == 'JULY') selected @endif>July</option>
                <option value="AUGUST" @if(old('month1') == 'AUGUST'||$month1 == 'AUGUST') selected @endif>August</option>
                <option value="SEPTEMBER" @if(old('month1') == 'SEPTEMBER'||$month1 == 'SEPTEMBER') selected @endif>September</option>
                <option value="OCTOBER" @if(old('month1') == 'OCTOBER'||$month1 == 'OCTOBER') selected @endif>October</option>
                <option value="NOVEMBER" @if(old('month1') == 'NOVEMBER'||$month1 == 'NOVEMBER') selected @endif>November</option>
                <option value="DECEMBER" @if(old('month1') == 'DECEMBER'||$month1 == 'DECEMBER') selected @endif>December</option>
              </select>
            </div>
          </div>
           <div class="col-md-3">
            <div class="form-group">
              <label >Period 2 Year</label>
              <select name="year2" id="section" class="form-control">
                <option value="">Select Year</option>
                @for($i=2011;$i<=2025;$i++)
                 <option value="{{$i}}" @if(old('year2') == $i||$year2 == $i) selected @endif>{{$i}}</option>
                @endfor
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label> Period 2  Month </label>
              <select name="month2" id="section" class="form-control">
                <option value="">Select Month </option>
                <option value="JANUARY" @if(old('month2') == 'JANUARY' ||$month2 == 'JANUARY') selected @endif>January</option>
                <option value="FEBRUARY" @if(old('month2') == 'FEBRUARY'||$month2 == 'FEBRUARY') selected @endif>February</option>
                <option value="MARCH" @if(old('month2') == 'MARCH'||$month2 == 'MARCH') selected @endif>March</option>
                <option value="APRIL" @if(old('month2') == 'APRIL'||$month2 == 'APRIL') selected @endif>April</option>
                <option value="MAY" @if(old('month2') == 'MAY'||$month2 == 'MAY') selected @endif>May</option>
                <option value="JUNE" @if(old('month2') == 'JUNE'||$month2 == 'JUNE') selected @endif>June</option>
                <option value="JULY" @if(old('month2') == 'JULY'||$month2 == 'JULY') selected @endif>July</option>
                <option value="AUGUST" @if(old('month2') == 'AUGUST'||$month2 == 'AUGUST') selected @endif>August</option>
                <option value="SEPTEMBER" @if(old('month2') == 'SEPTEMBER'||$month2 == 'SEPTEMBER') selected @endif>September</option>
                <option value="OCTOBER" @if(old('month2') == 'OCTOBER'||$month2 == 'OCTOBER') selected @endif>October</option>
                <option value="NOVEMBER" @if(old('month2') == 'NOVEMBER'||$month2 == 'NOVEMBER') selected @endif>November</option>
                <option value="DECEMBER" @if(old('month2') == 'DECEMBER'||$month2 == 'DECEMBER') selected @endif>December</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label> Special Overtime  </label>
              <select name="sp" id="section" class="form-control">
                <option value="">Inclusive </option>
                <option value="1" @if(old('sp') == '1' ||$sp == '1') selected @endif>Exlusive</option>
              </select>
            </div>
          </div>
          <div class="col-md-9">
            <div class="form-group">
              <div >
                <button type="submit" class="btn btn-success pull-right">Generate Report</button>
              </div>
            </div>           
          </div>
        </div>
      </div> 
      </form> 

    <div class="table-responsive" style="font-size: 11px; padding:10px;">
                <table id="mytable" class="table table-bordered table-striped table-highlight">
		        <thead>
		          <tr bgcolor="#c7c7c7">
		            <th>S/N</th>
		            <th>Staff Name</th>
		            <th>{{$year1}} {{$month1}}</th>
		            <th> {{$year2}} {{$month2}}</th>
		            <th>Variation</th>
		            
		            
		          </tr>
		        </thead>
		               
		        <tbody>
		        
                    @php $i=1; @endphp
                    @php $tnet1=0; @endphp
                    @php $tnet2=0; @endphp
                    @php $tdiff=0; @endphp
		            @foreach($record as $list)
		               <tr>
		               <td>{{ $i++ }} </td>
		               <td> {{$list['Names']}}</td>
		               <td> {{number_format($list['net1'],2, '.', ',')}}</td>
		               <td> {{number_format($list['net2'],2, '.', ',')}}</td>
		               <td> {{number_format($list['diff'],2, '.', ',')}}</td>
		               </tr>
		            @php $tnet1+=$list['net1']; @endphp
                    @php $tnet2+=$list['net2']; @endphp
                    @php $tdiff+=$list['diff']; @endphp
		            @endforeach
		            <tr>
		               <td><b>Total </b></td>
		               <td> </td>
		               <td> <b>{{number_format($tnet1,2, '.', ',')}}</b></td>
		               <td><b> {{number_format($tnet2,2, '.', ',')}}</b></td>
		               <td><b> {{number_format($tdiff,2, '.', ',')}}</b></td>
		               </tr>
		            </tbody>
		      </table>
		     </div>




    </div>
  </div><!-- /.col -->
</div><!-- /.row -->





      

@endsection


@section('styles')
@endsection


@section('scripts')

<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>


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


