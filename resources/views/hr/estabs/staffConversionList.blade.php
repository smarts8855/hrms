@extends('layouts.layout')
@section('pageTitle')
	 NOMINAL ROLL
@endsection

<style type="text/css">
  /*form  control*/
  .input-group input[type="text"], .input-group .form-control {
    border: 1px solid #eee;
    box-shadow: none;
    padding-left: 0;
}
.input-group-addon, .input-group-btn, .input-group .form-control {
    display: table-cell;
}
.input-group .form-control {
    position: relative;
    z-index: 2;
    float: left;
    width: 100%;
    margin-bottom: 0;
}
.form-control, .form-group .form-control {
    border: 1px solid #eee;
    background-size: 0 2px, 100% 1px;
    background-repeat: no-repeat;
    background-position: center bottom,center calc(100% - 1px);
    background-color: transparent;
    transition: background 0s ease-out;
    float: none;
    box-shadow: none;
    border-radius: 0;
    font-weight: 400;
}
.form-control {
    height: 36px;
    padding: 7px 0;
    font-size: 17px;
    line-height: 1.428571429;
    color: #333;
    border: 1px solid #eee;
}
/*button, input, select, a {
    outline: none !important;
}
input {
    -webkit-appearance: textfield;
    -webkit-rtl-ordering: logical;
    user-select: text;
    cursor: auto;
   
}
input, textarea, select, button {
    text-rendering: auto;
    letter-spacing: normal;
    word-spacing: normal;
    text-transform: none;
    text-indent: 0px;
    text-shadow: none;
   
    text-align: start;
    margin: 0em;
   
}
input, textarea, select, button, meter, progress {
    -webkit-writing-mode: horizontal-tb;
}*/
</style>

