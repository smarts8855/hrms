@extends('layouts.layout')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@section('pageTitle')
Pay Slip
@endsection
@section('content')
<form method="post" action="{{ url('/payslip/create') }}" target="_blank">
  <div class="box-body" style="background:#FFF;">
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
      </div>
      {{ csrf_field() }}    
      <div class="col-md-12"><!--2nd col-->
<h4 class="" style="text-transform:uppercase">Payslip</h4>
        <div class="row">
          

            @if ($CourtInfo->courtstatus==1)
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="division">Select Court</label>
                    <select name="court" id="court" class="form-control court">
                            <option>Select court</option>
                            @foreach($court as $courts)
                                @if($courts->id == session('anycourt'))
                                    <option value="{{$courts->id}}" selected="selected">{{$courts->court_name}}</option>
                                @else
                                    <option value="{{$courts->id}}">{{$courts->court_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
                <input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
            @endif

            @if ($CourtInfo->divisionstatus==1 && Auth::user()->is_global==1)
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Division</label>  
                        <select name="division" id="division_id" class="form-control" style="font-size: 13px;">
                            <option value="">Select Division</option>
                            @foreach($courtDivisions as $divisions)
                                <option value="{{$divisions->divisionID}}" @if(old('division') == $divisions->divisionID) @endif>{{$divisions->division}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Division</label>
                            <input type="text" class="form-control" id="divisionName" name="divisionName" value="{{$curDivision->division}}" readonly>
                    </div>
                </div>
                <input type="hidden" id="division" name="division" value="{{Auth::user()->divisionID}}">
              {{-- <input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}"> --}}
            @endif




        </div>
        
        <div class="row">
           
            <div class="col-md-6">
                <div class="form-group">
                    <label for="division">Select Staff Name</label>
                    <input type="text" id="user" autocomplete="off" name='staffId' list="enrolledUsers"  class="form-control"  onchange="StaffSearchReload()">
                    
                    <datalist id="enrolledUsers" name="staff">
                        
                        @foreach($users as $b)
                            <option value="{{ $b->ID}}">
                                {{ $b->fileNo }}:{{$b->surname}} {{$b->first_name}} {{$b->othernames}}
                            </option>
                        @endforeach
                    </datalist>
                   
                </div>
                @foreach($users as $b)
                    <input type="hidden" id="id{{$b->ID}}"  value="{{$b->fileNo }}:{{$b->surname}} {{$b->first_name}} {{$b->othernames}}">   
                @endforeach
            </div>

            <div class="col-md-6">
                <div class="form-group">
                <label for="userName">Staff Name</label>
                <input type="hidden" id="fileNo" name="fileNo" > 
                <input type="text"  id="staffname" class="form-control"  readonly/>
                </div>
            </div>

        </div>





        <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label >Select a Year</label>
              <select name="year" id="section" class="form-control input-sm">
                <option value="">Select Year</option>
                @for($i=2025;$i<=2060;$i++)
                <option value="{{$i}}" @if(old('year') == $i) selected @endif>{{$i}}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label> Select a month </label>
              <select name="month" id="section" class="form-control input-sm">
                <option value="">Select Month </option>
                <option value="JANUARY" @if(old('month') == 'JANUARY') selected @endif>January</option>
                <option value="FEBRUARY" @if(old('month') == 'FEBRUARY') selected @endif>February</option>
                <option value="MARCH" @if(old('month') == 'MARCH') selected @endif>March</option>
                <option value="APRIL" @if(old('month') == 'APRIL') selected @endif>April</option>
                <option value="MAY" @if(old('month') == 'MAY') selected @endif>May</option>
                <option value="JUNE" @if(old('month') == 'JUNE') selected @endif>June</option>
                <option value="JULY" @if(old('month') == 'JULY') selected @endif>July</option>
                <option value="AUGUST" @if(old('month') == 'AUGUST') selected @endif>August</option>
                <option value="SEPTEMBER" @if(old('month') == 'SEPTEMBER') selected @endif>September</option>
                <option value="OCTOBER" @if(old('month') == 'OCTOBER') selected @endif>October</option>
                <option value="NOVEMBER" @if(old('month') == 'NOVEMBER') selected @endif>November</option>
                <option value="DECEMBER" @if(old('month') == 'DECEMBER') selected @endif>December</option>
              </select>
            </div>
          </div>
          
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="sortcode"></label>
            <div align="right">
            
              <button class="btn btn-success pull-right" type="submit"> Display</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->
</form>
<div class="box-body">
  <div class="row">
    <div class="col-md-12">
    </br>
  </div>
  @endsection
  @section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
  @endsection
  @section('scripts')
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>


<script type="text/javascript">
    (function () {
      $('#user').change( function(){
        
        var myuser = $('#user').val();
        document.getElementById('staffname').value=document.getElementById('id'+myuser).value;
        $('#fileNo').val(myuser);
      });}) ();
</script>
   
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

$(document).ready(function(){
    $('#division').change( function(){
      //alert('ok')
        var d = 'division';
      $.ajax({
        url: murl +'/division/session',
        type: "post",
        data: {'division': $('#division').val(),'val':d, '_token': $('input[name=_token]').val()},
        success: function(data){
          console.log(data);
          location.reload(true);
          }
      });
    });
});

    $(document).ready(function(){
    $('#staffName').change( function(){
      //alert('ok')
      var s = 'staff';
      $.ajax({
        url: murl +'/division/session',
        type: "post",
        data: {'staff': $('#staffName').val(),'val':s, '_token': $('input[name=_token]').val()},
        success: function(data){
          console.log(data);
          location.reload(true);
          }
      });
    });});

</script>

  <script type="text/javascript">

  $( function() {
      $("#dateofBirth").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
      $("#dueDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
      $("#incrementalDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    } );

</script>



{{-- ///////////////////////////////////// --}}


<script type="text/javascript">
    $(document).ready(function() {
    // alert('danger')

        $('select[name="division"]').on('change', function () {
            var division_id = $(this).val();
            // alert(division_id)
            
            if (division_id) {
                $.ajax({
                    url: "{{ url('/division/staff/ajax') }}/"+division_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                       
                        var d = $('datalist[name="staff"]').html('');
                        $.each(data, function(key, value){
                            $('datalist[name="staff"]').append(`<option value=${value.ID}> 
                                ${value.fileNo} : ${value.surname}  ${value.first_name}  ${value.othernames}  </option>`);
                        });
                    }
                });
            }else{
                alert('danger')
            }

        }); // end sub category

    });
</script>
{{-- ///////////////////////////////////// --}}



@endsection
