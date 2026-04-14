<div id="pushModal" class="modal fade">
    <div class="modal-dialog box box-default" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Please confirm that you want to approve payment </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="POST" action="{{ url('/cpo-approve-council/payroll-report') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group" style="margin: 0 10px;">
                        <label class="control-label">Month</label>
                        <input type="text" class="col-sm-9 form-control" id="month" name="month" required
                            readonly>
                    </div>
                    <div class="form-group" style="margin: 0 10px;">
                        <label class="control-label">Year</label>
                        <input type="text" class="col-sm-9 form-control" id="year" name="year" required
                            readonly>
                    </div>
                    <div class="form-group" style="margin: 0 10px;">
                        <label class="control-label">Division</label>
                        <input type="text" class="col-sm-9 form-control" id="division" readonly>
                        <input type="hidden" value="" id="divisionID" name="divisionID" required>
                    </div>
                    <div class="form-group" style="margin: 0 10px;">
                        <label class="control-label">Comment (optional)</label>
                        <textarea name="comment" class="col-sm-9 form-control" id="" cols="10" rows="3"></textarea>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" id="id" name="id">
                        <button type="Submit" class="btn btn-success">Accept</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                    <div style="background-color: lightblue; height: 150px; overflow: scroll;">
                        @php $key = 1 @endphp
                        @if (count($allcomments) > 0)
                            @foreach ($allcomments as $key => $listComment)
                                <div align="left" class="col-xs-12">
                                    {{ $key + 1 }}. &nbsp; {{ $listComment->name . ' - ' . $listComment->comment }}
                                    <br> Created Date: <i class="text-info"> {{ $listComment->updated_at }} </i>
                                    <hr style="margin: 1px 0px; solid #000!important; " />
                                </div>
                            @endforeach
                        @else
                            <div class="col-xs-12 text-danger" align="center"> No comment found! </div>
                        @endif

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="declineModal" class="modal fade">
    <div class="modal-dialog box box-default" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <span class="text-danger"> Please confirm you want to decline! </span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" role="form" method="POST"
                action="{{ url('/cpo-decline-council/payroll-report') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group" style="margin: 0 10px;">
                        <label class="control-label">Month</label>
                        <input type="text" class="col-sm-9 form-control" id="declinemonth" name="month" required
                            readonly>
                    </div>
                    <div class="form-group" style="margin: 0 10px;">
                        <label class="control-label">Year</label>
                        <input type="text" class="col-sm-9 form-control" id="declineyear" name="year" required
                            readonly>
                    </div>
                    <div class="form-group" style="margin: 0 10px;">
                        <label class="control-label">Division</label>
                        <input type="text" class="col-sm-9 form-control" id="declinedivision" readonly>
                        <input type="hidden" value="" id="declinedivisionID" name="declinedivisionID"
                            required>
                    </div>
                    <div class="form-group" style="margin: 0 10px;">
                        <label class="control-label">Comment <span class="text-danger">*</span></label>
                        <textarea name="declinecomment" class="col-sm-9 form-control" id="" cols="10" rows="3"></textarea>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" id="id" name="id">
                        <button type="Submit" name="edit" class="btn btn-danger">Reject</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                    <div style="background-color: lightblue; height: 150px; overflow: scroll;">
                        @php $key = 1 @endphp
                        @if (count($allcomments) > 0)
                            @foreach ($allcomments as $key => $listComment)
                                <div align="left" class="col-xs-12">
                                    {{ $key + 1 }}. &nbsp; {{ $listComment->name . ' - ' . $listComment->comment }}
                                    <br> Created Date: <i class="text-info"> {{ $listComment->updated_at }} </i>
                                    <hr style="margin: 1px 0px; solid #000!important; " />
                                </div>
                            @endforeach
                        @else
                            <div class="col-xs-12 text-danger" align="center"> No comment found! </div>
                        @endif

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="">
    <!-- For cpo unit -->
    @if ($payroll_detail[0]->vstage == 5)
        @if ($divisionDiv == '')
            <button class="btn btn-success" id="push" data-vstage="{{ $payroll_detail[0]->vstage }}"
                data-year="{{ $payroll_detail[0]->year }}" data-month="{{ $payroll_detail[0]->month }}"
                >
                Accept
            </button>

            <button class="btn btn-danger" id="decline" data-vstage="{{ $payroll_detail[0]->vstage }}"
                data-year="{{ $payroll_detail[0]->year }}" data-month="{{ $payroll_detail[0]->month }}"
                >
                Decline
            </button>
        @else
            <button class="btn btn-success" id="push" data-vstage="{{ $payroll_detail[0]->vstage }}"
                data-year="{{ $payroll_detail[0]->year }}" data-month="{{ $payroll_detail[0]->month }}"
                data-division="{{ $payroll_detail[0]->division }}"
                data-divisionID="{{ $payroll_detail[0]->divisionID }}">
                Accept
            </button>

            <button class="btn btn-danger" id="decline" data-vstage="{{ $payroll_detail[0]->vstage }}"
                data-year="{{ $payroll_detail[0]->year }}" data-month="{{ $payroll_detail[0]->month }}"
                data-division="{{ $payroll_detail[0]->division }}"
                data-divisionID="{{ $payroll_detail[0]->divisionID }}">
                Decline
            </button>
        @endif
    @elseif ($payroll_detail[0]->vstage == 6)
        <button type="button" class="btn btn-success">
            Successfully Approved
        </button>
    @endif


</div>
<script src="{{ asset('/assets/js/jQuery-2.2.0.min.js') }}"></script>
<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // console.log("doc is ready")
        $("#push").click(function(e) {
            e.preventDefault();
            console.log("clicked")
            let vstage = $(this).attr('data-vstage')
            let month = $(this).attr('data-month')
            let year = $(this).attr('data-year')
            let division = $(this).attr('data-division')
            let divisionID = $(this).attr('data-divisionID')

            $('#year').val(year)
            $('#month').val(month)
            $('#division').val(division)
            $('#divisionID').val(divisionID)

            jQuery('#pushModal').modal('show')

        });

        $("#decline").click(function(e) {
            e.preventDefault();
            console.log("clicked")
            let vstage = $(this).attr('data-vstage')
            let month = $(this).attr('data-month')
            let year = $(this).attr('data-year')
            let division = $(this).attr('data-division')
            let divisionID = $(this).attr('data-divisionID')

            $('#declineyear').val(year)
            $('#declinemonth').val(month)
            $('#declinedivision').val(division)
            $('#declinedivisionID').val(divisionID)

            jQuery('#declineModal').modal('show')

        });
    });
</script>
