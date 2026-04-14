<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Staff Address Manager</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <style type="text/css">
        <!--
        .style25 {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            color: #FF0000;
        }

        a:link {
            text-decoration: none;
        }

        a:visited {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        a:active {
            text-decoration: none;
        }

        .tblborder {
            border: 1px solid #303030 !important;
        }

        .no-border {
            border: none !important;
            border: 0;
        }

        .table tr td {
            padding: 2px;
        }

        .tblborder {
            border-top-width: 1px;
            border-right-width: 1px;
            border-bottom-width: 1px;
            border-left-width: 1px;
            border-top-style: dotted;
            border-right-style: dotted;
            border-bottom-style: dotted;
            border-left-style: dotted;
        }

        body,
        td,
        th {
            font-size: 15px;
            font-family: Verdana, Geneva, sans-serif;
        }

        a#otherpages {
            font-size: 18px
        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
        -->
        select
        {
        appearance:
        none;
        -webkit-appearance:
        none;
        -moz-appearance:
        none;
        border:
        none;
        /*
        needed
        for
        Firefox:
        */
        overflow:hidden;
        width:
        60%;
        }
        .sigtab
        tr
        td
        {
        padding:
        10px;
        }
        .sigtab
        p
        {
        border:
        1px
        solid
        #ccc;
        padding:
        9px;
        width:
        100%;
        margin:
        0px;
        }
        .totext
        {
        mso-number-format:"\@";
        /*force
        text*/
        }
    </style>

    <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>
</head>

<body>

    <div class="col-md-12">
        <div class="col-md-12">
            <div>
                <p>
                <div class="row input-sm">
                    <div class="col-xs-2"></div>
                    <div class="col-xs-8">
                        <div>
                            <h4 class="text-success text-center"><strong>COURT OF APPEAL</strong></h4>
                            <h5 class="text-center text-success"><strong> P.M.B 322 </strong></h5>
                            <h6 class=" text-center text-success"><strong>THREE ARMS ZONE, ABUJA</strong></h6>

                        </div>
                    </div>
                    <div class="col-xs-2"></div>
                </div>
                </p>
            </div>


        </div>
        <div class="col-md-12 text-center text-success" style="margin-top: 50px;">&nbsp;
            <strong>STAFF'S AND THEIR CURRENT STATE</strong>
        </div>
        <div style="width: 100%;">

            <table border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="2">
                        <table class="table table-responsive table-bordered" id="tableData">
                            <tr class="tblborder">
                                <td class="tblborder">
                                    <div align="center"><strong>S/N</strong></div>
                                </td>
                                <td class="tblborder"><strong>STAFF</strong></td>

                                <td class="tblborder"><strong>CURRENT STATE </strong></td>

                                <td class="tblborder">
                                    <div align="center"><strong>ACTION</strong></div>
                                </td>
                            </tr>

                            @foreach ($staffs as $key => $staff)
                                <tr class="tblborder">
                                    <td class="tblborder">{{ $key + 1 }}</td>
                                    <td class="tblborder"> {{ $staff->name }} </td>
                                    <td class="tblborder"> {{ $staff->state }} </td>
                                    <td class="tblborder">


                                        <button class="btn btn-success"
                                            onclick="getStaffDetails('@php echo $staff->staffid @endphp', '@php echo $staff->id @endphp', '@php echo str_replace("'", "" ,$staff->name) @endphp')"
                                            data-toggle="modal" data-target="#updateStaffAddress">
                                            Update Current State
                                        </button>


                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <h2><a class="no-print" type="button" class="btn btn-success btn-sm pull-right"
                                href="{{ url('/update-staff-address') }}">Back</a></h2>
                    </td>
                </tr>
            </table>


            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

            <!-- Modal - Update Account Details -->
            <div id="updateStaffAddress" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update Account Details</h4>
                        </div>
                        <div class="modal-body">
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Staff</label>
                                    <input type="text" id="name" class="form-control" />
                                    <input type="hidden" name="staffID" id="staffID" />
                                </div>
                                <div class="col-md-6">
                                    <label>State</label>
                                    <select name="stateid" id="stateid" class="form-control" required>
                                        <option value="">--Select State--</option>
                                        @foreach ($states as $s)
                                            <option value="{{$s->id}}">{{$s->state}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" id="updateNowBtn" class="btn btn-success"
                                data-dismiss="modal">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
            {{-- <script src="{{ asset('assets/js/jQuery-2.2.0.min.js') }}"></script> --}}
            <script src="{{ asset('assets/js/table2excel.js') }}"></script>

            <script>
                function getStaffDetails(staffID, stateID, staffName) {
                    $('#staffID').val(staffID);
                    $('#stateid').val(stateID);
                    $('#name').val(staffName);
                };

                $("#updateNowBtn").click(function() {
                    var staffID = $("#staffID").val();
                    var stateID = $("#stateid").val();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `/update-staff-current-state/${staffID}`,
                        type: "post",
                        data: {
                            'current_state': stateID
                        },
                        success: function(data) {
                            location.reload(true);
                        }
                    });
                });
            </script>

            <script type="text/javascript">
                function Export() {
                    $("#tableData").table2excel({
                        filename: "{{ session('month') }}_{{ session('year') }}_CpoEpayment.xls"
                    });
                }
            </script>
            <script>
                var murl = "{{ url('/') }}";
            </script>

</body>

</html>
