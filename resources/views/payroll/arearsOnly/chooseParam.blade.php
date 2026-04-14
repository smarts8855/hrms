@extends('layouts.layout')

@section('pageTitle')
  Compute Promotion Arrears
@endsection

@section('content')
  <form method="post" action="{{ url('/arrears/compute') }}" id="form">
	{{ csrf_field() }}
  <div class="box-body">
          <div class="row">
            <div class="col-md-12">
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
                        
                        @if(session('msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong></strong> {{ session('msg') }}</div>                        
                        @endif
                        @if(session('err'))
                        <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> {{ session('err') }}</div>                        
                        @endif
            </div>

              @if ($CourtInfo->divisionstatus==1 && Auth::user()->is_global==1)
              <div class="col-md-12">
                        <label class="control-label">Division</label>
                        {{-- <select required class="form-control" id="division" name="division" onchange="getStaff()" > --}}
                        <select required class="form-control" id="division" name="division" >
                        <option value=""  >-select Division </option>                
                        @foreach($courtdivision as $list)
                        <option value="{{$list->divisionID}}">{{$list->division}}</option> 
                        @endforeach        
                        </select>
                    </div>
                @else
                  <div class="col-md-12">
                    <div class="form-group">
                        <label>Division</label>
                            <input type="text" class="form-control" id="divisionName" name="divisionName" value="{{$curDivision->division}}" readonly>
                    </div>
                  </div>
                  <input type="hidden" id="division" name="division" value="{{Auth::user()->divisionID}}">
                  <!--<input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">-->
                @endif
            
              <div class="col-md-12">
                <span id="processing"></span>
              </div>

            <!-- 1st column -->
            <div class="col-md-4">
             
              
              {{-- <input type="hidden" id="fileNo" name="fileNo" value="">  --}}
              <label class="control-label">Staff Names Search</label>
              <input type="text" id="userSearch" name="staffList" autocomplete="off" list="enrolledUsers"  class="form-control">
             <datalist id="enrolledUsers" name="userSearch">
             
                @foreach($courtstaff as $b)
                
                  <option value="{{ $b->fileNo }}">{{ $b->fileNo }}:{{$b->surname}} {{$b->first_name}} {{$b->othernames}}</option>
                @endforeach
              </datalist>
              
              <div class="form-group">
                <label>Old Grade</label>
                <select name="grade" id="grade" class="form-control">
                  <option value="">Staff Grade</option>
                  <option value="1" {{ (old("grade") == "1" ? "selected":"") }}>1</option>
                  <option value="2" {{ (old("grade") == "2" ? "selected":"") }}>2</option>
                  <option value="3" {{ (old("grade") == "3" ? "selected":"") }}>3</option>
                  <option value="4" {{ (old("grade") == "4" ? "selected":"") }}>4</option>
                  <option value="5" {{ (old("grade") == "5" ? "selected":"") }}>5</option>
                  <option value="6" {{ (old("grade") == "6" ? "selected":"") }}>6</option>
                  <option value="7" {{ (old("grade") == "7" ? "selected":"") }}>7</option>
                  <option value="8" {{ (old("grade") == "8" ? "selected":"") }}>8</option>
                  <option value="9" {{ (old("grade") == "9" ? "selected":"") }}>9</option>
                  <option value="10" {{ (old("grade") == "10" ? "selected":"") }}>10</option>
                  <option value="11" {{ (old("grade") == "11" ? "selected":"") }}>11</option>
                  <option value="12" {{ (old("grade") == "12" ? "selected":"") }}>12</option>
                  <option value="13" {{ (old("grade") == "13" ? "selected":"") }}>13</option>
                  <option value="14" {{ (old("grade") == "14" ? "selected":"") }}>14</option>
                  <option value="15" {{ (old("grade") == "15" ? "selected":"") }}>15</option>
                  <option value="16" {{ (old("grade") == "16" ? "selected":"") }}>16</option>
                  <option value="17" {{ (old("grade") == "17" ? "selected":"") }}>17</option>
                </select>   
              </div>
               <div class="form-group">
                <label>Old Step</label>
                <select name="step" id="step" class="form-control">
                  <option value="">Staff Step</option>
                  <option value="1" {{ (old("step") == "1" ? "selected":"") }}>1</option>
                  <option value="2" {{ (old("step") == "2" ? "selected":"") }}>2</option>
                  <option value="3" {{ (old("step") == "3" ? "selected":"") }}>3</option>
                  <option value="4" {{ (old("step") == "4" ? "selected":"") }}>4</option>
                  <option value="5" {{ (old("step") == "5" ? "selected":"") }}>5</option>
                  <option value="6" {{ (old("step") == "6" ? "selected":"") }}>6</option>
                  <option value="7" {{ (old("step") == "7" ? "selected":"") }}>7</option>
                  <option value="8" {{ (old("step") == "8" ? "selected":"") }}>8</option>
                  <option value="9" {{ (old("step") == "9" ? "selected":"") }}>9</option>
                  <option value="10" {{ (old("step") == "10" ? "selected":"") }}>10</option>
                  <option value="11" {{ (old("step") == "11" ? "selected":"") }}>11</option>
                  <option value="12" {{ (old("step") == "12" ? "selected":"") }}>12</option>
                  <option value="13" {{ (old("step") == "13" ? "selected":"") }}>13</option>
                  <option value="14" {{ (old("step") == "14" ? "selected":"") }}>14</option>
                  <option value="15" {{ (old("step") == "15" ? "selected":"") }}>15</option>
                </select>   
              </div>
              <div class="form-group">
                <label>Arrears Type</label>
                <select name="arrearsType" id="arrearsType" class="form-control">
                  <option>Select operation</option>
                  <option value="advancement" {{ (old("arrearsType") == "advancement" ? "selected":"") }}>Advancement</option>
                  <option value="advancement" {{ (old("arrearsType") == "advancement" ? "selected":"") }}>Conversion</option>
                  
                  <option value="advancement" {{ (old("arrearsType") == "advancement" ? "selected":"") }}>Promotion</option>
                                  
                </select>
              </div>
               <div class="form-group newGrade">
                <label>New Grade</label>
                <select name="newGrade" id="newGrade" class="form-control">
                  <option value="">Staff Grade</option>
                  <option value="1" {{ (old("newGrade") == "1" ? "selected":"") }}>1</option>
                  <option value="2" {{ (old("newGrade") == "2" ? "selected":"") }}>2</option>
                  <option value="3" {{ (old("newGrade") == "3" ? "selected":"") }}>3</option>
                  <option value="4" {{ (old("newGrade") == "4" ? "selected":"") }}>4</option>
                  <option value="5" {{ (old("newGrade") == "5" ? "selected":"") }}>5</option>
                  <option value="6" {{ (old("newGrade") == "6" ? "selected":"") }}>6</option>
                  <option value="7" {{ (old("newGrade") == "7" ? "selected":"") }}>7</option>
                  <option value="8" {{ (old("newGrade") == "8" ? "selected":"") }}>8</option>
                  <option value="9" {{ (old("newGrade") == "9" ? "selected":"") }}>9</option>
                  <option value="10" {{ (old("newGrade") == "10" ? "selected":"") }}>10</option>
                  <option value="11" {{ (old("newGrade") == "11" ? "selected":"") }}>11</option>
                  <option value="12" {{ (old("newGrade") == "12" ? "selected":"") }}>12</option>
                  <option value="13" {{ (old("newGrade") == "13" ? "selected":"") }}>13</option>
                  <option value="14" {{ (old("newGrade") == "14" ? "selected":"") }}>14</option>
                  <option value="15" {{ (old("newGrade") == "15" ? "selected":"") }}>15</option>
                  <option value="16" {{ (old("newGrade") == "16" ? "selected":"") }}>16</option>
                  <option value="17" {{ (old("newGrade") == "17" ? "selected":"") }}>17</option>
                </select>   
              </div>
              <div class="form-group">
              <label for="month">Month</label>
              <input type="Text" name="month" class="form-control" value="{{$PayrollActivePeriod->month}}" readonly>
            </div>

              </div>
            <!-- /.col -->
            <!-- 2nd column -->
            <div class="col-md-4">
            <div class="form-group">
                <label>File Number</label>
               <input type="text" class="form-control" id="fileNo" name="fileNo" value="{{ old('fileNo') }}" disabled />
              </div>
             <div class="form-group">
                <label>Surname</label>
               <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname') }}" disabled />
              </div>
              <div class="form-group">
                <label>First name</label>
                <input type="text" name="firstName" id="firstName" class="form-control" value="{{ old('firstName') }}" disabled />
              </div>
              <div class="form-group">
                <label>Other Names</label>
                <input type="text" name="otherNames" id="otherNames" class="form-control" value="{{ old('otherNames') }}" disabled />  
              </div>
              <div class="form-group newStep">
                <label>New Step</label>
                <select name="newStep" id="newStep" class="form-control">
                  <option value="">Staff Step</option>
                  <option value="1" {{ (old("newStep") == "1" ? "selected":"") }}>1</option>
                  <option value="2" {{ (old("newStep") == "2" ? "selected":"") }}>2</option>
                  <option value="3" {{ (old("newStep") == "3" ? "selected":"") }}>3</option>
                  <option value="4" {{ (old("newStep") == "4" ? "selected":"") }}>4</option>
                  <option value="5" {{ (old("newStep") == "5" ? "selected":"") }}>5</option>
                  <option value="6" {{ (old("newStep") == "6" ? "selected":"") }}>6</option>
                  <option value="7" {{ (old("newStep") == "7" ? "selected":"") }}>7</option>
                  <option value="8" {{ (old("newStep") == "8" ? "selected":"") }}>8</option>
                  <option value="9" {{ (old("newStep") == "9" ? "selected":"") }}>9</option>
                  <option value="10" {{ (old("newStep") == "10" ? "selected":"") }}>10</option>
                  <option value="11" {{ (old("newStep") == "11" ? "selected":"") }}>11</option>
                  <option value="12" {{ (old("newStep") == "12" ? "selected":"") }}>12</option>
                  <option value="13" {{ (old("newStep") == "13" ? "selected":"") }}>13</option>
                  <option value="14" {{ (old("newStep") == "14" ? "selected":"") }}>14</option>
                  <option value="15" {{ (old("newStep") == "15" ? "selected":"") }}>15</option>
                </select>   
              </div>  
              <div class="form-group">
            <label for="year">Year</label>
            <input type="Text" name="year" class="form-control" value="{{$PayrollActivePeriod->year}}" readonly>
          </div>             
             
            </div>

            <!-- /.col -->
            <!-- 3rd column -->
            <div class="col-md-4">
              <div class="form-group">
               <img id="image" src="{{asset('passport/0.png')}}" height="208"  /> 
              </div>             
              
             <div class="form-group">
                <label>Appointment Date</label>
                <input type="text" name="appointmentDate" id="appointmentDate" class="form-control" value="{{old('appointmentDate')}}" disabled />
              </div>
              <div class="form-group dueDate">
                <label>Due Date</label>
                <input type="text" name="dueDate" id="dueDate" class="form-control" value="{{old('dob')}}" />
              </div>             
             
               <div class="form-group" style="padding-top:25px"> 
                <input type="submit" class="btn btn-success" name="button" value="Compute">
                
                <input type="submit" class="btn btn-success" name="button" value="ReCompute">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                  Details
                </button>
<!--                 <input type="submit" class="btn btn-success" name="button" value="Update staff">
                <input type="reset" class="btn btn-info" name="reset" value="clear form">
 -->              </div>
            </div> <!-- end of col-md-4 -->
            <div class="col-md-12">
              <div class="collapse" id="collapseExample">
              <div class="well">
                @if(session('details'))
                    {!! session('details') !!}
                @endif
              </div>
            </div>
            </div>
            
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
  </form>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<style> 
  .textbox { 
    border: 1px;
    background-color: #66FFBA; 
    outline:0; 
    height:25px; 
    width: 275px; 
  } 
  $('.autocomplete-suggestions').css({
    color: 'red'
  });

  .autocomplete-suggestions{
    color:#66FFBA;
  }
</style>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.autocomplete.js') }}" ></script>
  <script type="text/javascript">
  	(function () {
  $('#arrearsType').change( function(){
    if($('#arrearsType').val() == 'newAppointment')
    {
      $('.newStep').slideUp('500'); $('.newGrade').slideUp('500'); $('.dueDate').slideUp('500');
    }
    else
    {
      $('.newStep').slideDown('slow'); $('.newGrade').slideDown('slow'); $('.dueDate').slideDown('slow'); 
    }
  });
      
	/*$('#staffList').change( function(){
    
    if($('#staffList').val() == "")
      $('#form')[0].reset();

   
		if($('#staffList').val() != "")
    {
        $('#processing').text('Processing. Please wait...');
        $.ajax({
        url: murl +'/per/findStaff',
        type: "post",
        data: {'staffList': $('#staffList').val(), '_token': $('input[name=_token]').val()},
        success: function(data){
        $('#processing').text('');
        $('#image').attr('src', murl+'/passport/'+data.fileNo+'.jpg');
        $('#surname').val(data.surname);
        $('#fileNo').val(data.fileNo);
        $('#title').val(data.title);
        $('#firstName').val(data.first_name); 
        $('#otherNames').val(data.othernames);
        $('#designation').val(data.Designation);
        $('#grade').val(data.grade);
        $('#step').val(data.step);
        $('#appointmentDate').val(data.appointment_date);
        },
      })
    }//end if

	});*/
  	    
  	    
  	}) ();
////////////////////////////////////////////////////////
$( function() {
    $( "#dueDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );

  </script>
  
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
                       
                        var d = $('datalist[name="userSearch"]').html('');
                        $.each(data, function(key, value){
                            $('datalist[name="userSearch"]').append(`<option value=${value.ID}> 
                                ${value.fileNo} : ${value.surname}  ${value.first_name}  ${value.othernames}  </option>`);
                        });
                    }
                });
            }else{
                alert('danger')
            }

        }); // end sub category

        $('#userSearch').on('change', function () {
            console.log("changed", $(this).val())
            // return
            $('#processing').text('Processing. Please wait...');
            $.ajax({
              url: murl +'/per/findStaff',
              type: "post",
              data: {'staffList': $(this).val(), '_token': $('input[name=_token]').val()},
              success: function(data){
                $('#processing').text('');
                $('#image').attr('src', murl+'/passport/'+data.fileNo+'.jpg');
                $('#surname').val(data.surname);
                $('#fileNo').val(data.fileNo);
                $('#userSearch').val(data.fileNo);
                $('#title').val(data.title);
                $('#firstName').val(data.first_name); 
                $('#otherNames').val(data.othernames);
                $('#designation').val(data.Designation);
                $('#grade').val(data.grade);
                $('#step').val(data.step);
                $('#appointmentDate').val(data.appointment_date);
              },
            });
          });

    });
</script>
  
  <script type="text/javascript">
  $(function() {
    $("#autocomplete").autocomplete({
      serviceUrl: murl + '/searchUser',
      minLength: 2,
      onSelect: function (suggestion) {
//alert('hello');
$('#nameID').val(suggestion.data);
//   alert(suggestion.data);
if($('#staffList').val() != "")
    {
        $('#processing').text('Processing. Please wait...');
        $.ajax({
        url: murl +'/per/findStaff',
        type: "post",
        data: {'staffList': $('#nameID').val(), '_token': $('input[name=_token]').val()},
        success: function(data){
        $('#processing').text('');
        $('#image').attr('src', murl+'/passport/'+data.fileNo+'.jpg');
        $('#surname').val(data.surname);
        $('#fileNo').val(data.fileNo);
        $('#title').val(data.title);
        $('#firstName').val(data.first_name); 
        $('#otherNames').val(data.othernames);
        $('#designation').val(data.Designation);
        $('#grade').val(data.grade);
        $('#step').val(data.step);
        $('#appointmentDate').val(data.appointment_date);
        },
      })
    }//end if  

}
});
  });
</script>
@endsection