@extends('layouts.layout')

@section('pageTitle')
STAFF DOCUMENTATION
@endsection

@section('content')
<div class="box box-default">
<div class="box-body box-profile">
 <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
    </div>
    
        <div class="row">
            @php if($prog<17)
            {  
            @endphp
            @include('hr.documentation.inc.wizard')
            @php
            }
            @endphp
       
       
<form method="post" action="{{url('/start-documentationx')}}" id="form1">
    {{ csrf_field() }}
    <div class="noprint" style="display:none">
                   
                    <div class="col-md-10">
                    <input type="hidden"   value="{{$fileNo}}" id="fileNo" name="fileNo">
                    <label>Staff Name </label>
                    <input type="text" name="fullname"   class="form-control"  value="{{$StaffNames->surname}} {{$StaffNames->first_name}} {{$StaffNames->othernames}}" disabled>
             
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp&nbsp&nbsp</label>
                    <input type="submit" onclick="return ReloadForm()"   class="form-control btn btn-success"  value="Start Documentation">
                    </div>
    </div>
</form>
</div>

<div role="form">
    @if($prog == 6)
        @include('hr.documentation.inc.basicInfo')
    @elseif($prog == 7)
    	@include('hr.documentation.inc.contact')
    @elseif($prog == 8)
        @include('hr.documentation.inc.placeOfBirth')
    @elseif($prog == 9)
        @include('hr.documentation.inc.education')
    @elseif($prog == 10)
    	@include('hr.documentation.inc.marital')
    @elseif($prog == 11)
        @include('hr.documentation.inc.nextOfKin')
    @elseif($prog == 12)
        @include('hr.documentation.inc.children')
    @elseif($prog == 13)
        @include('hr.documentation.inc.previousEmployment')
     @elseif($prog == 14)
        @include('hr.documentation.inc.attachment')
    @elseif($prog == 15)
        @include('hr.documentation.inc.account')
    @elseif($prog == 16)
        @include('hr.documentation.inc.passportSignature')
    @elseif($prog == 17)
        @include('hr.documentation.inc.others')
    @elseif($prog == 18)
        @include('hr.documentation.inc.previewInfo')
    @elseif($prog == 19)
        @include('hr.documentation.inc.complete')
    @endif
</div><!--//Role-->
        
     </div>

</div>
 </div>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets-staff-documentation/wizard.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets-staff-documentation/checkmark.css')}}">


@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/assets-staff-documentation/functions.js')}}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
var myObject = new Vue({
  el: '#app',
  data: {message: 'Hello Vue!'}
})
</script>

<script>
  
    function givereason( id ){
			if(id === 'convict'){
				var ans = $('#'+id);
				if(ans.val() == 'yes'){
					document.getElementById('convict-reason').style.display = 'block';
				} else if(ans.val() == 'no'){
					document.getElementById('convict-reason').style.display = 'none';
				}
			} else if(id === 'illness'){
				var ans = $('#'+id);
				if(ans.val() == 'yes'){
					document.getElementById('illness-reason').style.display = 'block';
				} else if(ans.val() == 'no'){
					document.getElementById('illness-reason').style.display = 'none';
				}
				
			} else if(id === 'jugdement'){
				var ans = $('#'+id);
				if(ans.val() == 'yes'){
					document.getElementById('judgement-reason').style.display = 'block';
				} else if(ans.val() == 'no') {
					document.getElementById('judgement-reason').style.display = 'none';
				}
			}
	}

    $('#othersForm').submit(function() {
        if($('#agree').is(':unchecked'))
        {
            alert('You have not agreed to the terms.');
            event.preventDefault();
        }
        
});



    $(document).ready(function() {
		//alert('OK');
	var state = $('#states').val();
 	
      $token = $("input[name='_token']").val();
        $.ajax({
           headers: {'X-CSRF-TOKEN': $token},
            type: 'POST',
            url: murl + "/documentation-getLga",
            data: {'id': state},
            success: function(datas){
                $('#lga');
           //console.log(datas);
           $('#lga').append( '<option value="">Select One</option>' );
    $.each(datas, function(index, obj){
        $('#lga').append( '<option value="'+obj.lgaId+'">'+obj.lga+'</option>' );
        });
		
	    }

		});	
		
		
		
  $('#states').change(function(){
      var state = $(this).val();
      //alert(state);
      $token = $("input[name='_token']").val();
        $.ajax({
           headers: {'X-CSRF-TOKEN': $token},
            type: 'POST',
            url: murl + "/documentation-getLga",
            data: {'id': state},
            success: function(datas){
                $('#lga').empty();
           //console.log(datas);
           $('#lga').append( '<option value="">Select One</option>' );
    $.each(datas, function(index, obj){
        $('#lga').append( '<option value="'+obj.lgaId+'">'+obj.lga+'</option>' );
        });
		
	    }

		});

  });

});
function  StaffSearchReload()
{	
	var txv=document.getElementById('numvalue').value;
	var tx = txv.split(':');
	
	document.getElementById('staffID').value=tx[0];
	document.getElementById('fileNo').value=tx[1];
	
	document.forms["form1"].submit();
	return;
}
</script>
@endsection