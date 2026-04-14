@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Add Bid') }}
@endsection
@section('pageMenu', 'active')
@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                {{-- ALERTS --}}
                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success!</strong><br>
                            {{ session('msg') }}
                        </div>
                    @endif

                    @if (session('err'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Input Error!</strong><br>
                            {{ session('err') }}
                        </div>
                    @endif
                </div>

                <div class="panel-heading text-center">
                    <h4 class="panel-title">Procurement Records</h4>
                </div>

                <div class="panel-body">

                    <form method="post" action="{{ url('/procurement-records') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" name="startDate" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" name="endDate" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-2" style="padding-top:25px;">
                                <button class="btn btn-primary btn-sm" type="submit">Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="12" class="text-center"><strong>BASIC DATA</strong></th>
                                <th colspan="4" class="text-center"><strong>CONTRACT AWARD</strong></th>
                                <th colspan="7" class="text-center"><strong>CONTRACT IMPLEMENTATION</strong></th>
                            </tr>
                            <tr>
                                <th>Contract Description</th>
                                <th>Date Advert Published</th>
                                <th>Approval Threshold</th>
                                <th>Procurement Method</th>
                                <th>Bid Opening Date</th>
                                <th>Bid Evaluation Report Date</th>
                                <th>Budgetary Provisions (NGN)</th>
                                <th>Certificate of No Objection</th>
                                <th>Approval Date</th>
                                <th>Awarded To Least Tenderer</th>
                                <th>Contractor</th>
                                <th>Contract Award Date</th>

                                <th>Contract Value (NGN)</th>
                                <th>Contract Period</th>
                                <th>Commencement Date</th>
                                <th>Amount Paid</th>
                                <th>Expected Completion</th>
                                {{-- <th>Project Status</th> --}}
                                <th>% Completion</th>
                                <th>Variation Approval Date</th>
                                <th>Variation Amount</th>
                                <th>Remark</th>
                            </tr>

                            @foreach ($records as $list)
                                <tr>
                                    <td>{{ $list->contract_description ?? '' }}</td>
                                    <td>{{ $list->proposed_time_frame ?? '' }}</td>
                                    <td>Accounting</td>
                                    <td>NCB</td>
                                    <td></td>
                                    <td>{{ $list->review_date ?? '' }}</td>
                                    <td>{{ number_format($list->proposed_budget, 2) }}</td>
                                    <td></td>
                                    <td>{{ $list->approval_date ?? '' }}</td>
                                    <td>Yes</td>
                                    <td>{{ $list->company_name ?? '' }}</td>
                                    <td>{{ $list->approval_date ?? '' }}</td>

                                    <td>{{ number_format($list->awarded_amount, 2) }}</td>
                                    <td>{{ $list->proposed_time_frame ?? '' }}</td>
                                    <td>NA</td>
                                    <td></td>
                                    <td>{{ $list->proposed_time_frame ?? '' }}</td>
                                    {{-- <td>Project Status</td> --}}
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .remove,
        .delete {
            margin-top: 30px;
            padding-top: 5px !important;
            padding-bottom: 0px !important;

            margin-bottom: 0px;
        }

        .fa-times {
            font-size: 30px;
            cursor: pointer;
        }

        .compulsory {
            color: red;
        }

        table tr th {
            font-size: 16px;
        }
    </style>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.bn', function() {
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
        $("#biddingAmount").on('keyup', function() {
            var n = parseInt($(this).val().replace(/\D/g, ''), 10);
            if ($(this).val() == "") {
                $(this).val(0);
            } else {
                $(this).val(n.toLocaleString());
            }
        });

        /*  $(document).ready(function() {
              $('#add').click(function() {
               var total_element = $(".wraps").length;
               var lastid = $(".wraps:last").attr("id");
               //var split_id = lastid.split('_');
              var n = Number(lastid) + 1;
              //alert(nextindex);
                $('#inputWrap').append(
                    `<div class="wraps" id="'+n+'">
    <div class="row">
    <div class="col-md-5">
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
    <span class="delete bn"><i class="fa fa-times"></i></span>
    </div>
    </div>`
                    );
              });
              //end click function

              $('.delete').last().click (function () {
            						$('.wraps').last().remove();
            					});

            });*/
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

            $('.delete').last().click(function() {
                $('.wraps').last().remove();
            });

        });
    </script>





@endsection
