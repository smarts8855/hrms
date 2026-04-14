@extends('layouts.layout')

@section('pageTitle')
  Staff Due For Retirement
@endsection

@section('content')
 
  <div class="box-body">
        <div class="row">
            <div class="col-md-12"><!---1st col-->
<h4 class="" style="text-transform:uppercase">Add staff For Retirement</h4>
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
<form method="post"  style="margin-top:10px; padding-top:20px;"  id="mainform" name="mainform">
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

            @if ($CourtInfo->divisionstatus==1 && Auth::user()->is_global==1)
                <div class="col-md-4" style="padding-top:20px;">
                    <div class="form-group">
                        <label for="staffName">Division</label>
                        <select name="division" id="division" class="form-control">
                            <option value="">Select Division</option>
                                @foreach($courtDivisions as $div)
                                    <option value="{{$div->divisionID}}"  @if(old('division') == $div->divisionID) selected @endif>
                                        {{$div->division}}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                </div>
            @else
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Division</label>
                            <input type="text" class="form-control" id="divisionName" name="divisionName" value="{{$curDivision->division}}" readonly>
                    </div>
                </div>
                <input type="hidden" id="division" name="division" value="{{Auth::user()->divisionID}}">
            @endif

            @if ($CourtInfo->courtstatus==1)
                <div class="col-md-4" style="padding-top:20px;">
                    <div class="form-group">
                        {{-- <label for="staffName">Select Staff Name</label> --}}
                        <select name="staffName" id="staffName" class="form-control">
                            <option>Select Staff Name</option>
                            @foreach ($staffList as $list)
                                @if($list->ID == session('staffsession'))
                                    <option value="{{$list->ID}}" selected>
                                        {{$list->first_name}} {{$list->surname}} {{$list->othernames}}
                                    </option>
                                @else
                                    <option value="{{$list->ID}}"> 
                                        {{$list->surname}} {{$list->first_name}} {{$list->othernames}} -  {{$list->fileNo}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
                <div class="col-md-4" style="padding-top:20px;">
                    <div class="form-group">
                
                        <input type="hidden" id="fileNo" name="fileNo" value="@if($staff !=''){{$staff->ID}}@endif"/>
                        <label class="control-label">Staff Names Search</label>
                        <input type="text" id="userSearch" autocomplete="off" list="enrolledUsers"  class="form-control"  onchange="StaffSearchReload()">
                        
                        <datalist id="enrolledUsers" name="staff">
                            @foreach($staffData as $list)
                                <option value="{{ $list->ID}}">
                                    {{ $list->fileNo }}:{{$list->surname}} {{$list->first_name}} {{$list->othernames}}
                                </option>
                            @endforeach
                        </datalist>
                        
                    </div>
			    </div>
            @endif

			<div class="col-md-6">
				<div class="form-group">
				  <label for="fileNo">File No</label>
				  <input type="Text"  class="form-control" readonly value="@if($staff !=''){{$staff->fileNo}}@endif"/>
				</div>
			</div>
<div class="col-md-6">
                    <div class="form-group">
                      <label for="fileNo">Name</label>
                      <input type="Text" name="name"  class="form-control" readonly value="@if($staff !=''){{$staff->surname}} {{$staff->first_name}} {{$staff->othernames}}@endif"/>
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
										  <label for="step">Grade</label>
										  <input type="Text" name="oldGrade" id="oldGrade" class="form-control" readonly value="@if($staff !=''){{$staff->grade}}@endif"/>
										</div>
									</div>
								

									<div class="col-md-6">
										<div class="form-group">
										  <label for="step">Step</label>
										  <input type="Text" name="oldStep" id="oldstep" class="form-control" readonly value="@if($staff !=''){{$staff->step}}@endif"/>
										</div>
									</div>


								  <div class="col-md-6">
										<div class="form-group">
										  <label for="vehicle">Retirement Date</label>
										  <input type="Text" name="dueDate" id="dueDate" class="form-control" value="{{old('dueDate')}}" readonly/>
										</div>
									</div>


							<div align="right" class="box-footer">
								<button class="btn btn-success" name="add" type="submit"> Update</button>
						 </div>
				</div>
        </div><!-- /.col href="{{ url('/variable/view/') }}"-->
    </div><!-- /.row -->
  </form>
  
  <div class="table-responsive" style="font-size: 12px; margin-top:20px;">
      <div class="text-center" style="font-size: 20px;">RETIRED STAFF'S</div>
                <table class="table table-bordered table-striped table-highlight">
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th width="1%">S/N</th>
                            <th>STAFF</th>
                            <th>FILENO</th>
                            <th>DIVISION</th>
                            <th>GRADE</th>
                            <th>STEP</th>
                            <th>RETIREMENT DATE</th>
                            <th>MONTH</th>
                            <th>YEAR</th>
                        </tr>
                    </thead>

                    @if($staffForRetirementList && count($staffForRetirementList) > 0)
                    @foreach ($staffForRetirementList as $key => $b)
                        <tr>
                            <td>{{ $key + 1 }} </td>
                            <td>{{$b->surname}} {{$b->first_name}} {{$b->othernames}}</td>
                            <td>{{ $b->fileNo }}</td>
                            <td>{{ $b->division }}</td>
                            <td>{{ $b->old_grade }}</td>
                            <td>{{ $b->old_step }}</td>
                            <td>{{ $b->due_date }}</td>
                            <td>{{ $b->month_payment }}</td>
                            <td>{{ $b->year_payment }}</td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center text-danger"> No Records found...</td>
                        </tr>
                    @endif

                </table>
            </div>
  
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript">

  
    
	
function  StaffSearchReload()
{	
	document.getElementById('fileNo').value=document.getElementById('userSearch').value;
	document.forms["mainform"].submit();
	//alert("jdjdjdeedd");
	return;
}

</script>

  <script type="text/javascript">

  $( function() {
      $("#dateofBirth").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
      $("#dueDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
      $("#incrementalDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
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
