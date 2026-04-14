@extends('layouts.layout')
@section('pageTitle')
Create Procurements
@endsection



@section('content')

<div id="editModal" class="modal fade">
        <div class="modal-dialog " role="document">
          <div class="modal-content ">
            <div class="modal-header">
              <h4 class="modal-title">Edit Record</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="editpartModal" name="editpartModal"
                    role="form" method="POST" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class=" control-label">File No:</label>
                    </div>
                    <div class="col-sm-12">
                            <input type="text" value="" name="file_no" id="file_no" readonly class="form-control" >
                    </div>
                    <div class="col-sm-12">
                    <label class=" control-label">Contract Type</label>
                    </div>
                    <div class="col-sm-12">
                            <select name="contr_type" id="contr_type"  class="form-control" >
                                @foreach($contractlist as $list)
                                <option value="{{$list->ID}}">{{$list->contractType}}</option>
                                @endforeach
                            </select>
                    </div><div class="col-sm-12">
                    <label class="control-label">Contract Description</label>
                    </div>

                    <div class="col-sm-12">
                            <textarea  name="contr_desc" id="contr_desc"  class="form-control" > </textarea>
                    </div>
                    <div class="col-sm-12">
                    <label class="control-label">Contract Values</label>
                    </div>

                    <div class="col-sm-12">
                            <input type="text" value="" name="contr_val" id="contr_val" placeholder=""  class="form-control" >
                    </div>
                    <div class="col-sm-12">
                    <label class="control-label"> Company </label>
                    </div>

                    <div class="col-sm-12">
                            <select name="company" id="company"  class="form-control" >
                                <option value=""></option>
                                @foreach($companyDetails as $list)
                                <option value="{{$list->id}}">{{$list->contractor}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-sm-12">
                    <label class="control-label">Date Awarded</label>
                    </div>

                    <div class="col-sm-12">
                            <input type="text" value="" name="dateawd" id="dateawd" autocomplete="off"  class="form-control" >
                    </div>
                    <div class="col-sm-12">
                    <label class="control-label">Upload project file</label>
                    </div>

                    <div class="col-sm-12">
                            <input type="file" value="" name="filex" id="dateawd" autocomplete="off"  class="form-control" >
                    </div>
                    <div class="col-sm-12">
                    <label class=" control-label">Created By</label>
                    </div>

                    <div class="col-sm-12">
                            <input type="text" value="{{$currentuser}}" name="creatdby" id="creatdby" readonly="" class="form-control" >
                    </div>
                    <input type="hidden" id="edit-hidden" name="edit-hidden" value="">
                </div>

            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

                </form>
            </div>

          </div>
        </div>


         <!--reason modal-->
         <div id="reasonModal" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Reason for rejection</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal"
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="control-label"><i id="msg-reason"></i></label>
                    </div>
                </div>
            </div>
            </form>
                <div class="modal-footer">
                    <!--<button type="Submit" class="btn btn-success" id="putedit"></button>-->
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>


            </div>

          </div>
        </div>
        <!--end of reason-->

        <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Variable</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal"
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-9 control-label"><b>Are you sure you want to delete this record?</b></label>
                    </div>
                    <input type="hidden" id="deleteid" name="deleteid" value="">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>

                </form>
            </div>

          </div>
        </div>

        <div id="RestoreModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Restore Variable</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal"
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-9 control-label"><b>Are you sure you want to restore this record?</b></label>
                    </div>
                    <input type="hidden" id="restoreid" name="restoreid" value="">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>

                </form>
            </div>

          </div>
        </div>


<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
    </div>

    <div class="col-md-12">
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
                @if ($error != "")
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                            <p>{{ $error }}</p>
                    </div>
                @endif
                @if ($success != "")
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                        {{ $success }}</div>
                @endif
                @if(session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                        {{ session('err') }}</div>
                @endif
            </div>


    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col-->
          @include('Share.message')

        <form class="form-horizontal" id="form1" role="form" method="post" action="" enctype="multipart/form-data">
        {{ csrf_field() }}

            <div class="col-md-12"><!--2nd col-->
            <!-- /.row -->
            <div class="form-group">

                <div class="col-md-3">
                    <label class="control-label">Claim No:</label>
                    <input extarea required class="form-control" id="fileno" placeholder="e.g FHC/XXXX"  name="fileno" value="{{old('fileno')}}" >
                </div>

                <div class="col-md-3">
                    <label class="control-label">Account Head</label>
                    <select required class="form-control" id="contracttype"  name="contracttype">
                        <option value="">Select Contract</option>
                        @foreach($contractlist as $list)
                            <option value="{{$list->ID}}" {{(old('contracttype') == $list->ID) ? "selected" : ""}}>{{$list->contractType}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="control-label">Description</label>
                    <textarea required class="form-control" id="contract-desc"  name="contract-desc">{{old('contract-desc')}}</textarea>
                </div>

                <div class="col-md-3">
                    <label class="control-label">Claim Value</label>
                    <input required class="form-control" id="contractvalue" value="{{ (old('contractvalue')) ? $contractvalue : ""}}" placeholder="e.g. N100000" type="text" name="contractvalue">
                    <!--<span class="form-control" ></span>-->
                </div>



            </div>
            </div>

            <div class="col-md-12"><!--2nd col-->
            <!-- /.row -->
            <div class="form-group">


                <div class="col-md-3">
                    <label class="control-label">Beneficiary</label>
                    <input required class="form-control" id="benef" value="{{ (old('benef')) ? $benef: ""}}" placeholder="e.g. XYZ and Others" type="text" name="benef">
                    <input type="hidden" value="13" id="companyid" name="companyid">
                </div>

                <div class="col-md-3">
                    <label class="control-label">Approved Date</label>
                    <?php if(old('date_awarded')!=''){$date_awarded=old('date_awarded'); }?>
                    <input required readonly class="form-control" id="todayDate" autocomplete="off" name="date_awarded" value="{{old('date_awarded')}}{{$date_awarded}}">
                </div>

                <div class="col-md-3">
                    <label class="control-label">Attach file</label>
                    <input class="form-control" type="file" id="file" autocomplete="off" name="filex" >
                </div>

                <div class="col-md-3">
                    <label class="control-label">Attention</label>
                   <select required  name="attension" class="form-control">
                  <option value="">Select</option>
                  <option value="DFA">DFA: Director, Finance and Account</option>
                  <option value="DDFA">DDFA: Deputy Director, Finance and Account</option>
                  <option value="CA">CA: Chief Accountant</option>


                        </select>
                    <input type="hidden" value="{{Auth::user()->username}}" id="createdby" name="createdby">
                </div>
            </div>
            </div>

            <div class="col-md-12"><!--2nd col-->
            <!-- /.row -->
            <div class="form-group">

                <div class="col-md-2">
                    <button class="form-control btn btn-success" name ="upadate">Submit</button>
                    <!-- <input required class="form-control" id="todayDate"  name="allocation"> -->
                </div>
            </div>
            </div>
          <!-- /.col -->
        </div>
        </form>
        <!-- /.row -->
        <div class="row">
        {{ csrf_field() }}


          <!-- /.col -->
            </div>


            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table id="res_tab" class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th>S/N</th>
                            <th>File No</th>
                            <th>Account Type</th>
                            <th>Description</th>
                            <th>Approved Value</th>
                            <th>Beneficiary</th>
                            <th>Created BY</th>
                            <th>Approved Status</th>
                            <th>Date Awarded</th>
                            <th>Approved Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @php $i = 1; @endphp
                    <tbody>

                    @foreach($procurementlist as $list)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $list->fileNo }}</td>
                            <td>{{ $list->contractType }}</td>
                            <td>{{ $list->ContractDescriptions }}</td>

                            <td> {{ number_format($list->contractValue ,2)}}</td>
                            <td>{{ $list->beneficiary}}</td>
                            <td>{{ $list->createdby }}</td>
                            <td>
                                @if($list->approvalStatus == 1)
                                <b><span class="text-success">Approved</span></b>
                                @elseif($list->approvalStatus == 2)
                                    <b><span class="text-warning">Rejected</span></b>
                                @else
                                    <b><span class="text-danger">Pending</span></b>
                                @endif
                            </td>
                            <td>{{ $list->dateAward }}</td>
                            <td>{{ $list->approvalDate }} </td>
                            <td>
                                @if($list->approvalStatus == 0)
                                <button onclick="return editfunc('{{ $list->ID }}', '{{$list->fileNo}}', '{{$list->contract_Type}}','{{$list->ContractDescriptions}}','{{ $list->contractValue }}','{{$list->companyID}}','{{ $list->dateAward }}')" class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button>
                                <button onclick="return deletefunc('{{ $list->ID }}')" class="btn btn-danger btn-xs" > <i class="fa fa-trash"></i> </button>
                                @elseif($list->approvalStatus == 2)
                                <button onclick="return editfunc('{{ $list->ID }}', '{{$list->fileNo}}', '{{$list->contract_Type}}','{{$list->ContractDescriptions}}','{{ $list->contractValue }}','{{$list->companyID}}','{{ $list->dateAward }}')" class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button>
                                <button class="btn btn-info btn-xs" onclick="return viewReason('{{$list->reason}}', '{{ $list->ID }}', '{{$list->fileNo}}', '{{$list->contract_Type}}','{{$list->ContractDescriptions}}','{{ $list->contractValue }}','{{$list->companyID}}','{{ $list->dateAward }}')">Reason</button>

                                @endif
                                @php
                                $path = base_path('../'). env('UPLOAD_PATH', '') .'/' . $list->ID.'.'.$list->file_ex;
                                //$source = '../' . env('UPLOAD_PATH', '') .'/' . $list->ID.'.docx';
                                @endphp

                                @if(file_exists($path))
                                	<a href="/pro/file/{{$list->ID.'.'.$list->file_ex}}" target="blank" class="btn btn-secondary btn-xs">Download File</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <input type="hidden" value="" id="co" name="court">
            <input type="hidden" value="" id="di" name="division">
            <input type="hidden" value="" name="status">
            <input type="hidden" value="" name="chosen" id="chosen">
            <input type="hidden" value="" id="type" name="type">

          <hr />
        </div>

  </div>
</div>



@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@stop

@section('styles')
<style type="text/css">
    .modal-dialog {
width:13cm
}

.modal-header {

background-color: #006600;

color:#FFF;

}

#partStatus{
    width:2.5cm
}

</style>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>
$('#res_tab').DataTable();

      $("#contractvalue").on('keyup', function(evt){

         //if (evt.which != 110){//not a fullstop
            //var n = parseFloat($(this).val().replace(/\,/g,''),10);

            x = $(this).val().replace(/[ ]*,[ ]*|[ ]+/g, '');
		$(this).val(x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))  ;
            //if(isNaN(n)){

            //}
            //else{
            //$(this).val(n.toLocaleString());
            //}
        //}

    });


</script>
@stop

