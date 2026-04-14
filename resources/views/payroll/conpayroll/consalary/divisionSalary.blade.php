@extends('layouts.layout')
@section('pageTitle')
Pay Slip
@endsection
@section('content')

  <div class="box-body" style="background:#FFF;">
    
    <br><br>
    <div class="table-responsive" style="font-size: 12px; padding:10px;">
        <table class="table table-bordered table-striped table-highlight" >
        <thead>
        <tr bgcolor="#c7c7c7">
                        <th width="1%">S/N</th>	
                        <th >Staff ID</th>
                        <th >Name</th>
                        <th >Grade</th>
                        <th >Employment Type</th>
                        <th >Court ID</th>
                         <th >Action</th>
                     </tr> 
        </thead>
                    @php $serialNum = 1; @endphp
        
                    @foreach ($salary as $b)
                        <tr>
                            <td>{{ $serialNum ++}} </td>
                            <td>{{$b->staffid}}</td>
                            <td>{{$b->name}}</td>
                            <td>{{$b->grade}}</td>
                            <td>{{$b->employment_type}}</td>
                            <td>{{$b->courtID}}</td>
                            <td><a href="javascript: DeletePromo('{{$b->ID}}')">View</a></td>	
                        </tr>
                    @endforeach
                    
         </table>
         <div class="pagination"> {{ $salary->links() }}</div>
        </div>
  </div><!-- /.col -->
</div><!-- /.row -->

<div class="box-body">
  <div class="row">
    <div class="col-md-12">
    </br>
  </div>
  @endsection
  @section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
  @endsection
  @section('scripts')
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
    (function () {
      $('#user').change( function(){
        
        var myuser = $('#user').val();
        document.getElementById('staffname').value=document.getElementById('id'+myuser).value;
        $('#fileNo').val(myuser);
      });}) ();
    </script>
   
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