@section('content')
<div class="box box-default" style="border-top: none;">
	<form action="{{url('/manpower/view/central')}}" method="post">
	{{ csrf_field() }}
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
          <span class="pull-right" style="margin-right: 30px;">
          	 <div style="float: left;">
          	 	
          	 </div>
          </span>
        </form>
        
    </div>

    <div style="margin: 10px 20px;">
    	<div align="center">
        <h3><b>{{strtoupper('JIPPIS')}}</b></h3>
       
      </div>
    	<span class="pull-right" style="margin-right: 30px;">Printed On: {{date('D M, Y')}} &nbsp; | &nbsp; Time: {{date('h:i:s A')}}</span>
    
      <br />
    @if(session('err'))
  		<div class="col-sm-12 alert alert-warning alert-dismissible hidden-print" role="alert">
  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
  		</button>
  		<strong>Error!</strong> 
  		{{ session('err') }} 
  		</div>                        
	 @endif

	</div>

	<div class="box-body">
  <div class="row hidden-print">
   <div class="col-md-12" style="margin-bottom: 30px;">
    <div class="form-group">
    <form method="post" action="{{url('/estab/listStaff')}}">
     {{ csrf_field() }}
       <div class="col-md-6" style="padding-right: 0px;">
      
       <input type="text" name="q" id="autocomplete" class="form-control">
        <input type="hidden" id="nameID"  name="nameID">
        </div>
        <div class="col-md-1" style="padding-left: 0px;">
        <input type="submit" name="submit" value="Search" class="btn btn-default" style="border-radius: 0px">
        </div>
    </form>
    </div>
   </div>
  </div>
  <div></div>
		<div class="row">
			{{ csrf_field() }}

			<div class="col-md-12">
				<table class="table table-striped table-condensed table-bordered input-sm" id="allstaff">
					<thead>
          <tr class="input-sm">
  						<th>S/N</th>
  						<th width="250" class="">FULL NAME</th>
  						<th>DATE OF BIRTH</th>
  						<th>SEX</th>
              <th>MARITAL STATUS</th>
              <th>L.G.A OF ORIGIN</th>
              <th>STATE OF ORIGIN</th>
              <th>DATE OF FIRST <BR /> APPOINTMENT</th>
              <th>RANK</th> 
              <th>DATE OF PRESENT <BR /> APPOINTMENT</th>
              <th>DIVISION</th>
              <th>FILE NO</th>
              
              <th class="hidden-print">Upgrading</th>
              <th class="hidden-print">Conversion/<br/>Advancement</th>
              <!--<th class="hidden-print" style="width: 80%">Confirm</th>-->
              </tr>
					</thead>
					<tbody>
						@php $key = 1; @endphp
            @foreach($staffList as $list)
  						<tr>
                
                  <td>{{($staffList->currentpage()-1) * $staffList->perpage() + $key++}}</td> 

                  <td>{{strtoupper($list->surname .' '. $list->first_name .' '. $list->othernames)}}</td> 
                  <td width="90">{{$list->dob}}</td>
                  <td>
                    @php 
                        if(strtoupper(($list->gender == "MALE")))
                        {
                          $sex = 'M';
                        }else if(strtoupper(($list->gender == "FEMALE")))
                        {
                          $sex = 'F';
                        }else
                        {
                          $sex = '';
                        }
                    @endphp
                    {{$sex}}
                  </td> 
                  <td>{{$list->maritalstatus}}</td>
                  <td></td> 
                  <td></td>
                  <td>{{$list->appointment_date}}</td>  

                  <td>{{$list->section .' '. 'GL'.$list->grade .'|'.'S'.$list->step}}</td> 
                  <td>{{$list->firstarrival_date}}</td> 
                  <td>{{strtoupper($list->division)}}</td> 
                  <td>{{'JIPPIS/P/'.$list->fileNo}}</td> 

                   
                  <td class="hidden-print">
                  <span>
                  <a href="{{url('/admin/upgrading/'.$list->fileNo)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye text-enter"></i></a>
                  
                  <a href="javascript:void" style=" margin-right: auto;margin-left: 5px;" class="btn btn-success btn-xs edit" id="{{$list->fileNo}}"><i class="fa fa-edit"></i></a>
                  </span>
                  <br/>
                  <br/>
                  
                  <span>
                  @php
                     if($list->promotion_alert ==1)
                    {
                      $value = "Revert";
                    }
                    else
                    {
                      $value = "Confirm";
                    }
                    @endphp
                  <a href="javascript:void" id="{{$list->fileNo}}" class="confirm" value = "upgrade">{{$value}}</a>
                </span>
                  </td>
                  
                  <td class="hidden-print">
                    <span>
                  <a href="{{url('/estab/staff/profile/'.$list->fileNo)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye text-enter"></i></a>
                  
                  <a href="javascript:void" style="margin-left: 5px;" class="btn btn-success btn-xs advance" id="{{$list->fileNo}}"><i class="fa fa-edit"></i></a>
                  </span>
                  <br/><br/>
                  <span>
                    @php
                     if($list->promotion_alert ==1)
                    {
                      $value = "Revert";
                    }
                    else
                    {
                      $value = "Confirm";
                    }
                    @endphp
                  <a href="javascript:void" id="{{$list->fileNo}}" class="confirm" value ="convert">{{$value}}</a>

                  </span>

                  </td>

                  <!--<td>
                  @php
                     if($list->promotion_alert ==1)
                    {
                      $value = "Revert";
                    }
                    else
                    {
                      $value = "Confirm";
                    }
                    @endphp
                  <a href="javascript:void" id="{{$list->fileNo}}" class="confirm">{{$value}}</a>

                  </td>-->

              </tr> 
            @endforeach
					</tbody>
				</table>

        <div align="right">
         
        </div>

				<div class="hidden-print">{{ $staffList->links() }}</div>
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

<!-- Bootsrap Modal for Upgrading-->

