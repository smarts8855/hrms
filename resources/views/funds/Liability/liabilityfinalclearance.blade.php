@extends('layouts.layout')
@section('pageTitle')
    Expenditure Control: Final Clearance
@endsection



@section('content')

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"> @yield('pageTitle') <span id='processing'></span></h3>
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

            <form class="form-horizontal" role="form" id="form1" method="post" action="">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12"><!--1st col-->
                            @include('funds.Share.message')
                            <!-- /.row -->
                            <div class="row">
                                {{ csrf_field() }}
                            </div>
                            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                                <table id="res_tab" class="table table-bordered table-striped table-highlight">
                                    <thead>
                                        <tr bgcolor="#c7c7c7">
                                            <th>S/N</th>
                                            <th>Action</th>
                                            <th>Beneficiary</th>
                                            <th>Total Amount</th>
                                            <th>Contract/Claim Description</th>
                                            <th>Payment Description</th>
                                            <th>Vote Description</th>
                                            <th>Vote Balance</th>
                                        </tr>
                                    </thead>
                                    @php $i = 1; @endphp
                                    <tbody>
                                        @if ($tablecontent)
                                            @foreach ($tablecontent as $list)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-danger btn-xs dropdown-toggle"
                                                                type="button" id="dropdownMenu1" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="true">
                                                                Action
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                                <li><a target= "_blank"
                                                                        href="/display/voucher/{{ $list->ID }}">Preview</a>
                                                                </li>
                                                                <li><a onclick="accept('{{ $list->ID }}')"
                                                                        href="#">Process</a></li>
                                                                <li><a href="/display/comment/{{ $list->conID }}"
                                                                        target="_blank">View Minute</a></li>
                                                                <li><a onclick="decline('{{ $list->ID }}')"
                                                                        href="#">Decline</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>

                                                    @if ($list->voucherType == '1')
                                                        <td>{{ $list->contractor }}</td>
                                                    @else
                                                        <td>{{ $list->beneficiary }}</td>
                                                    @endif
                                                    <td>{{ number_format($list->totalPayment) }}</td>
                                                    <td>{{ $list->ContractDescriptions }}</td>
                                                    <td>{{ $list->paymentDescription }}</td>
                                                    <td>{{ $list->voteinfo }}</td>
                                                    <td>{{ number_format($list->votebal) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="100%">
                                                    <center>No Record</center>
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                                <br><br><br><br><br><br>
                            </div>
                            <hr />
                        </div>

                    </div>
                </div>
                <input type="hidden" id="assvid" name="vid">
                <input type="hidden" id="as_user" name="as_user">
            </form>
            <div id="approveindex" class="modal fade">
                <form class="form-horizontal" role="form" method="post" action="">
                    {{ csrf_field() }}
                    <div class="modal-dialog box-default" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title"> Clearance Comfirmation </h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5> You are about to clear this voucher for further processing! Do you still want to
                                    continue?</h5>
                                <div class="form-group" style="margin: 0 10px;">
                                    <div class="col-sm-12">
                                        <label class="control-label"><b>Enter minute if any(optional)</b></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea name="comment" class="form-control"> </textarea>
                                    </div>
                                    <input type="hidden" id="vaid" name="vid">
                                </div>
                                <div class="modal-footer">
                                    <button type="Submit" name="process" class="btn btn-success">Continue</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!--decline modal-->
            <div id="declineModal" class="modal fade">
                <form class="form-horizontal" role="form" method="post" action="">
                    {{ csrf_field() }}
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Clearance Rejection</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5> You are about to reject this voucher for further processing! Do you still want to
                                    continue?</h5>
                                <div class="form-group" style="margin: 0 10px;">
                                    <div class="col-sm-12">
                                        <label class="control-label"><b>Enter Reason for Decline</b></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea name="comment" class="form-control" required> </textarea>
                                    </div>
                                    <input type="hidden" id="vdid" name="vid">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="Submit" name="decline" class="btn btn-success">Continue</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <!--end of decline modal-->

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
                function accept(a = "") {
                    document.getElementById('vaid').value = a;
                    $("#approveindex").modal('show');
                }

                function decline(a = "") {
                    document.getElementById('vdid').value = a;
                    $("#declineModal").modal('show')
                    return false;
                }

                function AssignStaff(id) {
                    //alert(id);
                    document.getElementById('assvid').value = id;
                    document.getElementById('as_user').value = document.getElementById("staff" + id).value;
                    if (document.getElementById('as_user').value !== "") {
                        document.getElementById('form1').submit();
                        return;
                    }
                }
            </script>
        @stop
