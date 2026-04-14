@extends('layouts.layout')
@section('pageTitle')
    <strong>Training Type Creation</strong>
@endsection

@section('content')

   <div class="box box-default">
        <div class="box-header with-border hidden-print">
        <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>



        <div class="box-body">
            <div>
            	@include('Share.message')
                <form  action="{{url('training-type')}}" method="POST">
                    {{ csrf_field() }}
                    <!--hidden field for updating record-->
                        <div style='padding : 10px 30px;'>
                            <div class='row'>
                                <div class='col-md-6'>
                        	        <div class="col-md-auto">
                                      <label class="">Training Type: </label>
                                    </div>
                                    <input type="text" class="form-control" name="training_type"/>
                        	    </div>
                                <div class='col-md-3' style='padding-top: 25px;'>
                                    <input type="submit" class="btn btn-success" name="btnSave" value='Create Training Type'>
                                </div>
                            </div>
                        </div>
                </form>

                    <div class="table-responsive" style="font-size: 12px; padding-left: 30px; padding-top: 16px; width: 80rem">
                        <div class= 'col-md-auto'>
                        <table id="mytable" class="table table-bordered table-striped table-highlight col-md-9" >
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    <th> S/N</th>
                                    <th>TRAINING TYPE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>

                            @forelse($getTraining as $key => $list)
                                <tr>
                                    <td class='col-md-auto'>{{ $key + 1}}</td>
                                    <td class='col-md-9 text-capitalize'>{{$list->type_name}}</td>
                                    <td class='col-md-auto'>
                                        <div class='btn-group' role="group">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal{{$list->id}}" >Edit</button>
                                            <a class="btn btn-danger" style="color:white; cursor: pointer;" onClick = "functionDelete('{{$list->id}}', '{{$list->type_name}}')">Delete</a>
                                        </div>
                                    </td>
                                </tr>

                                 {{-- <!--- {{url('/leave/delete/'.$list->id)}} EDIT MODAL--> --}}
                    <!-- POPUP Form  -->

                    <div class="modal fade" id="updateModal{{$list->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold fs-1">Edit Training Type</h5>
                                 </div>
                                <form method="post" action="{{ url('/update-training-type') }}" role="form">
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                        <input type="hidden" value="{{ $list->id}}" name='typeID'/>
                                        <div class="ml-3 my-3">
                                        <div class='row'>
                                            <div class="col-md-9" style='margin-left: 16px;'>
                                            <label class="col-form-label">Training Type: </label>
	                                   	    <input type="text" class="form-control" name="new_training_type" id="new_training_type" value="{{ $list->type_name }}" required/>
		                               </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
    		                                <button type="submit" class="btn btn-primary mb-2">Save changes</button>

    		                            </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!--//end MOdal-->
                            @empty
                                <tr>
                                    <td colspan="4" align="center">No Record Found!</td>
                                </tr>

                            @endforelse
                        </table>
                        </div>
                    </div>

            </div>



       </div>
   </div>
@endsection

@section('scripts')

<!--<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>-->
<!--<script src="{{ asset('assets/js/demo.js') }}"></script>-->
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type="text/javascript">

    $('#input-tags2').selectize({
plugins: ['restore_on_backspace'],
delimiter: ',',
persist: false,
create: function(input) {
   return {
       value: input,
       text: input
   }
}
});



 function myFunction(val){

     alert(val);

 }


</script>

<script>
function functionDelete(data1, data2){
    $.confirm({
title: 'Alert!',
content: `You are about to delete this Training Type, action will remove leave type ${data2}. Are you sure you want to proceed?`,
type: 'red',
typeAnimated: true,
buttons: {
   tryAgain: {
       text: 'Delete leave type',
       btnClass: 'btn-red',
       action: function(){
           var x = '{{url("/training-type/delete")}}'+"/"+ data1;
           window.location.href = x;
       }
   },
   close: function () {
   }
}
});
}

</script>

@endsection