<form method="post" action="">
{{ csrf_field() }}
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Upgrading Details Update</h4>
                <p id="msg"></p>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <label>Post for Consideration</label>
                <input type="text" name="postConsidered" class="form-control postcon" placeholder="Type it here" >
            </div>

            <div class="form-group">
                <label>Additional Qualification</label>
                <input type="text" name="additionalQualification" class="form-control addquali" placeholder="Type it here" >
            </div>

            <div class="form-group">
                <label>New Grade Level</label>
                  <select name="newGrade" class="form-control grade" >
                  <option value="">Select New Grade</option>
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
                <input type="hidden" name="fileNo" class="form-control file-number" placeholder="Type it here" >
            </div>

               <div class="form-group">
                <label>New Step</label>
                  <select name="newStep" class="form-control step" >
                  <option value="">Select New Grade</option>
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
                <input type="hidden" name="fileNo" class="form-control file-number" placeholder="Type it here" >
            </div>

            <div class="form-group">
                <label>Recommendation (You should Edit as required)</label>
                <textarea name="recommendation" class="form-control rec" style="padding: 0px; height: 100px; text-align: left;">
                  {{strtoupper($list->surname .' '. $list->first_name .' '. $list->othernames)}} Was appointed to the post of confidential secretary II GL. 06 with effect from 6 November 2006. She has since served in this capacity in the office of the Deputy Chief Registrar in the Lagos office. He/She presented an advanced Diploma in secretarial Administration (60/120 w. p. m) obtained from the University Technology, Akure, which qualifies her for upgrading to the post of Confidential Secretary II on salary Grade Level 07. The officer is hard working, honest, reliable and of good and satisfactory conduct. 
            She is highly recommended for upgrading to the post of Confidential Secretary II GL. 07. There is vacancy for the post in the 2008 manpower establishment.

                </textarea>
            </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update">Save changes</button>
            </div>
        </div>
    </div>
</div>
</form>

<!-- //// Bootsrap Modal for upgrading-->


<!-- Bootsrap Modal for Conversion and Advancemnet-->

<form method="post" action="">
{{ csrf_field() }}
<div id="advModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Candidate Due For Conversion/Advancement</h4>
                <p id="message"></p>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <label>Post for Consideration</label>
                <input type="text" name="postConsidered" id="postcon" class="form-control"  >
            </div>

            <div class="form-group">
                <label>Type</label>
                <select name="type" id="type" id='grade' class="form-control grade" >
                  <option value="">Select Brief Type</option>
                  <option value="Conversion">Conversion</option>
                  <option value="Advancement">Advancement</option>
                </select>
            </div>

            <div class="form-group">
                <label>New Grade Level</label>
                  <select name="newGrade" id="newGrade" class="form-control grade" >
                  <option value="">Select New Grade</option>
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
                <input type="hidden" name="fileNo" id="fileNo" class="form-control file-number" >
            </div>

            <div class="form-group">
                <label>New Step</label>
                  <select name="newStep" id="newStep" class="form-control grade" >
                  <option value="">Select New Step</option>
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
                <input type="hidden" name="fileNo" id="fileNo" class="form-control file-number" >
            </div>

            <div class="form-group">
                <label>Effective Date</label>
                <input type="text" name="effectiveDate" id="effectiveDate" class="form-control effectiveDate" >

            </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary adv" id="adv">Save changes</button>
            </div>
        </div>
    </div>
</div>
</form>

<!-- //// Bootsrap Modal for Conversion and Advancemnet-->


@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
      $("#autocomplete_central").autocomplete({
        serviceUrl: murl + '/map-power/staff/search/json',
        minLength: 10,
        onSelect: function (suggestion) {
            $('#fileNo').val(suggestion.data);
            showAll();
        }
      });
  });

  $("#searchDate").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd MM, yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('yy-mm-d', theDate);
       $('#fileNo').val($.datepicker.formatDate('yy-m-d', theDate));
    },
  });

  $(document).ready(function(){
  
    $("table tr td .edit").click(function(){
      var fileNo = $(this).attr('id');
        $("#myModal").modal('show');
        $(".file-number").val(fileNo);
    });
});


   $(document).ready(function(){
  
    $("table tr td .advance").click(function(){
      var fileNo = $(this).attr('id');
        $("#advModal").modal('show');
        $(".file-number").val(fileNo);
        $("#fileNo").val(fileNo);
    });

    $(document).on('hidden.bs.modal', '.modal', function () {
  var modalData = $(this).data('bs.modal');
  
  // Destroy modal if has remote source – don't want to destroy modals with static content.
  if (modalData && modalData.options.remote) {
    // Destroy component. Next time new component is created and loads fresh content
    $(this).removeData('bs.modal');
    // Also clear loaded content, otherwise it would flash before new one is loaded.
    $(this).find(".modal-content").empty();
  }
});
});


