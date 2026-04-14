						 @include('hr.Share.message')
						<form id="maritalStatus" action="{{url('/documentation-marital-status')}}" method="POST">
        							{{csrf_field()}}
					                    <div class="tab-pane" role="tabpanel" id="step3">
					                        <div class="col-md-offset-0">
					                        	<h3 class="text-success text-center">
					                        		<i class="glyphicon glyphicon-envelope"></i> <b>Marital Information</b>
					                        	</h3>
					                        	<div align="right" style="margin-top: -35px;"> 
					                        		Field with <span class="text-danger"><big>*</big></span> is important
					                        	</div>
					                    	</div>
					                    	<br />
					                        <p>
					                        	<div class="row">
					                        	<div class="col-md-8 col-md-offset-2">
						                        	<div class="row col-md-offset-3">
						                        		<div class="col-md-7">
						                        			 <div class="form-group">
												              <label>Marital Status  <span class="text-danger"><big>*</big></span></label>
															 
												              		<select name="status" id="changeStatus" class="form-control input-lg" value="" required oninput="toggle()">
																		  <option value="" selected>Select</option>
																		  @foreach($status as $sta)
																		  	<option value="{{$sta->marital_status}}" {{ ($relationship == $sta->marital_status || old("status") == $sta->marital_status )? "selected" :"" }}>{{$sta->marital_status}} </option>
																		  @endforeach
												              		</select>
												              			
												            </div>
						                        		</div>
						                        		<div>

						                        		</div>
													</div>
												@if($relationship=='Married')
												<div id="myDIV" style="display:block">
									
						                        	<div class="row">
						                        		<div class="col-md-6">
						                        			<div class="form-group">
							                        		  <label>Name of Spouse <span class="text-danger"><big>*</big></span></label>
															  @if($maritalStatus != '')
												              		<input type="text" name="spouseName" id="spouseName" class="form-control input-lg" value="{{$maritalStatus->wifename}}" /> 
															  @else
															  		<input type="text" name="spouseName" id="spouseName" class="form-control input-lg" value="{{old('spouseName')}}" />
															  @endif
												            </div>
										                </div>
										                <div class="col-md-6">
										                	<div class="form-group">
						                        				<label>Spouse Date of Birth</label>
																@if($maritalStatus != '')
																  <input type="text" name="spouseDateOfBirth" id="spouseDateOfBirth" class="form-control input-lg" value="{{ date('d-m-Y',strtotime($maritalStatus->wifedateofbirth))}}" required readonly/> 
																@else 
																  <input type="text" name="spouseDateOfBirth" id="spouseDateOfBirth2" class="form-control input-lg" value="{{old('spouseDateOfBirth')}}" required readonly/> 
																@endif
											              	</div> 
					                        			</div>
						                        	</div><!--//row 1-->
					                        		<div class="row">
						                        		<div class="col-md-6">
						                        			<div class="form-group">
							                        			<label>Date of Marriage</label>
							                        			@if($maritalStatus != '')
												              		<input type="text" name="dataOfMarriage" id="dataOfMarriage" class="form-control input-lg" value="{{date('d-m-Y',strtotime($maritalStatus->dateofmarriage))}}" required/> 
																@else
																	<input type="text" name="dataOfMarriage" id="dataOfMarriage2" class="form-control input-lg" value="{{old('dataOfMarriage')}}" required/>
																	@endif
												            </div>
						                        		</div>
						                        		<div class="col-md-6">
						                        			<div class="form-group">
																
							                        			<label>Spouse Address<span class="text-danger"><big>*</big></span></label>
							                        			@if($maritalStatus != '')
																	  <input type="text" name="spouseAddress" id="spouseAddress" class="form-control input-lg" value="{{$maritalStatus->homeplace}}" /> 
																	  @else
																	  <input type="text" name="spouseAddress" id="spouseAddress" class="form-control input-lg" value="{{old('spouseAddress')}}" />
																	  @endif
												              
												            </div>
						                        		</div>
					                        		</div><!--//row 2-->
					                        	</div>
					                            @else
					                            	<div id="myDIV" style="display:none">
									
						                        	<div class="row">
						                        		<div class="col-md-6">
						                        			<div class="form-group">
							                        		  <label>Name of Spouse <span class="text-danger"><big>*</big></span></label>
															  @if($maritalStatus != '')
												              		<input type="text" name="spouseName" id="spouseName" class="form-control input-lg" value="{{$maritalStatus->wifename}}" /> 
															  @else
															  		<input type="text" name="spouseName" id="spouseName" class="form-control input-lg" value="{{old('spouseName')}}" />
															  @endif
												            </div>
										                </div>
										                <div class="col-md-6">
										                	<div class="form-group">
						                        				<label>Spouse Date of Birth</label>
																@if($maritalStatus != '')
																  {{-- <input type="text" name="spouseDateOfBirth" id="spouseDateOfBirth" class="form-control input-lg" value="{{ date('d-m-Y',strtotime($maritalStatus->wifedateofbirth))}}" required readonly/>  --}}
																  <input type="text" name="spouseDateOfBirth" id="spouseDateOfBirth" class="form-control input-lg" 
    																value="{{ date('d-m-Y',strtotime($maritalStatus->wifedateofbirth))}}" required />
																@else 
																  {{-- <input type="text" name="spouseDateOfBirth" id="spouseDateOfBirth2" class="form-control input-lg" value="{{old('spouseDateOfBirth')}}" required readonly/>  --}}
																	<input type="text" name="spouseDateOfBirth" id="spouseDateOfBirth2" class="form-control input-lg" value="{{old('spouseDateOfBirth')}}" required />
																@endif
											              	</div> 
					                        			</div>
						                        	</div><!--//row 1-->
					                        		<div class="row">
						                        		<div class="col-md-6">
						                        			<div class="form-group">
							                        			<label>Date of Marriage</label>
							                        			@if($maritalStatus != '')
												              		{{-- <input type="text" name="dataOfMarriage" id="dataOfMarriage" class="form-control input-lg" value="{{date('d-m-Y',strtotime($maritalStatus->dateofmarriage))}}" required readonly/>  --}}
																	<input type="text" name="dataOfMarriage" id="dataOfMarriage" class="form-control input-lg" value="{{date('d-m-Y',strtotime($maritalStatus->dateofmarriage))}}" required />
																@else
																	{{-- <input type="text" name="dataOfMarriage" id="dataOfMarriage2" class="form-control input-lg" value="{{old('dataOfMarriage')}}" required readonly/> --}}
																	<input type="text" name="dataOfMarriage" id="dataOfMarriage2" class="form-control input-lg" value="{{old('dataOfMarriage')}}" required />
																@endif
												            </div>
						                        		</div>
						                        		<div class="col-md-6">
						                        			<div class="form-group">
																
							                        			<label>Spouse Address<span class="text-danger"><big>*</big></span></label>
							                        			@if($maritalStatus != '')
																	  <input type="text" name="spouseAddress" id="spouseAddress" class="form-control input-lg" value="{{$maritalStatus->homeplace}}" /> 
																	  @else
																	  <input type="text" name="spouseAddress" id="spouseAddress" class="form-control input-lg" value="{{old('spouseAddress')}}" />
																	  @endif
												              
												            </div>
						                        		</div>
					                        		</div><!--//row 2-->
					                        	</div>
					                            @endif
					                        	</div>
					                        </div>
					                        </p>
					                        <hr />
					                        <div align="center">
						                        <ul class="list-inline">
						                            <li><a href="{{url('/documentation-placeofbirth')}}" class="btn btn-default">Previous</a></li>
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
    
    function toggle() {
      
        var y = document.getElementById('changeStatus').value

        if(y=="Married") {
            document.getElementById("myDIV").style.display = "block"; 
        }
        else {
            document.getElementById("myDIV").style.display = "none"; 
        }
        
    }
