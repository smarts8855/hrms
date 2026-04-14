@extends('layouts.layout')
@section('pageTitle')
    Staff Claim
@endsection



@section('content')

    <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Trash Record</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-9 control-label"><b>Are you sure you want to delete this
                                        record?</b></label>
                            </div>
                            <input type="hidden" id="deleteid" name="deleteid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success" name="delete">Yes</button>
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
                @if ($error != '')
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                        <p>{{ $error }}</p>
                    </div>
                @endif
                @if ($success != '')
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                        {{ $success }}
                    </div>
                @endif
                @if (session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                        {{ session('err') }}
                    </div>
                @endif
            </div>


            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        @include('funds.Share.message')



                        <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                            <table id="res_tab" class="table table-bordered table-striped table-highlight">
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                        <th>S/N</th>
                                        <th>Entry No</th>
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

                                    @foreach ($procurementlist as $list)
                                        <tr
                                            @if ($list->isrejected == 1) style="background-color: red; color:#FFF;" @endif>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $list->ID }}</td>
                                            <td>{{ $list->fileNo }}</td>
                                            <td>{{ $list->contractType }}</td>
                                            <td>{{ $list->ContractDescriptions }}</td>

                                            <td> {{ number_format($list->contractValue, 2) }}</td>
                                            <td>{{ $list->beneficiary }}</td>
                                            <td>{{ $list->name }}</td>
                                            <td>
                                                @if ($list->isrejected == 1)
                                                    Rejected
                                                @else
                                                    @if ($list->approvalStatus == 1)
                                                        <b><span class="text-success">Approved</span></b>
                                                    @elseif($list->approvalStatus == 2)
                                                        <b><span class="text-warning">Rejected</span></b>
                                                    @else
                                                        <b><span class="text-danger">Pending</span></b>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $list->dateAward }}</td>
                                            <td>{{ $list->approvalDate }} </td>
                                            <td>
                                                <a class="btn btn-success btn-xs"
                                                    href="/display/comment/{{ $list->ID }}" target="_blank">Details</a>
                                                @if ($list->approvalStatus == 0)
                                                    <!--<button onclick="return deletefunc('{{ $list->ID }}')" class="btn btn-danger btn-xs" > <i class="fa fa-trash"></i> </button>-->
                                                @elseif($list->approvalStatus == 2)
                                                    <button
                                                        onclick="return editfunc('{{ $list->ID }}', '{{ $list->fileNo }}', '{{ $list->contract_Type }}','{{ $list->ContractDescriptions }}','{{ $list->contractValue }}','{{ $list->companyID }}','{{ $list->dateAward }}')"
                                                        class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button>
                                                    <button class="btn btn-info btn-xs"
                                                        onclick="return viewReason('{{ $list->reason }}', '{{ $list->ID }}', '{{ $list->fileNo }}', '{{ $list->contract_Type }}','{{ $list->ContractDescriptions }}','{{ $list->contractValue }}','{{ $list->companyID }}','{{ $list->dateAward }}')">Reason</button>
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
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
        @stop

        @section('styles')
            <style type="text/css">
                .modal-dialog {
                    width: 13cm
                }

                .modal-header {

                    background-color: #006600;

                    color: #FFF;

                }

                #partStatus {
                    width: 2.5cm
                }
            </style>
        @endsection

        @section('scripts')
            <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
            <script>
                $('#res_tab').DataTable({
                    "iDisplayLength": 100
                });

                $("#contractvalue").on('keyup', function(evt) {

                    //if (evt.which != 110){//not a fullstop
                    //var n = parseFloat($(this).val().replace(/\,/g,''),10);

                    x = $(this).val().replace(/[ ]*,[ ]*|[ ]+/g, '');
                    $(this).val(x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    //if(isNaN(n)){

                    //}
                    //else{
                    //$(this).val(n.toLocaleString());
                    //}
                    //}

                });

                function deletefunc(a) {
                    document.getElementById('deleteid').value = a;
                    $("#DeleteModal").modal('show')
                    return false;
                }
            </script>
        @stop
