@extends('layouts.layout')

@section('pageTitle')
    Reconciliation-Treasury Cash Book
@endsection


@section('content')
    <form method="POST" action="{{ route('postTreasuryReport') }}">
        {{ csrf_field() }}
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>

            <br><br />

            <!-- 1st column -->
            <div class="row col-md-offset-2">
                <div class="col-sm-5">
                    <!--======customized Date Picker=========-->
                    <div class="form-group">
                        <label>Select Date/Year/Period of Time</label>
                        <div id="reportrange" class="pull-right"
                            style="background: #fff; cursor: pointer; padding: 0px 0px 0 15px; border: 1px solid #ccc; width: 100%">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar" style="padding-top: 7px;"></i>&nbsp;
                            <span></span>
                            <b class="caret"></b>
                            <input type="text" name="selectDate" id="selectDate" class="form-control"
                                style="background: #fff; cursor: pointer; border: none; width: 90%; float: right; border-radius: 0; outline: none !important; border-style:none !important; border: none !important; border-color: transparent !important;"
                                readonly>
                        </div>
                        <input type="hidden" name="getYear" id="getYear">
                        <input type="hidden" name="getFrom" id="getFrom">
                        <input type="hidden" name="getTo" id="getTo">
                    </div>
                    <!--=======End date Picker=========-->
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Type of Report </label>
                        <select name="reportType" id="reportType" class="form-control"
                            style="border-radius: 0; outline: none !important;">
                            <option value="2">Single Report</option>
                            <!--<option value="1">Split Report</option>-->
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="col-md-12">
                <div align="center" class="form-group">
                    <label>&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-success"
                            style="border: #333; border-radius: 0; outline: none !important; margin-left: -25px; padding: 8px;"><i
                                class="fa fa-file"></i> Generate Report </button>
                    </div>
                </div>
            </div>

        </div>
    </form>


    <hr />
    <p></p>
    <p></p>


@endsection

@section('scripts')
    <!-- Include Required Prerequisites -->
    <!--<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>-->
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript">
        $(function() {
            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#selectDate').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#getYear').val(start.format('YYYY'));
                $('#getFrom').val(start.format('YYYY-MM-D'));
                $('#getTo').val(end.format('YYYY-MM-D'));
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);
            cb(start, end);
        });
    </script>
@endsection

@section('styles')
    <!-- Include Required Prerequisites -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
    <!-- Include Date Range Picker -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endsection
