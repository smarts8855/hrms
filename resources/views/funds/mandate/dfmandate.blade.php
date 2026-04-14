@extends('layouts.layout')

@section('pageTitle')
    Generated Payment
@endsection

@section('content')

    <div class="box-body">

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
                    <form action="{{url('/df/mandate')}}" method="post">
                        {{ csrf_field() }}
                        <table id="myTable" class="table table-bordered" cellpadding="10">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Beneficiary</th>
                                <th class="text-center">Amount ( &#8358;)</th>

                                <th>Description</th>

                                <th>Preview</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $key = 1; @endphp
                            @if(count($vouchers) > 0)
                            @if($action->code == $ddcomm->to_who)
                            @foreach($vouchers as $list)
                                <tr>
                                    <input type="hidden" name="id[]" checked value="{{$list->TID}}"/>
                                    <input type="hidden" name="batch" value="{{$list->batch}}"/>

                                    <td>{{$key++}}</td>
                                    <td>{{$list->contractor}}</td>
                                    <td class="text-center">{{number_format($list->amtPayable,2)}}</td>
                                    <td class="text-center">{{$list->paymentDescription}}</td>

                                    <td><a href="{{url('/display/voucher/'.$list->TID)}}" class="btn btn-success">Preview Voucher</a> </td>

                                </tr>

                            @endforeach
                            @endif
                            @endif
                            @if(count($vouchers) > 0)
                            <a href="#" class="btn btn-success com">View CA Remarks</a>
                            @endif

                            </tbody>
                        </table>
                        @if(count($vouchers) > 0)
                        @if($action->code == $ddcomm->to_whom)

                        <div class="form-group" style="margin-bottom:10px;">
                            <div class="col-sm-122">
                                <label class="control-label"><b>Enter Remarks</b></label>
                            </div>
                            <div class="col-sm-122">
                                <textarea  name="instruction" id="instruction"  class="form-control" placeholder="e.g Pay a sum amount of XXXXX" > </textarea>
                            </div>


                        </div>
                        @endif

                        <div class="clearfix"></div>

                        <input type="submit" name="submit" value="Reject" class="btn btn-danger pull-right hidden-print" style="margin-top:10px;margin-left:20px;">
                        <input type="submit" name="submit" value="Approve" class="btn btn-success pull-right hidden-print" style="margin-top:10px;">
                            @endif
                    </form>
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
                        @if(count($vouchers) > 0)
                        <div id="desc">
                            @if(!is_null($ddcomm))
                                <strong>{{$ddcomm->name}} : </strong>  <span>{{$ddcomm->ddcomment}}</span>
                            @endif
                        </div>

                            <div id="desc">
                                @if(!is_null($ca_comm))
                                    <strong>{{$ca_comm->name}} : </strong>   <span>{{$ca_comm->ca_comment}}</span>
                                @endif
                            </div>

                            @endif

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>
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
    </script>
@endsection

