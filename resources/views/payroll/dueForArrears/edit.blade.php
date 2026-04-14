@extends('layouts.layout')

@section('pageTitle')
  Staff Due For Arrears
@endsection

@section('content')

  <div class="box-body">
        <div class="row">
            <div class="col-md-12"><!---1st col-->
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


				<div class="col-md-12"><!---2nd col-->
				<form method="post" action="{{ url('/staff-due/store') }}">

            {{ csrf_field() }}


              <div class="col-md-4">
            <div class="form-group">
            <label for="staffName">Court</label>
            <select name="court" id="court" class="form-control court" readonly>
              @foreach($allcourts as $list)
              @if($list->id == $staffList->courtID)
              <option value="{{$list->id}}" selected>{{$list->court_name}}</option>
              
              @endif
              @endforeach
              
            </select>
            </div>
            </div>

            <div class="col-md-4" >
            <div class="form-group">
            <label for="staffName">Division</label>
            <select name="division" id="division" class="form-control" readonly>
              @foreach($allDivisions as $list)
              @if($list->divisionID == $division->divisionID)
              <option value="{{$list->divisionID}}" selected>{{$list->division}}</option>
              
              @endif
              @endforeach
              
            </select>
            
            </div>
            </div>


								  <div class="col-md-4">
										<div class="form-group">
										  <label for="staffName">Select Staff Name</label>
										  <input type ="" name="staffName" readonly id="staffName" class="form-control" value="{{$staffList->surname}} {{$staffList->first_name}} {{$staffList->othernames}}">
													
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
										  <label for="fileNo">File No</label>
										  <input type="Text" name="fileNo" id="fileNo" class="form-control" readonly value="{{$staffList->fileNo}}"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
										<label for="staffFullName">Employee Type</label>
                    <input type="Text" name="employeeType" id="employeeType" class="form-control" readonly value="{{$staffList->employee_type}}"/>
										</div>
									</div>

								  <div class="col-md-6">
                      <div class="form-group">
                      <label for="grade">Employee Type (New)</label>

                      <select name='newEmployeeType' class="form-control">
                        <option value=""> Select </option>
                      @foreach($emptype as $list)
                      @if($list->id == $staffList->employee_type)
                      <option value="{{$list->id}}" selected>{{$list->employmentType}}</option>
                      @else
                      <option value="{{$list->id}}" @if(old('newEmployeeType') == $list->id) selected @endif>{{$list->employmentType}}</option>
                      @endif
                      @endforeach

                      </select>

										 
										</div>
									</div>

                  <div class="col-md-6">
										<div class="form-group">
										  <label for="step">Old Grade</label>
										  <input type="Text" name="oldGrade" id="oldGrade" class="form-control" readonly value="{{$staffList->grade}}"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
										  <label for="type">New Grade</label>
                      <select name='newGrade' class="form-control">
                        <option value=""></option>
                        @for($i=1;$i<=17;$i++)
                        @if($i == $staffList->new_grade)
                          <option value="{{$i}}" selected>{{$i}}</option>
                          @else
                          <option value="{{$i}}" @if(old('newGrade') == $i) selected @endif>{{$i}}</option>
                          @endif
                         @endfor

                      </select>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
										  <label for="step">Old Step</label>
										  <input type="Text" name="oldStep" id="oldstep" class="form-control" readonly value="{{$staffList->step}}"/>
										</div>
									</div>

                  <div class="col-md-6">
										<div class="form-group">
										  <label for="step">New Step</label>
                      <select name='newStep' class="form-control">
                        <option value=""></option>
                        @for($i=1;$i<=17;$i++)
                         @if($i == $staffList->new_step)
                          <option value="{{$i}}" selected>{{$i}}</option>
                           @else
                           <option value="{{$i}}" @if(old('newStep') == $i) selected @endif>{{$i}}</option>
                           @endif
                          @endfor
                      </select>
										</div>
									</div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="vehicle">Arrears Type</label>
                      <select name='arrearsType' class="form-control" readonly>
                        <option value="increment">Increment</option>
                        
                      </select>
                    </div>
                  </div>

								  <div class="col-md-6">
										<div class="form-group">
										  <label for="vehicle">Due Date</label>
										  <input type="Text" name="dueDate" id="dueDate" class="form-control" value="{{$staffList->due_date}}" />
										</div>
									</div>


							<div align="right" class="box-footer">
								<button class="btn btn-success" name="submit" type="submit"> Update</button>
						 </div>
				</div>
        </div><!-- /.col href="{{ url('/variable/view/') }}"-->
    </div><!-- /.row -->
  </form>
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



@endsection
