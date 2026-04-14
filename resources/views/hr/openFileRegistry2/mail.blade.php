@extends('layouts.layout')

@section('pageTitle')
 Add Mail
@endsection
<style type="text/css">
	.table {
        display: block;
        overflow-x: auto;
    }
</style>
@section('content')
<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col--> 
          @if (count($errors) > 0)
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
            <strong>Error!</strong> @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach </div>
          @endif
          
          @if(session('msg'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
            <strong>Success!</strong> {{ session('msg') }} </div>
          @endif
          
          @if(session('err'))
          <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
            <strong>Not Allowed ! </strong> {{ session('err') }} </div>
          @endif </div>
        {{ csrf_field() }}
        <div class="col-md-12"><!--2nd col-->
          
          <!-- /.row -->
          <form method="post" action="{{ url('/open-file-registry/savemail')}}">
            {{ csrf_field() }}
            <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Date Recieved</label>
                  <input type="text" name="dateRecieved" id="daterecieved" class="form-control"/>
                  
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Full Name (Owner)</label>
                  <input type="text" name="ownerName" id="name" class="form-control"/>
                  
                </div>
              </div>
              
            </div>
            <div class="row" style="margin-top: 6px;">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Dispatched Date</label>
                  <input type="text" name="dateDispatched" id="dateDispatched" class="form-control"/>
                </div>
              </div>
               <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Name of Collector</label>
                  <input type="text" name="collectorName" id="phone" class="form-control"/>
                  
                </div>
              </div>
              
            </div>
            <hr />
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3">
                  <div align="left" class="form-group">
                    <label for="month">&nbsp;</label>
                    <br />
                    <a href="#" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a> </div>
                </div>
                <div class="col-md-9">
                  <div align="right" class="form-group">
                    <label for="month">&nbsp;</label>
                    <br />
                    <button name="action" class="btn btn-success" type="submit"> Add New <i class="fa fa-save"></i> </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <hr />
        </div>
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
    
  </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts') 
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script> 
<!-- autocomplete js--> 
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script> 
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script> 
<script src="{{asset('assets/js/datepicker_scripts.js')}}"></script> 

 <script type="text/javascript">
  $( function() {
      $("#daterecieved").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090', // specifying a hard coded year range
        showOtherMonths: true,
        selectOtherMonths: true, 
        dateFormat: "dd MM, yy",
        //dateFormat: "D, MM d, yy",
        onSelect: function(dateText, inst){
          var theDate = new Date(Date.parse($(this).datepicker('getDate')));
        var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
        $("#daterecieved").val(dateFormatted);
          },
    });

  } );


  $( function() {
      $("#dateDispatched").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090', // specifying a hard coded year range
        showOtherMonths: true,
        selectOtherMonths: true, 
        dateFormat: "dd MM, yy",
        //dateFormat: "D, MM d, yy",
        onSelect: function(dateText, inst){
          var theDate = new Date(Date.parse($(this).datepicker('getDate')));
        var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
        $("#dateDispatched").val(dateFormatted);
          },
    });

  } );

</script>
 
@endsection