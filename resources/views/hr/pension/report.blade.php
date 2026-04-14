@extends('layouts.layout')
@section('pageTitle')
	<h4><b>{{strtoupper('STAFF PENSION REPORT')}}</b></h4>
@endsection

@section('content')
<div class="box box-default">
	
  <div class="box-header with-border hidden-print">
    <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
  </div>
 
	<div>
  <div class="row" style="margin: 5px 15px;">
  <form method="POST" action="{{ url('/pension/report/view') }}">
    <div>
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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> 
            {{ session('message') }}
          </div>                        
          @endif
          @if(session('err'))
            <div class="alert alert-warning alert-dismissible hidden-print" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <strong>Error!</strong> 
            {{ session('err') }} 
            </div>                        
           @endif
        </div>
        {{ csrf_field() }}
        <div class="col-md-12">

          <div class="row">
         
              <div class="col-md-6">
            <div class="form-group">
              <label for="bankName">Select Staff</label>
              <select name="fileNo" class="form-control">
                <option value=""></option>
                @foreach($staff as $list)
                <option value="{{$list->fileNo}}">{{'JIPPIS/P' . $list->fileNo .' - '. $list->surname .' '.$list->first_name}}</option>
                @endforeach
                
              </select>
            </div>
          </div>  
        <div class="col-md-6">
              <div class="form-group">
               <label >Select a Year</label>                       
               <select name="year" id="section" class="form-control">
                  <option value="">Select Year</option>
                  <option value="">All Report</option>
                  @for($i = 2016; $i <= 2050; $i++)
                    <option>{{$i}}</option>
                  @endfor                 
              </select>
            </div>
          </div>
          </div>
          </div>
        
          <div class="row">
            <div align="center" class="col-md-12">
                <button type="submit" class="btn btn-success">Generate Report</button>
            </div>
          </div>
          <br /><br />          

        </div>
      </div>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->
</form>


<div class="box box-default col-md-12" >
<h4><b>{{strtoupper('MONTHLY PENSION REPORT')}}</b></h4>
<hr />
<form method="post" action="{{url('/pension/report/monthlyReport') }}">
          <div class="row">
         
          {{ csrf_field() }}    
        <div class="col-md-4">
              <div class="form-group">
               <label >Select a PFA</label>                       
               <select name="persionManager" class="form-control">
                <option value=""></option>
                @foreach($allPensionManager as $pM)
                  <option value="{{$pM->ID}}">{{$pM->pension_manager}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-md-4">
              <div class="form-group">
               <label >Select a Month</label>                       
               <select name="month" id="section" class="form-control">
                <option value=""></option>
                <option value="JANUARY">JANUARY</option>
                <option value="FEBRUARY">FEBRUARY</option>
                <option value="MARCH">MARCH</option>
                <option value="APRIL">APRIL</option>
                <option value="MAY">MAY</option>
                <option value="JUNE">JUNE</option>
                <option value="JULY">JULY</option>
                <option value="AUGUST">AUGUST</option>
                <option value="SEPTEMBER">SEPTEMBER</option>
                <option value="OCTOBER">OCTOBER</option>
                <option value="NOVEMBER">NOVEMBER</option>
                <option value="DECEMBER">DECEMBER</option>
                
              </select>
            </div>
          </div>

          <div class="col-md-4">
              <div class="form-group">
               <label >Select a Year</label>                       
               <select name="year" id="section" class="form-control">
                <option value=""></option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
                <option value="2033">2033</option>
                <option value="2024">2034</option>
                <option value="2035">2035</option>
                <option value="2036">2036</option>
                <option value="2037">2037</option>
                <option value="2038">2038</option>
                <option value="2039">2039</option>
                <option value="2040">2040</option>                  
              </select>
            </div>
          </div>
          </div>
      
          <div class="row">
            <div align="center" class="col-md-12">
                <button type="submit" class="btn btn-success">Generate Report</button>
            </div>
          </div> 
          <br /><br />
      </form>
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