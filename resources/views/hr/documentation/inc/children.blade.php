<form action="{{url('/documentation-children')}}" method="POST">
	{{csrf_field()}}
		<div class="tab-pane" role="tabpanel" id="step3">
			<div class="col-md-offset-0">
				<h3 class="text-success text-center">
					<i class="glyphicon glyphicon-envelope"></i> <b>Children</b>
				</h3>
				<div align="right" style="margin-top: -35px;"> 
					Field with <span class="text-danger"><big>*</big></span> is important
				</div>
			</div>
			<br />
			<p>
			<div class="row col-md-offset-1">
				<div class="col-md-4 ">
					@if(!empty($children[0]))
					
					<label>Fullname</label>
					
					<input class="form-control input-lg" id="fullname" name="fullname[]" value="{{$children[0]->fullname}}">
					
					@else
					<label>Fullname</label>
					<input class="form-control input-lg" id="fullname" name="fullname[]" value="{{old('fullname')}}" >

					@endif

						
				</div>

				<div class="col-md-2">
						@if(!empty($children[0]))
						
						<label>Date of Birth</label>
						<input name="childDateOfBirth[]" id="childDateOfBirthb" value="{{ date('d-m-Y', strtotime($children[0]->dateofbirth)) }}" class="form-control input-lg">
						
						@else
						<label>Date of Birth</label>
						<input name="childDateOfBirth[]" id="childDateOfBirth2b" value="{{old('childDateOfBirth[]')}}" class="form-control input-lg">
						@endif

					</div>

				<div class="col-md-2">
					@if(!empty($children[0]))
					
					<label>Gender</label>
					<select name="gender[]" id="childGender" class="form-control input-lg" value="">
						<option value="" selected>Select</option>
						<option {{ ($children[0]->gender== 'Male' ? 'selected' : '') }} value="Male">Male</option>
						<option {{ ($children[0]->gender== 'Female' ? 'selected' : '') }} value="Female">Female</option>
					</select>
					
					@else
					<label>Gender</label>
					<select name="gender[]" id="childGender" class="form-control input-lg" value="">
						<option value="" selected>Select</option>
						<option >Male</option>
						<option>Female</option>
					</select>
					@endif
				</div>
				

			</div>
			
			<div class="row col-md-offset-1">
				<div class="col-md-4 ">
					@if(!empty($children[1]))
					
					<label>Fullname</label>
					
					<input class="form-control input-lg" id="fullname" name="fullname[]" value="{{ $children[1]->fullname }}">
					
					@else
					<label>Fullname</label>
					<input class="form-control input-lg" id="fullname" name="fullname[]" value="{{old('fullname')}}" >

					@endif

						
				</div>

				<div class="col-md-2">
						@if(!empty($children[1]))
						
						<label>Date of Birth</label>
						<input name="childDateOfBirth[]" id="childDateOfBirtha" value="{{date('d-m-Y', strtotime($children[1]->dateofbirth)) }}" class="form-control input-lg">
						
						@else
						<label>Date of Birth</label>
						<input name="childDateOfBirth[]" id="childDateOfBirth2a" value="{{old('childDateOfBirth[]')}}" class="form-control input-lg">
						@endif

					</div>

				<div class="col-md-2">
					@if(!empty($children[1]))
					
					<label>Gender</label>
					<select name="gender[]" id="childGender" class="form-control input-lg" value="">
						<option value="" selected>Select</option>
						<option {{ ($children[1]->gender== 'Male' ? 'selected' : '') }} value="Male">Male</option>
						<option {{ ($children[1]->gender== 'Female' ? 'selected' : '') }} value="Female">Female</option>
					</select>
					
					@else
					<label>Gender</label>
					<select name="gender[]" id="childGender" class="form-control input-lg" value="">
						<option value="" selected>Select</option>
						<option >Male</option>
						<option>Female</option>
					</select>
					@endif
				</div>
				
				</div>
				
				<div class="row col-md-offset-1">
				<div class="col-md-4 ">
					@if(!empty($children[2]))
					
					<label>Fullname</label>
					
					<input class="form-control input-lg" id="fullname" name="fullname[]" value="{{ $children[2]->fullname }}">
					
					@else
					<label>Fullname</label>
					<input class="form-control input-lg" id="fullname" name="fullname[]" value="{{old('fullname')}}" >

					@endif

						
				</div>

				<div class="col-md-2">
						@if(!empty($children[2]))
						
						<label>Date of Birth</label>
						<input name="childDateOfBirth[]" id="childDateOfBirthy" value="{{ date('d-m-Y', strtotime($children[2]->dateofbirth)) }}" class="form-control input-lg">
						
						@else
						<label>Date of Birth</label>
						<input name="childDateOfBirth[]" id="childDateOfBirth2y" value="{{old('childDateOfBirth[]')}}" class="form-control input-lg">
						@endif

					</div>

				<div class="col-md-2">
					@if(!empty($children[2]))
					
					<label>Gender</label>
					<select name="gender[]" id="childGender" class="form-control input-lg" value="">
						<option value="" selected>Select</option>
						<option {{ ($children[2]->gender== 'Male' ? 'selected' : '') }} value="Male">Male</option>
						<option {{ ($children[2]->gender== 'Female' ? 'selected' : '') }} value="Female">Female</option>
					</select>
					
					@else
					<label>Gender</label>
					<select name="gender[]" id="childGender" class="form-control input-lg" value="">
						<option value="" selected>Select</option>
						<option >Male</option>
						<option>Female</option>
					</select>
					@endif
				</div>
				

			</div>
			
			
			<div class="row col-md-offset-1">
				<div class="col-md-4 ">
					@if(!empty($children[3]))
					
					<label>Fullname</label>
					
					<input class="form-control input-lg" id="fullname" name="fullname[]" value="{{ $children[3]->fullname }}">
					
					@else
					<label>Fullname</label>
					<input class="form-control input-lg" id="fullname" name="fullname[]" value="{{old('fullname')}}" >

					@endif

						
				</div>

				<div class="col-md-2">
						@if(!empty($children[3]))
						
						<label>Date of Birth</label>
						<input name="childDateOfBirth[]" id="childDateOfBirthx" value="{{ date('d-m-Y', strtotime($children[3]->dateofbirth)) }}" class="form-control input-lg">
						
						@else
						<label>Date of Birth</label>
						<input name="childDateOfBirth[]" id="childDateOfBirth2x" value="{{old('childDateOfBirth[]')}}" class="form-control input-lg">
						@endif

					</div>

				<div class="col-md-2">
					@if(!empty($children[3]))
					
					<label>Gender</label>
					<select name="gender[]" id="childGender" class="form-control input-lg" value="">
						<option value="" selected>Select</option>
						<option {{ ($children[3]->gender== 'Male' ? 'selected' : '') }} value="Male">Male</option>
						<option {{ ($children[3]->gender== 'Female' ? 'selected' : '') }} value="Female">Female</option>
					</select>
					
					@else
					<label>Gender</label>
					<select name="gender[]" id="childGender" class="form-control input-lg" value="">
						<option value="" selected>Select</option>
						<option >Male</option>
						<option>Female</option>
					</select>
					@endif
				</div>
				

			</div>
			
				

			</div>

			</p>
			<hr />
			<div align="center">
				<ul class="list-inline">
					<li><a href="{{url('/documentation-nextofkin')}}" class="btn btn-default">Previous</a></li>
					<li><button type="submit" class="btn btn-primary">Save and continue</button></li>
				</ul>
			</div>
		</div>
</form>

<styles>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />

</styles>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>

{{-- <script>
  $(document).ready(function () {
        $('input[id$=childDateOfBirthx]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=childDateOfBirth2x]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=childDateOfBirth2y]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=childDateOfBirthy]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=childDateOfBirtha]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=childDateOfBirth2a]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=childDateOfBirthb]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=childDateOfBirth2b]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
</script> --}}

<script>
$(document).ready(function () {
    // Common datepicker configuration
    const datePickerConfig = {
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+0',
        changeMonth: true,
        changeYear: true,
        showMonthAfterYear: true,
        maxDate: '0',
        beforeShow: function(input, inst) {
            // Ensure the calendar appears above other elements
            inst.dpDiv.css({
                marginTop: '-1px',
                zIndex: 1000
            });
        },
        onClose: function(dateText, inst) {
            // Validate date format
            if (dateText) {
                try {
                    $.datepicker.parseDate('dd-mm-yy', dateText);
                } catch (e) {
                    $(this).val('');
                    alert('Please use the date picker to select a valid date');
                }
            }
        }
    };

    // Apply datepicker to all date inputs
    $('input[id^=childDateOfBirth]').each(function() {
        $(this).datepicker(datePickerConfig);
    });
});
</script>