</script> --}}
<script>
function toggle() {
    var status = document.getElementById('changeStatus').value;
    var div = document.getElementById("myDIV");

    var spouseDOB = document.querySelectorAll(
        '#spouseDateOfBirth, #spouseDateOfBirth2'
    );
    var marriageDate = document.querySelectorAll(
        '#dataOfMarriage, #dataOfMarriage2'
    );

    if (status === "Married") {
        div.style.display = "block";

        spouseDOB.forEach(el => el.required = true);
        marriageDate.forEach(el => el.required = true);

    } else {
        div.style.display = "none";

        spouseDOB.forEach(el => {
            el.required = false;
            el.value = '';
        });

        marriageDate.forEach(el => {
            el.required = false;
            el.value = '';
        });
    }
}
</script>
{{-- <script>

   $(document).ready(function () {
        $('input[id$=spouseDateOfBirth]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=spouseDateOfBirth2]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  $(document).ready(function () {
        $('input[id$=dataOfMarriage]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  $(document).ready(function () {
        $('input[id$=dataOfMarriage2]').datepicker({
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

    // Apply datepicker to spouse birth date inputs
    $('#spouseDateOfBirth, #spouseDateOfBirth2').each(function() {
        $(this).datepicker(datePickerConfig);
    });

    // Apply datepicker to marriage date inputs
    $('#dataOfMarriage, #dataOfMarriage2').each(function() {
        $(this).datepicker(datePickerConfig);
    });

    // Remove readonly attribute from date inputs since datepicker handles validation
    $('#spouseDateOfBirth, #spouseDateOfBirth2, #dataOfMarriage, #dataOfMarriage2')
        .removeAttr('readonly');
});
</script>
									   
		