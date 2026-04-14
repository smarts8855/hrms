<form action="{{url('/documentation-previous-employment')}}" method="POST">
			{{csrf_field()}}
				<div class="tab-pane" role="tabpanel" id="step3">
					<div class="col-md-offset-0">
						<h3 class="text-success text-center">
							<i class="glyphicon glyphicon-envelope"></i> <b>Previous Employment</b>
						</h3>
						<div align="right" style="margin-top: -35px;"> 
							Field with <span class="text-danger"><big>*</big></span> is important
						</div>
					</div>
					<br />
					<p>
					<div class="row">
						<div class="col-md-3">
							@if(!empty($prevEmployment[0]))
							
							<label>Employer</label>
							<input class="form-control input-lg" id="employment" name="employment[]" value="{{$prevEmployment[0]->previousSchudule}}">
							
							@else
							<label>Employer</label>
							<input class="form-control input-lg" id="employment" name="employment[]" value="{{old('employment')}}" >

							@endif

								
						</div>
						<div class="col-md-2">
							@if(!empty($prevEmployment[0]))
							
							<label>Previous Pay</label>
							<input type="text" name="previousPay[]" id="appointmentheld" class="form-control input-lg" value="{{ number_format($prevEmployment[0]->totalPreviousPay) }}">
							@else
							<label>Previous Pay</label>
							<input type="text" name="previousPay[]" id="appointmentheld" class="form-control input-lg" value="{{old('previousPay')}}">
							@endif
						</div>
						<div class="col-md-2">

							@if(!empty($prevEmployment[0]))
							
							<label>From</label>
							  <input type="text" name="fromPrevEmp[]" id="fromPrevEmpx" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($prevEmployment[0]->fromDate)) }}" readonly/> 
							  
							@else
							<label>From</label>
							  <input type="text" name="fromPrevEmp[]" id="fromPrevEmp2x" class="form-control input-lg" value="" readonly/> 
							@endif
				              	
						</div>
						
						<div class="col-md-2">

							@if(!empty($prevEmployment[0]))
							<label>To</label>
							  <input type="text" name="toPrevEmp[]" id="toPrevEmpx" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($prevEmployment[0]->toDate)) }}" readonly/> 
							@else
							<label>To</label>
							  <input type="text" name="toPrevEmp[]" id="toPrevEmp2x" class="form-control input-lg" value="" readonly/> 
							@endif
				              	
						</div>
						
						<div class="col-md-1">

							@if(!empty($prevEmployment[0]))
							<label>File Pages</label>
							  <input type="text" name="filePage[]" id="filePage" class="form-control input-lg" value="{{ $prevEmployment[0]->filePageRef }}" readonly/> 
							@else
							<label>File Pages</label>
							  <input type="text" name="filePage[]" id="filePage" class="form-control input-lg" value=""/> 
							@endif
				              	
						</div>
						<div class="col-md-2">

							@if(!empty($prevEmployment[0]))
							<label>Checked By</label>
							  <input type="text" name="checkedBy[]" id="checkedBy" class="form-control input-lg" value="{{ $prevEmployment[0]->checkedby }}" readonly/> 
							@else
							<label>Checked By</label>
							  <input type="text" name="checkedBy[]" id="checkedBy" readonly class="form-control input-lg" value="{{$authCheckby->name}}"/> 
							@endif
				              	
						</div>

					</div>

					
					</p>
					<hr />
					
				</div>
				
				<div class="row">
						<div class="col-md-3 ">
							@if(!empty($prevEmployment[1]))
							
							<label>Employer</label>
							<input class="form-control input-lg" id="employment" name="employment[]" value="{{$prevEmployment[1]->previousSchudule}}">
							
							@else
							<label>Employer</label>
							<input class="form-control input-lg" id="employment" name="employment[]" value="{{old('employment')}}" >

							@endif

								
						</div>
						<div class="col-md-2">
							@if(!empty($prevEmployment[1]))
							
							<label>Previous Pay</label>
							<input type="text" name="previousPay[]" id="appointmentheld" class="form-control input-lg" value="{{ number_format($prevEmployment[1]->totalPreviousPay) }}">
							@else
							<label>Previous Pay</label>
							<input type="text" name="previousPay[]" id="appointmentheld" class="form-control input-lg" value="{{old('previousPay')}}">
							@endif
						</div>
						<div class="col-md-2">

							@if(!empty($prevEmployment[1]))
							
							<label>From</label>
							  <input type="text" name="fromPrevEmp[]" id="fromPrevEmpy" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($prevEmployment[1]->fromDate)) }}" readonly/> 
							  
							@else
							<label>From</label>
							  <input type="text" name="fromPrevEmp[]" id="fromPrevEmp2y" class="form-control input-lg" value="" readonly/> 
							@endif
				              	
						</div>
						
						<div class="col-md-2">

							@if(!empty($prevEmployment[1]))
							<label>To</label>
							  <input type="text" name="toPrevEmp[]" id="toPrevEmpy" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($prevEmployment[1]->toDate)) }}" readonly/> 
							@else
							<label>To</label>
							  <input type="text" name="toPrevEmp[]" id="toPrevEmp2y" class="form-control input-lg" value="" readonly/> 
							@endif
				              	
						</div>
						
							<div class="col-md-1">

							@if(!empty($prevEmployment[1]))
							<label>File Pages</label>
							  <input type="text" name="filePage[]" id="filePage" class="form-control input-lg" value="{{ $prevEmployment[1]->filePageRef }}" readonly/> 
							@else
							<label>File Pages</label>
							  <input type="text" name="filePage[]" id="filePage" class="form-control input-lg" value=""/> 
							@endif
				              	
						</div>
						<div class="col-md-2">

							@if(!empty($prevEmployment[1]))
							<label>Checked By</label>
							  <input type="text" name="checkedBy[]" id="checkedBy" class="form-control input-lg" value="{{ $prevEmployment[1]->checkedby }}" readonly/> 
							@else
							<label>Checked By</label>
							  <input type="text" name="checkedBy[]" id="checkedBy" class="form-control input-lg" readonly value="{{$authCheckby->name}}"/> 
							@endif
				              	
						</div>


					</div>

					
					</p>
					<hr />
					
				</div>
				
				<div class="row">
						<div class="col-md-3">
							@if(!empty($prevEmployment[2]))
							
							<label>Employer</label>
							<input class="form-control input-lg" id="employment" name="employment[]" value="{{$prevEmployment[2]->previousSchudule}}">
							
							@else
							<label>Employer</label>
							<input class="form-control input-lg" id="employment" name="employment[]" value="{{old('employment')}}" >

							@endif

								
						</div>
						<div class="col-md-2">
							@if(!empty($prevEmployment[2]))
							
							<label>Previous Pay</label>
							<input type="text" name="previousPay[]" id="appointmentheld" class="form-control input-lg" value="{{ number_format($prevEmployment[2]->totalPreviousPay) }}">
							@else
							<label>Previous Pay</label>
							<input type="text" name="previousPay[]" id="appointmentheld" class="form-control input-lg" value="{{old('previousPay')}}">
							@endif
						</div>
						<div class="col-md-2">

							@if(!empty($prevEmployment[2]))
							
							<label>From</label>
							  <input type="text" name="fromPrevEmp[]" id="fromPrevEmpa" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($prevEmployment[2]->fromDate)) }}" readonly/> 
							  
							@else
							<label>From</label>
							  <input type="text" name="fromPrevEmp[]" id="fromPrevEmp2a" class="form-control input-lg" value="" readonly/> 
							@endif
				              	
						</div>
						
						<div class="col-md-2">

							@if(!empty($prevEmployment[2]))
							<label>To</label>
							  <input type="text" name="toPrevEmp[]" id="toPrevEmpa" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($prevEmployment[2]->toDate)) }}" readonly/> 
							@else
							<label>To</label>
							  <input type="text" name="toPrevEmp[]" id="toPrevEmp2a" class="form-control input-lg" value="" readonly/> 
							@endif
				              	
						</div>

					    	<div class="col-md-1">

							@if(!empty($prevEmployment[2]))
							<label>File Pages</label>
							  <input type="text" name="filePage[]" id="filePage" class="form-control input-lg" value="{{ $prevEmployment[2]->filePageRef }}" readonly/> 
							@else
							<label>File Pages</label>
							  <input type="text" name="filePage[]" id="filePage" class="form-control input-lg" value=""/> 
							@endif
				              	
						</div>
						<div class="col-md-2">

							@if(!empty($prevEmployment[2]))
							<label>Checked By</label>
							  <input type="text" name="checkedBy[]" id="checkedBy" class="form-control input-lg" value="{{ $prevEmployment[2]->checkedby }}" readonly/> 
							@else
							<label>Checked By</label>
							  <input type="text" name="checkedBy[]" id="checkedBy" class="form-control input-lg" readonly value="{{$authCheckby->name}}"/> 
							@endif
				              	
						</div>


					
					
				
					
				</div>
                    </p>
					<hr/>
				
				<div class="row">
						<div class="col-md-3">
							@if(!empty($prevEmployment[3]))
							
							<label>Employer</label>
							<input class="form-control input-lg" id="employment" name="employment[]" value="{{$prevEmployment[3]->previousSchudule}}">
							
							@else
							<label>Employer</label>
							<input class="form-control input-lg" id="employment" name="employment[]" value="{{old('employment')}}" >

							@endif

								
						</div>
						<div class="col-md-2">
							@if(!empty($prevEmployment[3]))
							
							<label>Previous Pay</label>
							<input type="text" name="previousPay[]" id="appointmentheld" class="form-control input-lg" value="{{ number_format($prevEmployment[3]->totalPreviousPay)}}">
							@else
							<label>Previous Pay</label>
							<input type="text" name="previousPay[]" id="appointmentheld" class="form-control input-lg" value="{{old('previousPay')}}">
							@endif
						</div>
						<div class="col-md-2">

							@if(!empty($prevEmployment[3]))
							
							<label>From</label>
							  <input type="text" name="fromPrevEmp[]" id="fromPrevEmpb" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($prevEmployment[3]->fromDate)) }}" readonly/> 
							  
							@else
							<label>From</label>
							  <input type="text" name="fromPrevEmp[]" id="fromPrevEmp2b" class="form-control input-lg" value="" readonly/> 
							@endif
				              	
						</div>
						
						<div class="col-md-2">

							@if(!empty($prevEmployment[3]))
							<label>To</label>
							  <input type="text" name="toPrevEmp[]" id="toPrevEmpb" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($prevEmployment[3]->toDate)) }}" readonly/> 
							@else
							<label>To</label>
							  <input type="text" name="toPrevEmp[]" id="toPrevEmp2b" class="form-control input-lg" value="" readonly/> 
							@endif
				              	
						</div>
						
							<div class="col-md-1">

							@if(!empty($prevEmployment[3]))
							<label>File Pages</label>
							  <input type="text" name="filePage[]" id="filePage" class="form-control input-lg" value="{{ $prevEmployment[3]->filePageRef }}" readonly/> 
							@else
							<label>File Pages</label>
							  <input type="text" name="filePage[]" id="filePage" class="form-control input-lg" value=""/> 
							@endif
				              	
						</div>
						<div class="col-md-2">

							@if(!empty($prevEmployment[3]))
							<label>Checked By</label>
							  <input type="text" name="checkedBy[]" id="checkedBy" class="form-control input-lg" value="{{ $prevEmployment[3]->checkedby }}" readonly/> 
							@else
							<label>Checked By</label>
							  <input type="text" name="checkedBy[]" id="checkedBy" class="form-control input-lg" readonly value="{{$authCheckby->name}}"/> 
							@endif
				              	
						</div>

					<!--	
                    <table id="myTable1" class="table table-responsive">
                        
					 <tbody>
					    <div class="col-md-6">   
					    <tr class="">
    		                <td><label>Employer</label><input type="text" class="form-control input-lg" placeholder="" name="appname0" id="appname0"></td>
    		                <td><label>Appointment held</label><input type="text" class="form-control input-lg"   placeholder="" name="appaddress0" id="appaddress0" ></td>
    		                <td><label>From</label><input type="text" class="form-control input-lg"   placeholder="" name="appphoneno0" id="appphoneno0"></td>
    		                <td><label>To</label><input type="text" class="form-control input-lg" placeholder=""  name="appemail0" id="appemail0"> <button class="btn btn-outline-secondary" type="button" onclick="addRows()">+</button></td>
                           
    		            </tr>
    		            </div>
    		         </tbody>
    		         </table>
    		         -->
					</div>
					
					</p>
					<hr />
					<div align="center">
						<ul class="list-inline">
							<li><a href="{{url('/documentation-children')}}" class="btn btn-default">Previous</a></li>
							<li><button type="submit" class="btn btn-primary">Save and continue</button></li>
						</ul>
					</div>
				</div>
				
				<input type="hidden" id="appt_count" name="appt_count" value=4>
	</form>

