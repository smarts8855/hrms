@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper(' Procurement Plan') }}
@endsection
@section('pageMenu', 'active')
@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Procurement Plan Sheet</h4>
                </div>

                <div class="panel-body">

                    {{-- Display Errors --}}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                            <strong>Success!</strong> <br />
                            {{ session('msg') }}
                        </div>
                    @endif

                    @if (session('err'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                            <strong>Input Error!</strong> <br />
                            {{ session('err') }}
                        </div>
                    @endif

                    {{-- Export Button --}}
                    <div class="text-right" style="margin-bottom: 15px;">
                        <form method="get" action="{{ route('exportPlan', $report->id) }}">
                            <input type="hidden" name="planId" value="{{ $report->id }}">
                            @csrf
                            <button class="btn btn-success btn-sm" type="submit">Export Report</button>
                        </form>
                    </div>

                    {{-- Procurement Plan Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th><strong>BASIC DATA</strong></th>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <th>Budget Year</th>
                                <td colspan="4">{{ $report->budget_year ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Budget Code</th>
                                <td colspan="4">{{ $report->budget_code ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Package Number</th>
                                <td colspan="4">{{ $report->package_number ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Lot Number</th>
                                <td colspan="4">{{ $report->lot_number ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Procurement Plan Date</th>
                                <td colspan="4">{{ date('jS M, Y', strtotime($report->plan_date)) ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Project Title</th>
                                <td colspan="4">{{ $report->project_title ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Procurement Category</th>
                                <td colspan="4">{{ $category[0]->category_name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Contract Type</th>
                                <td colspan="4">{{ $contractType[0]->type ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Budget Amount</th>
                                <td colspan="4">{{ number_format($report->budget_amount, 2) ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Project Estimate</th>
                                <td colspan="4">{{ number_format($report->estimate, 2) ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Procurement Method (ICB, NCB, Direct, Selective, Repeat, Shopping)</th>
                                <td colspan="4">{{ $report->procurement_method ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Qualification (pre/Post)</th>
                                <td colspan="4">{{ $report->qualification ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Review (Prior/Post)</th>
                                <td colspan="4">{{ $report->review ?? '' }}</td>
                            </tr>
                            {{-- Planned Timelines --}}
                            <tr>
                                <th>Planned Timelines</th>
                                <th>From</th>
                                <th>To</th>
                            </tr>
                            {{-- Example Timeline Row --}}
                            <tr>
                                <th>Preparation of Bidding Document & Advert</th>
                                <td>{{ !empty($report->bidDocFrom) ? date('jS M, Y', strtotime($report->bidDocFrom)) : '' }}
                                </td>
                                <td>{{ !empty($report->bidDocTo) ? date('jS M, Y', strtotime($report->bidDocTo)) : '' }}
                                </td>
                            </tr>
                            {{-- Add more timeline rows similarly --}}
                        </table>
                    </div>

                </div>
            </div> <!-- end panel -->
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

        table tr th {}
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

    <script>
        $(document).ready(function() {
            $("#biddingAmount").on('keyup', function(evt) {
                //if (evt.which != 110 ){//not a fullstop
                //var n = parseFloat($(this).val().replace(/\,/g,''),10);

                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                        /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
                //$(this).val(n.toLocaleString());
                //}
            });
        });
    </script>




@endsection
