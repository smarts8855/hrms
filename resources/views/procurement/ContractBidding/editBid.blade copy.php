@extends('layouts_procurement.app')
@section('pageTitle', 'Edit Bid')
@section('pageMenu', 'active')
@section('content')

   <div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                
                 @if (count($errors) > 0)
	                <div class="alert alert-danger alert-dismissible" role="alert">
		              	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		              		<span aria-hidden="true">&times;</span>
		                </button>
		                <strong>Error!</strong> 
		                @foreach ($errors->all() as $error)
		                    <p>{{ $error }}</p>
		                @endforeach
	                </div>
                @endif                        
                @if(session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
              			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
                        </button>
                        <strong></strong> <br />
                    	{{ session('msg') }}</div>                        
                @endif
                @if(session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
              			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                    	{{ session('err') }}</div>                        
                @endif
                
                <h4 class="card-title"></h4>
                <p class="card-title-desc"></p>
                <form method="post" action="{{url('/bidding-update')}}" class="needs-validation" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="validationCustom01">Contract </label>
                                 <select class="form-control" name="contract">
                                     <option value="">Select</option>
                                   @foreach($contract as $list)
                                   
                                   <option value="{{$list->contract_detailsID}}" @if($edit->contract_detailsID == $list->contract_detailsID) selected @endif>{{$list->contract_name}}</option>
                                   @endforeach
                               </select>
                               <input type="hidden" name="bidID" value="{{$biddingID}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Contractor</label>
                               <select class="form-control" name="contractor">
                                    <option value="">Select</option>
                                   @foreach($contractor as $list)
                                   <option value="{{$list->contractor_registrationID}}" @if($edit->contractorID ==$list->contractor_registrationID) selected @endif>{{$list->company_name}}</option>
                                   @endforeach
                               </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Contractor Remark</label>
                                <textarea class="form-control" name="contractorRemark">{{$edit->contractor_remark}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Bidding Amount</label>
                                <input type="text" name="biddingAmount" class="form-control" id="biddingAmount" placeholder="Bidding Amount" value="{{number_format($edit->bidding_amount,2)}}">
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Date Submitted</label>
                                <input type="date" name="date" data-parsley-type="date"  class="form-control" id="" placeholder="Date" max="{{date('Y-m-d')}}" value="{{$edit->date_submitted}}">
                                
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Status</label>
                               <select class="form-control" name="status">
                                    <option value="">Select</option>
                                   <option value="1" @if($edit->bidStatus == 1) selected @endif>Active</option>
                                   <option value="2" @if($edit->bidStatus == 2) selected @endif>Disabled</option>
                               </select>
                            </div>
                        </div>
                        
                        
                   
                    
                    <!-- Documents Table -->
            
            <div class="card-body">
                <h3 class="card-title">Bidding Documents</h3>
                <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Document Description</th>
                        <th>Date Uploaded</th>
                        <th width="50">Preview</th>
                        <td width="10">Delete</td>
                    </tr>
                    </thead>

                    @php
                    $n=1;
                    @endphp
                    <tbody>
                        @foreach($viewDocuments as $list)
                    <tr>
                        <td>{{$n++}}</td>
                        <td>{{$list->file_description}}</td>
                        <td>{{date("jS M, Y", strtotime($list->created_at))}}</td>
                        <td><a href="{{asset('/BiddingDocument/'.$list->file_name)}}" target="_blank" class="btn btn-success btn-sm float-right">preview</a></td>
                        <td><a href="{{url('/delete-bidding/doc/'.$list->contractor_bidding_documentID)}}" onclick="return confirmDelete();" class="text-danger float-right" title="" data-original-title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a</td>
                        
                    </tr>
                    @endforeach
                    
                    </tbody>
                </table>
            </div>
            
             
                <div class="col-md-12" id="inputWrap">
                            
                            
                        </div>
                        <div class="clearfix"></div>
                       
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="border-bottom:1px solid #eee; padding-bottom:10px;">
                        <div class="col-md-1">
                        <button id="add" type="button" class="btn-sm btn btn-circle btn-info align-right"><i class="fa fa-plus"></i></button>
                        </div>
                        </div>
                        <hr>
                        <div class="col-md-12" style="padding-top:10px;">
                        <div class="float-right col-md-1">
                        <button class="btn btn-primary btn-sm" type="submit">Update</button>
                        </div>
                        </div>
                    </div>    
                    
            <!--// End Document Table -->
                </form>
            </div>
            
            <div class="row">
            <div class="col-md-12" style="margin-top:30px">
            <a href="{{url('/add-bidding')}}"  class="btn btn-success btn-sm col-md-2">Add New Bid</a> <a href="{{url('/view-bidding')}}" class="btn btn-success btn-sm col-md-2">View All Bids</a>
            </div>
            <div class="clearfix"></div>
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
   </div>
@endsection

@section('styles')
<style>
    .remove, .delete
    {
        margin-top:30px;
        padding-top:5px !important;
        padding-bottom:0px !important;
        
        margin-bottom:0px;
    }
    .fa-times
    {
        font-size:30px;
        cursor: pointer;
    }
</style>
@endsection


@section('scripts')

<script>
    $(document).ready(function () {
$("#biddingAmount").on('keyup', function(evt){
    //if (evt.which != 110 ){//not a fullstop
        //var n = parseFloat($(this).val().replace(/\,/g,''),10);

         $(this).val(function (index, value) {
        return  value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        //$(this).val(n.toLocaleString());
    //}
});
});
</script>

<script>
 $(document).ready(function() {
     $(document).on('click', '.bn', function(){
 //alert(0);
 $('.wraps').last().remove(); 
  var id = this.id;
  var deleteindex = id[1];

  // Remove <div> with id
  $("#" + deleteindex).remove();

 }); 
});

</script>

<script>
    $(document).ready(function() {
  $('#add').click(function() {
   var total_element = $(".wraps").length;
   var lastid = $(".wraps:last").attr("id");
   //var split_id = lastid.split('_');
  var n = Number(lastid) + 1;
  //alert(nextindex);
    $('#inputWrap').append(
        `<div class="wraps" id="'+n+'">
        <div class="row">
        <div class="col-md-12">
        <a class="delete bn remove_bank_field_btn pull-right align-right" href="javascript::void()">Remove</a>
        </div>
        <div class="col-md-6">
        <div class="form-group dynFile">
            <label for="">Document</label>
            <input type="file" name="document[]" class="form-control" id=''>
        </div>  
        </div>
        <div class="col-md-6">
        <div class="form-group dynInput">
            <label for="">Document Description</label>
            <input type="text" name="description[]" class="form-control" id='' >
        </div>  
        </div>
        
        </div>
        </div>`
        );
  });
  //end click function
  
  $('.delete').last().click (function () { 
						$('.wraps').last().remove();    
					}); 
 
});
</script>

<script>
    function confirmDelete()
    {
        $val = confirm('Do you actually want to delete');
        if($val)
        {
            return true
        }
        else
        {
            return false;
        }
    }
</script>



@endsection
