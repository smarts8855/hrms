@extends('layouts.layout')
@section('pageTitle')

@endsection

@section('content')
<div class="box box-default" style="border-top: none;">
  <form action="{{url('/open-file-registry/filter-outgoing')}}" method="post">
    {{ csrf_field() }}
    <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
      <span class="pull-right" style="margin-right: 30px;">
      <div style="float: left;">
        <div class="wrap">
          <div class="search"> &nbsp; <a href="{{url('/open-file-registry/view-outgoing')}}" title="Refresh"><i class="fa fa-refresh"></i> Refresh</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" id="autocomplete" name="q" class="searchTerm" placeholder="Search By Owner Name ">
            <input type="hidden" id="ownername"  name="name">
            <button type="submit" class="searchButton"> <i class="fa fa-search"></i> </button>
          </div>
        </div>
      </div>
      </span> </div>
  </form>
  <div style="margin: 10px 20px;"> <big><b>{{strtoupper('Viewing Outgoing Letter ')}}</b></big> <span class="pull-right" style="margin-right: 30px;">Printed On: {{date('D M, Y')}}.</span> @if(session('err'))
    <div class="alert alert-warning alert-dismissible hidden-print" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
      <strong>Error!</strong> {{ session('err') }} </div>
    @endif </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped table-condensed table-bordered">
          <thead>
            <th>S/N</th>
            <th>Owners Name</th>
            <th>Collector Name</th>
            <th>Detail</th>
            <th>Collector Phone</th> 
          </thead>
          <tbody>
          
          @php $key = 1; @endphp
          @foreach ($details as $list)
          <tr>
            <td>{{$key ++}}</td>
            <td>{{$list->owner_name}}</td>
            <td>{{ $list->collector_name }}</td>
            <td>{{ $list->details}}</td>
            <td>{{ $list->phone }}</td>
          </tr>
          @endforeach
          </tbody> 
        </table>
  
        <div class="">{{ $details->links() }}</div>
      </div>
    </div>
    <!-- /.col --> 
  </div>
  <!-- /.row --> 
  
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
        serviceUrl: murl + '/open-file-registry/searchoutgoing',
        minLength: 2,
        onSelect: function (suggestion) {
            $('#ownername').val(suggestion.data);
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