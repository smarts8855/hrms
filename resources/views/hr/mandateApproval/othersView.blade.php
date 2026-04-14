@extends('layouts.layout')



@section('content')
<div class="box-body" style="background:#FFF;">

    


  <div class="box-body">
        <div class="col-sm-12 hidden-print">
         <h2 class="text-center"></h2>
       <h3 class="text-center"> Mandate Checking/Approval</h3>

         <br /> 

        <!--search all vouchers-->
        <div class="row hidden-print">
            <div class="col-sm-6">

            </div>

          <div class="col-sm-6">
          
          </div>
        </div>
        <!--Search all vouchers-->

         <!-- 1st column -->
      
      
      <br />
      <div>
       
            
        <table id="myTable" class="table table-bordered" cellpadding="10">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Year</th>
              <th>Month</th>
              <th>View Remarks</th>
              <th>View Mandate</th>
              <th>Process</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            
           @if($mandate != '')
          <tr>
            
            <td>1</td>
            <td>{{$activemonth->year}}</td>
            <td class="text-right">{{$activemonth->month}}</td>
            <td width="30"><a href='{{url("/display/comments/$activemonth->year/$activemonth->month")}}' target="_blank" class="btn btn-success btn-xs" id="{{$activemonth->year}}" val="{{$activemonth->month}}">View Remarks</a></td>
            <td width="50"><a href='{{url("/mandate/$activemonth->year/$activemonth->month")}}' class="btn btn-success btn-xs" target="_blank">Preview</a> </td>
            <td width="50"><a href="javascript:void()" class="btn btn-success btn-xs pro" id="{{$activemonth->year}}" val="{{$activemonth->month}}">Process</a> </td>
            <td> @if($mandate->is_rejected == 1) This mandate was rejected <a href='{{url("/display/comments/$activemonth->year/$activemonth->month")}}' target="_blank" class="btn btn-success btn-xs reason"> View Minutes </a>  @endif</td>

          </tr>
          @else
          <tr>
              <td colspan="7" align="center"> No Mandate Available</td>
          </tr>
          @endif

        
            
          </tbody>
        </table>
                 
        </div>
        <br />
        
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>

    <!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!--///// end modal -->
    
    
    <!-- Modal HTML -->
    <form action="{{url('/mandate/view')}}" method="post">
        {{ csrf_field() }}
    <div id="approveModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    
            <input type="hidden" name="year" value="{{$activemonth->year}}"/>
            <input type="hidden" name="month" value="{{$activemonth->month}}"/>
            
               
               
            <div class="form-group" style="margin-bottom:10px;">
                <div class="col-sm-122">
                    <label class="control-label"><b>Enter Remarks</b></label>
                </div>
                <div class="col-sm-122">
                    <textarea  name="instruction" id="instruction"  class="form-control" placeholder="e.g Pay a sum amount of XXXXX" > </textarea>
                </div>
                <div class="col-sm-122">
                    <label class="control-label"><b>Refer to</b></label>
                </div>
                <div class="col-sm-122">
                    <select required  name="attension" class="form-control">
                        <option value="">Select</option>
                        @if($codes != '')
                        @foreach($codes as $list)
                        <option value="{{$list->code }}">{{$list->description }}</option>
                        @endforeach
                        <option value="SA">Salary</option>
                        <option value="FA">Final Approval</option>
                        @endif
                    </select>
                </div>

            </div>
            
          
            <div class="clearfix"></div>
           
                <div class="modal-footer">
            <input type="submit" name="submit" value="Check & Clear" class="btn btn-success pull-right hidden-print" style="margin-left:10px;">
            <input type="submit" name="submit" value="Reject" class="btn btn-danger pull-right hidden-print" style="margin-left:20px;">
         
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                   

                </div>
            </div>
        </div>
    </div>
    </form>
    <!--///// end modal -->

</div>
  @endsection

  @section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">

  <style type="text/css">
    .status
    {
      font-size: 15px;
      padding: 0px;
      height: 100%;
     
    }

    .textbox { 
    border: 1px;
    background-color: #66FFBA; 
    outline:0; 
    height:25px; 
    width: 275px; 
  } 

  .autocomplete-suggestions{
    color:#66FFBA;
    height:125px; 
  }
    .table,tr,td{
        border: #9f9f9f solid 1px !important;
        font-size: 12px !important;
    }
     .table thead tr th
     {
      font-weight: 700;
      font-size: 17px;
      border: #9f9f9f solid 1px 
     }
  </style>
  @endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $(".com").click(function(){
                $("#myModal").modal('show');
            });
        });
        
        
        
        $(document).ready(function(){
            
         $(".pro").click(function(){
           $("#approveModal").modal('show');
            var id =    $(this).attr('val');
            var batch =    $(this).attr('id');
            //alert(batch);
            $('#tid').val(id);
            $('#batch').val(batch);
             
            });
           
        });
        
        $(document).ready(function(){
            
         $(".reason").click(function(){
           
            var id =    $(this).attr('val');
            var batch =    $(this).attr('id');
            
            $.ajax({
           // headers: {'X-CSRF-TOKEN': $token},
            url: "{{ url('/rejection/reason') }}",
            
            type: "post",
            data: {'batch':batch,'_token': $('input[name=_token]').val()},
            success: function(data){
            //location.reload(true);
            console.log(data.comment);
            $('#reason').html(data.comment);
            }
            });

            
            $("#rejectModal").modal('show');
             
            });
           
        });
    </script>
@endsection
