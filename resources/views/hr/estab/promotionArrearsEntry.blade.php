@extends('layouts.layout')

@section('pageTitle')
  Add Staff Due For Promotion
@endsection

@section('content')
 
  <div class="box-body">
        <div class="row">
            <div class="col-md-12"><!---1st col-->
<h4 class="" style="text-transform:uppercase">Add Staff Due For Promotion</h4>
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
                      <strong>Success!</strong>
											{{ session('msg') }}
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


				<div class="col-md-12" ><!---2nd col-->

			<form method="post" action="{{ url('/admin/promotion-arrears/entry') }}" style="margin-top:10px; padding-top:20px;">
			    {{ csrf_field() }}
       @if ($CourtInfo->courtstatus==1)
        <div class="col-md-4"style="padding-top:20px;">
            <div class="form-group">
            <label for="staffName">Court</label>
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

            @if ($CourtInfo->divisionstatus==1)
          <div class="col-md-4" style="padding-top:20px;">
            <div class="form-group">
            <label for="staffName">Division</label>
            <select name="division" id="division" class="form-control">
            @if(session('anycourt') != '')
            @foreach($division as $div)
           @if($div->divisionID == session('divsession'))
            <option value="{{$div->divisionID}}" selected="selected">{{$div->division}}</option>
            @else
            <option value="{{$div->divisionID}}">{{$div->division}}</option>
            @endif

            @endforeach
            @endif
            </select>
            </div>
            </div>
            @else
              <input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">
            @endif


            <!-- main Form -->
                <div class="col-md-4" >
                  <div class="form-group">
                  <label for="staffName">Select Staff Name {{session('staffsession')}}</label>
                    <!--<select name="staffName" id="staffName" class="form-control">
                          <option>Select Staff Name</option>
                           @foreach ($staffData as $list)
                          @if($list->ID == session('staff_id'))
                            <option value="{{$list->ID}}" selected>{{$list->first_name}} {{$list->surname}} {{$list->othernames}}</option>
                            @else
                            <option value="{{$list->ID}}"> {{$list->surname}} {{$list->first_name}} {{$list->othernames}} -  {{$list->fileNo}}</option>
                            @endif
                          @endforeach

                      </select>-->
                      
                <label class="control-label">Staff Names Search</label>
                <input type="text" id="userSearch" autocomplete="off" list="enrolledUsers"  class="form-control"  >
		       	<datalist id="enrolledUsers">
				  @foreach($staffData as $list)
				  	<option value="{{ $list->ID}}">{{ $list->fileNo }}:{{$list->surname}} {{$list->first_name}} {{$list->othernames}}</option>
				  @endforeach
				</datalist>
				
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fileNo">File No</label>
                      <input type="Text" name="fileNo" id="fileNo" class="form-control" readonly value="@if($staff !=''){{$staff->ID}}@endif"/>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fileNo">Name</label>
                      <input type="Text" name="name" id="fileNo" class="form-control" readonly value="@if($staff !=''){{$staff->surname}} {{$staff->first_name}} {{$staff->othernames}}@endif"/>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="staffFullName">Employee Type</label>
                    <input type="Text" name="employeeType" id="employeeType" class="form-control" readonly value="@if($staff !=''){{$staff->employmentType}}@endif"/>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="grade">Employee Type (New)</label>
                      
                        <input type="Text" name="newEmployeeType" id="employeeType" class="form-control" readonly value="@if($staff !=''){{$staff->employmentType}}@endif"/>  
                        <input type="hidden" name="newEmpType" id="empType" class="form-control" value="@if($staff !=''){{$staff->employee_type}}@endif"/>                   </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="step">Old Grade</label>
                      <input type="Text" name="oldGrade" id="oldGrade" class="form-control" readonly value="@if($staff !=''){{$staff->grade}}@endif"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="type">New Grade</label>
                      <select name='newGrade' class="form-control">
                        <option value=""></option>
                        @for($i=1;$i<=17;$i++)

                          <option value="{{$i}}" @if(old('newGrade') == $i) selected @endif>{{$i}}</option>

                         @endfor

                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="step">Old Step</label>
                      <input type="Text" name="oldStep" id="oldstep" class="form-control" readonly value="@if($staff !=''){{$staff->step}}@endif"/>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="step">New Step</label>
                      <select name='newStep' class="form-control">
                        <option value=""></option>
                        @for($i=1;$i<=17;$i++)

                           <option value="{{$i}}" @if(old('newStep') == $i) selected @endif>{{$i}}</option>

                          @endfor
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="vehicle">Arrears Type</label>
                      <select name='arrearsType' class="form-control">
                        <option value="">Select</option>
                      
                        <option value="advancement">advancement</option>
                        <option value="advancement">Promotion</option>
                        <option value="advancement">Conversion</option>
                       
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="vehicle">Due Date</label>
                      <input type="Text" name="dueDate" id="dueDate" class="form-control" value="{{old('dueDate')}}" />
                    </div>
                  </div>

              <div class="col">
              <div align="right" class="box-footer">
                <button class="btn btn-success" name="submit" type="submit"> Update</button>
             </div>
            </div>
          </form>
            <!-- //// main form -->




				</div>
        </div><!-- /.col href="{{ url('/variable/view/') }}"-->
    </div><!-- /.row -->
 
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
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
  	});});

    $(document).ready(function(){
    $('#userSearch').change( function(){
      //alert($('#staffName').val());
      var s = 'staff';
      $.ajax({
        url: murl +'/create/session',
        type: "post",
        data: {'staff': $('#userSearch').val(),'val':s, '_token': $('input[name=_token]').val()},
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



@endsection