</script>

<script type="text/javascript">
  $( function() {

  $("#update").on('click', function(){

 var fileNo = $('.file-number').val();
 var quali = $('.addquali').val();
 var postcon = $('.postcon').val();
 var rec = $('.rec').val();
 var grade = $('.grade').val();
 var step = $('.step').val();

 if(grade == '')
 {
  $('#msg').html('<div class="alert alert-danger alert-dismissible" role="alert"><strong>Please, Enter New Grade</strong> </div> ');

 }
 else if(quali == '')
  {
  $('#msg').html('<div class="alert alert-danger alert-dismissible" role="alert"><strong>Please, Enter the Additional Qualification</strong> </div> ');
  }
  else if(postcon == '')
  {
  $('#msg').html('<div class="alert alert-danger alert-dismissible" role="alert"><strong>Please, Enter the Post Considered</strong> </div> ');
  }
  else if(rec == '')
  {
  $('#msg').html('<div class="alert alert-danger alert-dismissible" role="alert"><strong>Please, Type in the Recommendation</strong> </div> ');
  }
else
{
//$('#msg').html(fileNo);
 $token = $("input[name='_token']").val();
 $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/estab/upgrading/update') }}",

  type: "post",
  data: {'fileNo': fileNo,'qualification': quali,'position': postcon,'recommendation': rec,'grade': grade,'step':step},
  success: function(data){
    
    $('#msg').html(data);
    
    location.reload(true);
  }
});

 
}

});
});

</script>



<script type="text/javascript">
  $( function() {

  $(".adv").on('click', function(){

 var fileNo            = $('.file-number').val();
 var type              = $('#type').val();
 var postcon           = $('#postcon').val();
 var effectiveDate     = $('#effectiveDate').val();
 var grade             = $('#newGrade').val();
 var step              = $('#newStep').val();
 //$('#msg').html(fileNo);
 //alert(fileNo);

  $('#advModal').removeData('bs.modal');
 if(grade == '')
 {
  $('#message').html('<div class="alert alert-danger alert-dismissible" role="alert"><strong>Please, Enter New Grade</strong> </div> ');

 }
 else if(type == '')
  {
  $('#message').html('<div class="alert alert-danger alert-dismissible" role="alert"><strong>Please, Choose the whether it is Conversion or Advancement</strong> </div> ');
  }
  else if(postcon == '')
  {
  $('#message').html('<div class="alert alert-danger alert-dismissible" role="alert"><strong>Please, Enter the Post Considered</strong> </div> ');
  }
  else if(effectiveDate == '')
  {
  $('#message').html('<div class="alert alert-danger alert-dismissible" role="alert"><strong>Please, Type in the Recommendation</strong> </div>');
  }
else
{
//$('#msg').html(fileNo);
 $token = $("input[name='_token']").val();
 $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/estab/con-adv/save') }}",

  type: "post",
  data: {'fileNo': fileNo,'type': type,'position': postcon,'effdate': effectiveDate,'grade': grade,'step':step},
  success: function(data){
    
    $('#message').html(data);
  location.reload(true);
  }
});

}

});
});

</script>




<script type="text/javascript">
  $(function() {
    $("#autocomplete").autocomplete({
      serviceUrl: murl + '/profile/searchUser',
      minLength: 2,
      onSelect: function (suggestion) {

$('#nameID').val(suggestion.data);

showAll();


$.ajax({

    type: 'post',
    url: murl +'/estab/listStaff',
    data: {'nameID': $('#nameID').val(), '_token': $('input[name=_token]').val()},

    success: function(datas){
    $.each(datas, function(index, obj){
    
    });
}

});


}
});
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
  
$("table tr td .confirm").on('click',function(){
  //alert("ok");
 //var id=$(this).parent().parent().find("input:eq(0)").val();
  var id = $(this).attr('id');
  //alert(id);
   var value = $(this).attr('value');
   alert(value);
  
   

});
 });
</script>


@stop

@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@stop







