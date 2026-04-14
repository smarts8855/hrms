@extends('layouts.layout')

@section('pageTitle')
    New Appointment
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span
                        id='processing'><strong><em>Secretary Approval.</em></strong></span></h3>
            </div>

            <div class="box-body">
                <div class="row">

                    @includeIf('Share.message')

                    <div class="col-md-12"><!--2nd col-->
                        <form method="post" action="{{ url('/interview-score-sheet') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="interviewName">SELECT INTERVIEW NAME</label>
                                        <select name="interviewName" id="interviewName" required class="form-control">
                                            <option value="">Select</option>
                                            @if (isset($getInterviewName) && $getInterviewName)
                                                @foreach ($getInterviewName as $listInterview)
                                                    <option value="{{ $listInterview->interviewID }}"
                                                        {{ $listInterview->interviewID == (isset($getInterviewID) ? $getInterviewID : old('interviewName')) ? 'selected' : '' }}>
                                                        {{ $listInterview->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <br />
                                    <br />
                                </div>
                            </div>

                        </form>

                        {{-- Showing the title and the date of the selected options --}}
                        @if (isset($getRecords) && !empty($getRecords[0]))
                            <div class="row">
                                <div class="ml-3 col-md-4">
                                    <h3>For: <strong> {{ $getRecords[0]->title }} </strong> </h3>
                                    <h3>Date: <strong> {{ date('F j, Y', strtotime($getRecords[0]->date)) }} </strong> <i
                                            class="fa fa-calendar" aria-hidden="true"></i> </h3>
                                </div>
                            </div>
                        @endif

                        <hr />

                        <div class="noprint">
                            <h4>Interview Attachments:
                                @if (isset($interviewAttachments) && $interviewAttachments)
                                    @foreach ($interviewAttachments as $int => $attachment)
                                        <em> <a href="{{ asset("interviewAttachmentfiles/$attachment->attachment") }}"
                                                target="__blank">{{ $attachment->description . '-' . ++$int }}</a> </em>,
                                    @endforeach
                                @endif
                            </h4>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ url('/interview-approval-candidate') }}" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-bordered table-striped table-responsive" id="servicedetail"
                            width="100%">
                            <thead>
                                <tr>
                                    <th colspan="9">
                                        <div align="right">
                                            @if (isset($checkForAnyCandidateApproval) && count($checkForAnyCandidateApproval) > 0)
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-backdrop="false" data-target="#confirmPush">Forward All Approved
                                                    Candidates To Admin</button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-primary noprint"
                                                data-toggle="modal" data-backdrop="false" data-target="#confirmComment">View
                                                Comment</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>S/N</th>
                                    <th class="text-center">

                                        <button type="button" class="btn btn-sm btn-success mb-3" data-toggle="modal"
                                            data-backdrop="false" data-target="#confirmApproval">APPROVE</button>
                                    </th>
                                    @if (isset($checkForAnyApproved) && $checkForAnyApproved)
                                        <th><button type="button" class="btn btn-sm btn-danger revertCandidateBtn"
                                                data-toggle="modal" data-backdrop="false"
                                                data-target="#unconfirmApproval">REVERT</button></th>
                                    @endif
                                    <th>CANDIDATE</th>
                                    <th>APPEARANCE <br> (5 MARKS)</th>
                                    <th>COMPORTMENT <br> (5 MARKS)</th>
                                    <th>5 QUESTIONS 2 MARKS EACH <br> (10 MARKS)</th>
                                    <th>TOTAL SCORES</th>
                                    <th>REMARKS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($getRecords) && $getRecords)
                                    @foreach ($getRecords as $key => $list)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            @if ($list->is_approved === 0)
                                                <td>
                                                    <div align="center"><input title="Approve now" type="checkbox"
                                                            id="checkboxApprove" name="selectedCandidate[]"
                                                            value="{{ $list->score_sheetID }}" /></div>
                                                </td>
                                            @elseif($list->is_approved === 1)
                                                <td>
                                                    <div class="col-md-4 text-center"><span class="fa fa-check text-success"
                                                            title="Already pushed to secretary"></span></div>
                                                    @if ($list->is_final_approval == 1)
                                                        <div class="col-md-4 text-center"><span
                                                                class="fa fa-check text-info"
                                                                title="Already Approved"></span></div>
                                                    @endif
                                                </td>
                                            @endif

                                            @if (isset($checkForAnyApproved) && $checkForAnyApproved)
                                                @if ($list->is_approved === 1 || $list->is_final_approval === 1)
                                                    <td>
                                                        <div align="center"><input title="Check to disapprove"
                                                                id="checkboxRevert" type="checkbox"
                                                                name="selectedRevertCandidate[]"
                                                                value="{{ $list->score_sheetID }}" /></div>
                                                        {{-- @if (isset($checkForAnyApproved) && $checkForAnyApproved)
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger revertCandidateBtn"
                                                                data-id="{{ $list->score_sheetID }}" data-toggle="modal"
                                                                data-backdrop="false"
                                                                data-target="#unconfirmApproval">REVERT</button>
                                                        @endif --}}
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            @endif

                                            <td>
                                                {{ $list->surname . ' ' . $list->first_name . ' ' . $list->othernames }}
                                                <br>
                                                @if ($list->candidate_source == 'CR')
                                                    <span class="label label-success"> {{ $list->candidate_source }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $list->appearance_mark }}</td>
                                            <td>{{ $list->comportment_mark }}</td>
                                            <td>{{ $list->question_each_mark }}</td>
                                            <td>{{ $list->total_mark }}</td>
                                            <td>{{ $list->review }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <!-- Modal to delete -->
                        <div class="modal fade text-left d-print-none" id="confirmApproval" tabindex="-1" role="dialog"
                            aria-labelledby="confirmToSubmit" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-success text-center">
                                                    <h4>Are you sure you want to approve this candidate(s)? </h4>
                                                </div>
                                                <br />
                                                <input type="hidden" name="getInterviewID"
                                                    value="{{ isset($getInterviewID) ? $getInterviewID : '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-info" data-dismiss="modal"> No.
                                            Cancel </button>
                                        <button type="submit" class="btn btn-success"> Yes. Approve </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--end Modal-->
                    </form>


                    {{-- revert candidate modal --}}
                    <form action="{{ url('/interview-revert-candidate') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="revertSelected[]" id="revertSelected">

                        <div class="modal fade text-left d-print-none" id="unconfirmApproval" tabindex="-1"
                            role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-success text-center">
                                                    <h4>Are you sure you want to <strong>unapprove</strong> this
                                                        candidate(s)? </h4>
                                                </div>
                                                <br />
                                                <input type="hidden" name="getInterviewID"
                                                    value="{{ isset($getInterviewID) ? $getInterviewID : '' }}" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-info" data-dismiss="modal"> No.
                                            Cancel </button>
                                        <button type="submit" class="btn btn-danger"> Yes. Unapprove </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    {{-- end revert candidate modal --}}

                    <form method="post" action="{{ url('/interview-push-approved-score') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Modal to push -->
                        <div class="modal fade text-left d-print-none" id="confirmPush" tabindex="-1" role="dialog"
                            aria-labelledby="confirmToSubmit" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-success text-center">
                                                    <h4>Are you sure you want to forward the seleted candidate(s)? </h4>
                                                </div>
                                                <br />
                                                <textarea name="getComment" class="form-control" placeholder="Comment (Optional)"></textarea>
                                                <input type="hidden" name="getInterviewID"
                                                    value="{{ isset($getInterviewID) ? $getInterviewID : '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-success"> Forward Now </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end Modal-->
                    </form>

                    <!-- Modal to Comment -->
                    <div class="modal fade text-left d-print-none" id="confirmComment" tabindex="-1" role="dialog"
                        aria-labelledby="confirmToSubmit" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h4 class="modal-title text-white"><i class="ti-save"></i> Comment</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div style="max-height: 400px; overflow-x: auto;">
                                                        @if (isset($getComments) && $getComments)
                                                            @foreach ($getComments as $keyComment => $comment)
                                                                <div class="col-md-12">
                                                                    {{ $keyComment + 1 . ' ' }}.
                                                                    {{ $comment->comment . ' - ' }} <br /> <i
                                                                        class="fa fa-calendar">
                                                                        {{ date('d-m-Y', strtotime($comment->created_at)) }}</i>
                                                                    <hr />
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end Modal-->
                </div>
            </div>
        </div>
    </div>
    <form id="getCandidateForm" method="post" action="{{ url('/get-candidate-for-interview') }}"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="inverviewName" id="inverviewName" />
    </form>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $("#interviewName").change(function() {
                $('#inverviewName').val($('#interviewName').val());
                $('#getCandidateForm').submit();
            });

            $('.revertCandidateBtn').click(function() {

                // $revertID = $(this).attr('data-id')
                // // console.log($revertID);
                // $('#revertSelected').val($revertID);

                $('#checkboxRevert').each(function() {
                    if ($("input[name='selectedRevertCandidate[]']")) {
                        c = $("input[name='selectedRevertCandidate[]']:checked")
                            .map(function() {
                                return $(this).val();
                            }).get();

                        b = $("input[name='revertSelected[]']").val(c);
                    }
                });


            });

        }); //end document
    </script>
@endsection