<styles>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />

</styles>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>

<script>
  $(document).ready(function () {
        $('input[id$=fromPrevEmpy]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=fromPrevEmp2y]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=toPrevEmpy]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=toPrevEmp2y]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=fromPrevEmpx]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=fromPrevEmp2x]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=toPrevEmpx]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=toPrevEmp2x]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
   $(document).ready(function () {
        $('input[id$=fromPrevEmpa]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=fromPrevEmp2a]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
   $(document).ready(function () {
        $('input[id$=toPrevEmpa]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=toPrevEmp2a]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
   $(document).ready(function () {
        $('input[id$=fromPrevEmpb]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=fromPrevEmp2b]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
   $(document).ready(function () {
        $('input[id$=toPrevEmpb]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=toPrevEmp2b]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
</script>

<script>
    
    function addRows() {
    var count= document.getElementById('appt_count').value;
    var app=[];
    for (i = 0; i < count; i++) {
        try {
         var json_arr = {};
        json_arr["countid"] = i;
        json_arr["name"] = document.getElementById('appname'+i).value;
        json_arr["address"] = document.getElementById('appaddress'+i).value;
        json_arr["phoneno"] = document.getElementById('appphoneno'+i).value;
        json_arr["email"] = document.getElementById('appemail'+i).value;
        var json_string = JSON.stringify(json_arr);
        app.push(json_string);
      } 
      catch ( e ) {
         // Code to run if an exception occurs
      }
      
       finally {
         // Code that is always executed regardless of 
         // an exception occurring
      }
        
        } 
        //alert(app);
    document.getElementById('appt_count').value = parseInt(count) +1;
    var table = document.getElementById('myTable1');
    var row = table.getElementsByTagName('tr');
    var row = row[row.length-1].outerHTML;
    table.innerHTML = table.innerHTML + row;
    var row = table.getElementsByTagName('tr');
    var row = row[row.length-1].getElementsByTagName('td');
    row[0].innerHTML ='<input type="text" class="form-control input-lg " placeholder="" name="appname' +count + '" id="appname' +count + '"    style="width:250px; padding:0; margin:0;font-size:16px;" autocomplete="off" >'
    row[1].innerHTML ='<input type="text" class="form-control input-lg"  placeholder=""  name="appaddress' +count + '" id="appaddress' +count + '"   style="width:300px; padding:0; margin:0;font-size:16px;" autocomplete="off" >'
    row[2].innerHTML ='<input type="text" class="form-control input-lg" placeholder=""  name="appphoneno' +count + '" id="appphoneno' +count + '"    style="width:150px; padding:0; margin:0;font-size:16px;" autocomplete="off" >'
    row[3].innerHTML ='<div class="input-group mb-3"><input type="text" class="form-control input-lg" name="appemail' +count + '" id="appemail' +count + '"  placeholder="email" aria-label="Username" aria-describedby="basic-addon1"><div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button" onclick="addRows()">+</button><button class="btn btn-outline-secondary" type="button" id="button' +count+'" onclick="RowDel(this)">-</button></div></div>';
    for (i = 0; i < app.length; i++) {
        var obj = JSON.parse(app[i]);
        document.getElementById('appname'+obj.countid).value=obj.name;
        document.getElementById('appaddress'+obj.countid).value=obj.address;
        document.getElementById('appphoneno'+obj.countid).value=obj.phoneno;
        document.getElementById('appemail'+obj.countid).value=obj.email;
    }
    
}

function RowDel(element) {
            var rowJavascript = element.parentNode.parentNode;
            var rowjQuery = $(element).closest("tr");
            var x= rowjQuery[0].rowIndex ;
            var table = document.getElementById('myTable1');
            var row = table.getElementsByTagName('tr');
            row[x].outerHTML = '';
        }

</script>
