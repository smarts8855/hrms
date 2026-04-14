@extends('layouts.layout')

@section('pageTitle')
    Generated Payment
@endsection

@section('content')

    <div class="box-body box-default" style="background:#FFF;">

        <div class="box-body hidden-print">
            <div class="row">
                <div class="col-sm-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong> <br />
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if(session('msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> <br />
                            {{ session('msg') }}
                        </div>
                    @endif

                    @if(session('err'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Operation Error !</strong> <br />
                            {{ session('err') }}
                        </div>
                    @endif
                </div>
            </div><!-- /row -->
        </div><!-- /div -->


        <div class="box-body">
            <div class="col-sm-12 hidden-print">
                <h2 class="text-center"></h2>
                <h3 class="text-center">Generated Payment</h3>

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
                    <form action="{{url('/es/mandates')}}" method="post">
                        {{ csrf_field() }}
                        <table id="myTable" class="table table-bordered table-striped table-highlight dataTable no-footer" cellpadding="10">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>BATCH</th>
                                <th class="text-center">TOTAL AMOUNT ( &#8358;)</th>
                                <th>VIEW REMARK</th>
                                <th>PREVIEW</th>
                                <th>PROCCESS</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $key = 1; @endphp
                            @if($vouchers != '')
                           
                            @foreach($vouchers as $list)
                                <tr>
                                    <input type="hidden" name="id[]" checked value="{{$list->TID}}"/>
                                    <input type="hidden" name="batch" value="{{$list->batch}}"/>

                                    <td>{{$key++}}</td>
                                    <td>{{$list->adjusted_batch}}</td>
                                    <td class="text-center">{{number_format($list->totalPayment,2)}}</td>
                                    <td width="30"><a href="{{url('/display/comments/'.$list->batch)}}" target="_blank" class="btn btn-success btn-xs" id="{{$list->batch}}" val="{{$list->TID}}">View Remarks</a></td>
                                    <td width="50"><a href="{{url('/view/batch/'.$list->batch)}}" class="btn btn-success btn-xs" >Preview</a> </td>
                                    <td width="50"><a href="javascript:void()" class="btn btn-success btn-xs pro" id="{{$list->batch}}" val="{{$list->TID}}">Process</a> </td>

                                </tr>

                            @endforeach
                            @else
                            
                                <tr>
                                    <td colspan="6" class="text-center"> No Mandate Available !</td>
                                </tr>
                            
                            @endif
                            

                            </tbody>
                        </table>
                        
                    </form>
                    <!--<div><a href="{{ url()->previous() }}" class="hidden-print btn btn-success">Back</a></div>->
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
    <form action="{{url('/es/mandate')}}" method="post">
        {{ csrf_field() }}
    <div id="approveModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    
            <input type="hidden" name="id" id="tid" value=""/>
            <input type="hidden" name="batch" id="batch" value=""/>
            
                        <div class="form-group" style="margin-bottom:10px;">
                            <div class="col-sm-122">
                                <label class="control-label"><b>Enter Remarks</b></label>
                            </div>
                            <div class="col-sm-122">
                                <textarea  name="instruction" id="instruction"  class="form-control" placeholder="e.g Pay a sum amount of XXXXX" > </textarea>
                            </div>


                        </div>
                       

                        <div class="clearfix"></div>

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
                                    <option value="FA">Final Approval</option>
                                   @endif

                                </select>
                            </div>
                        
                        <input type="submit" name="submit" value="Reject" class="btn btn-danger pull-right hidden-print" style="margin-top:10px;margin-left:20px;">
                        <input type="submit" name="submit" value="Approve" class="btn btn-success pull-right hidden-print" style="margin-top:10px;">
                          
                </div>
                <div class="modal-footer">
                  

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
    </script>
@endsection

