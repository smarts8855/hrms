@extends('layouts.layout')
@section('pageTitle')
    Leave Roaster For {{$department->department}} Department
@endsection

@section('content')


    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><strong>@yield('pageTitle')</strong> <span id='processing'></span></h3>
        </div>

        <div class="box-header with-border hidden-print">

            <br>
        </div>
        @if (session('message'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span> </button>
                <strong>Successful!</strong> {{ session('message') }}
            </div>
        @endif
        @if (session('error_message'))
            <div class="alert alert-error alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span> </button>
                <strong>Error!</strong> {{ session('error_message') }}
            </div>
        @endif

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

        <div class="table-responsive" style="font-size: 14px; padding:10px;">
            <table class="table table-striped table-responsive" id="mytable">
                <thead>
                    <tr>
                        <th width="1%">S/N</th>
                        <th>STAFF NAME</th>
                        <th>START DATE</th>
                        <th>END DATE</th>
                        <th>LEAVE ADDRESS</th>
                        <th>NO. OF DAYS</th>
                        <th>DESCRIPTION</th>
                        <th>ACTION</th>

                    </tr>
                </thead>
                <tbody>
                    @if (!empty($leaveRoasters))
                        @foreach ($leaveRoasters as $index => $leave)
                            <tr>
                                <td>{{ ++ $index }}</td>
                                <td>{{ $leave->staff_name }}</td>
                                <td>{{ $leave->startDate }}</td>
                                <td>{{ $leave->endDate }}</td>
                                <td>{{ $leave->homeAddress }}</td>
                                <td>{{ $leave->leaveDays }}</td>
                                <td>{{ $leave->description }}</td>
                                <td>
                                    @if ($leave->is_approved === 0)
                                        <a href="javascript:void()" class="btn btn-success btn-sm approve" title="Approve this leave application" staffName ="{{$leave->staff_name}}" roasterID="{{$leave->roasterID}}" startDate="{{$leave->startDate}}" endDate="{{$leave->endDate}}"> <i class="fa fa-thumbs-up" aria-hidden="true"></i>  Approve </a>
                                    @elseif($leave->is_approved === 1)
                                        <button class="btn btn-success disabled" title="This application as been approved"> <i class="fa fa-check" aria-hidden="true"></i> Approved</button>
                                        <a href="javascript:void()" class="btn btn-danger btn-sm disapprove" title="Revert this leave application" staffName ="{{$leave->staff_name}}" roasterID="{{$leave->roasterID}}"> <i class="fa fa-undo" aria-hidden="true"></i> Revert </a>
                                    @else
                                        <a href="javascript:void()" class="btn btn-success btn-sm approve" title="Approve this leave application" staffName ="{{$leave->staff_name}}" roasterID="{{$leave->roasterID}}" startDate="{{$leave->startDate}}" endDate="{{$leave->endDate}}"> <i class="fa fa-thumbs-up" aria-hidden="true"></i>  Approve </a>
                                        <a href="javascript:void()" class="btn btn-danger btn-sm disapprove disabled" title="Revert this leave application" staffName ="{{$leave->staff_name}}" roasterID="{{$leave->roasterID}}" > <i class="fa fa-undo" aria-hidden="true"></i> Revert </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @elseif(empty($leaveRoasters) || $leaveRoasters === [])
                        <div class="text-danger">
                            No data yet!!!
                        </div>
                    @endif

                </tbody>

            </table>
        </div>



    </div>


    <!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <strong>Please Confirm!!!!</strong>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                </div>
                <form method="post" action="#">
                    <div class="modal-body">

                            Are you sure you want to approve the leave application for <strong id="staffName"></strong>
                            which starts from <strong id="startDate"></strong> to <strong id="endDate"></strong>!!!!

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="roasterID" id="roasterID" />
                                    <input type="hidden" name="status" value="approve" />
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="submit" class="btn btn-success" value="Approve" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--///// end modal -->


     <!-- REVERT Modal HTML -->
     <div id="myModal2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <strong>Please Confirm!!!!</strong>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                </div>
                <form method="post" action="{{route('leave.departmental.reverse')}}">
                    <div class="modal-body">

                            Are you sure you want to revert this leave application for <strong id="staffName2"></strong>.

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="roasterID" id="roasterID2" />
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="submit" class="btn btn-success" value="Revert" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--///// end REVERT modal -->


@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript">
        //Modal popup
        $(document).ready(function() {

            $('.approve').click(function() {
                var staffName = $(this).attr('staffName');
                var roasterID = $(this).attr('roasterID');
                var startDate = $(this).attr('startDate');
                var endDate = $(this).attr('endDate');

                $('#roasterID').val(roasterID);
                $('#staffName').text(staffName);
                $('#startDate').text(startDate);
                $('#endDate').text(endDate);

                $('#myModal').modal('show');
            });

            $('.disapprove').click(function() {
                var staffName = $(this).attr('staffName');
                var roasterID = $(this).attr('roasterID');

                $('#roasterID2').val(roasterID);
                $('#staffName2').text(staffName);

                $('#myModal2').modal('show');
            });

        });



    </script>
@endsection
