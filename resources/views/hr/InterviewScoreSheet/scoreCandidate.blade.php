@extends('layouts.layout')

@section('pageTitle')
    New Appointment
@endsection

@section('content')
    <div class="box box-default">


        <div class="box-body box-profile">

            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span
                        id='processing'><strong><em>Interview Score Sheet.</em></strong></span></h3>
            </div>
            <div class="box box-success">
                <div class="box-body">
                    <div class="row">
                        @includeIf('hr.Share.message')

                        <div class="col-md-12">
                            <!--2nd col-->
                            <form method="post" action="{{ url('/interview-score-sheet') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="interviewName">SELECT INTERVIEW</label>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="candidateName">Candidate Name</label>
                                            <select name="candidateName" id="candidateName" required class="form-control">
                                                <option value="">Select</option>
                                                @if (isset($getAllcandidates) && $getAllcandidates)
                                                    @foreach ($getAllcandidates as $listCandidate)
                                                        <option value="{{ $listCandidate->candidateID }}"
                                                            {{ $listCandidate->candidateID == (isset($getFileIDSession) ? $getFileIDSession : old('candidateName')) ? 'selected' : '' }}>
                                                            {{ $listCandidate->surname . ' ' . $listCandidate->first_name . ' ' . $listCandidate->othernames }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="appearanceMark">Appearance (5 Marks)</label>
                                            <input type="text" name="appearanceMark" id="appearanceMark" required
                                                class="form-control">
                                            <em><span id="appearanceError" class="text-danger"></span></em>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="comportmentMark">Comportment/Spoken Eng (5 Marks)</label>
                                            <input type="text" name="comportmentMark" id="comportmentMark" required
                                                class="form-control">
                                            <em><span id="comportmentError" class="text-danger"></span></em>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fiveQuestionsEach">5 Qtns, 2 Marks Each (10 Marks)</label>
                                            <input type="text" name="fiveQuestionsEach" id="fiveQuestionsEach" required
                                                class="form-control">
                                            <em><span id="fiveQuestionsError" class="text-danger"></span></em>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="totalMark">Total (20 Marks)</label>
                                            <input type="text" name="totalMark" id="totalMark" readonly="readonly"
                                                required class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="review">Write Remark(s)</label>
                                            <textarea name="review" rows="1" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="interview_score_file">Upload Interview Score</label>
                                            <input type="file" name="interview_score_file" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="">
                                        <div align="center" class="form-group">
                                            <label for="month">&nbsp;</label><br />
                                            <button name="action" class="btn btn-success" type="submit">
                                                Save Candidate <i class="fa fa-save"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr />

                        </div>
                    </div><!-- /.col -->
                </div>
            </div>

            <div class="box box-default">
                {{-- end copy  --}}
                <div class="box box-primary custom-card">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="{{ url('/interview-push-score') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <table class="table table-bordered table-striped" id="servicedetail" width="100%">
                                        <thead>
                                            <tr>
                                                <th colspan="10">

                                                    <div>
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            data-toggle="modal" data-backdrop="false"
                                                            data-target="#confirmPush">FORWARD TO ADMIN</button>



                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>

                                                <th>S/N</th>
                                                <th>
                                                    <input type="checkbox" id="checkAll">
                                                    <label for="checkAll">Check All</label>
                                                    {{-- <button type="button" class="btn btn-sm btn-success"
                                                        data-toggle="modal" data-backdrop="false"
                                                        data-target="#confirmPush">FORWARD TO ADMIN</button> --}}

                                                </th>
                                                <th>CANDIDATE</th>
                                                <th>APPEARANCE <br> (5 MKS)</th>
                                                <th>COMPORTMENT <br> (5 MKS)</th>
                                                <th>5 QTNS 2 MKS EACH <br> (10 MKS)</th>
                                                <th>TOTAL SCORES</th>
                                                <th>REMARK(S)</th>
                                                <th>INTERVIEW FILES</th>
                                                <th colspan="2" class="text-center">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($getRecords) && $getRecords)
                                                @foreach ($getRecords as $key => $list)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>
                                                            <input type="checkbox" name="selectedCandidate[]"
                                                                value="{{ $list->score_sheetID }}" />
                                                        </td>
                                                        {{-- <td>
                                                            {{ $list->surname . ' ' . $list->first_name . ' ' . $list->othernames }}
                                                        </td> --}}
                                                        <td>
                                                            {{ $list->surname }} {{ $list->first_name }}
                                                            {{ $list->othernames }}
                                                            <br>
                                                            @if ($list->candidate_source == 'CR')
                                                                <span class="label label-success">
                                                                    {{ $list->candidate_source }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $list->appearance_mark }}</td>
                                                        <td>{{ $list->comportment_mark }}</td>
                                                        <td>{{ $list->question_each_mark }}</td>
                                                        <td>{{ $list->total_mark }}</td>
                                                        <td>{{ $list->review }}</td>
                                                        <td>
                                                            <a href="{{ $list->interview_score_file }}" target="_blank">
                                                                <button type="button" class="btn btn-primary btn-sm">
                                                                   <i class="fa fa-eye"></i> View 
                                                                </button> 
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-toggle="modal" data-backdrop="false"
                                                                data-target="#confirmToDelete{{ $list->score_sheetID }}">
                                                                <span class="glyphicon glyphicon-trash"></span> &nbsp;
                                                                Delete
                                                            </button>

                                                            <!-- Modal to delete -->
                                                            <div class="modal fade text-left d-print-none"
                                                                id="confirmToDelete{{ $list->score_sheetID }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="confirmToSubmit" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-danger">
                                                                            <h4 class="modal-title text-white"><i
                                                                                    class="ti-save"></i>
                                                                                Confirm!</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="text-success text-center">
                                                                                <h4>Are you sure you want to delete
                                                                                    candidate score for
                                                                                    {{ $list->surname . ' ' . $list->first_name . ' ' . $list->othernames }}
                                                                                    ? </h4>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-outline-info"
                                                                                data-dismiss="modal"> Cancel </button>
                                                                            <a href="{{ url('delete-score-sheet/' . $list->score_sheetID) }}"
                                                                                class="btn btn-danger"> Yes Delete </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end Modal-->


                                                        </td>
                                                        <td>
                                                            <a href="/edit-score-sheet/{{ $list->score_sheetID }}"
                                                                class="pull-right">
                                                                <span class="btn btn-info btn-sm">
                                                                    <span class="glyphicon glyphicon-edit"></span> &nbsp;
                                                                    Edit
                                                                </span>
                                                            </a>
                                                        </td>







                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                    <!-- Modal to Forward -->
                                    <div class="modal fade text-left d-print-none" id="confirmPush" tabindex="-1"
                                        role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success">
                                                    <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-success text-center">
                                                        <h4>Are you sure you want to forward these candidate record(s)?
                                                        </h4>
                                                    </div>
                                                    <textarea name="getComment" class="form-control" placeholder="Comment (Optional)"></textarea>
                                                    <input type="hidden" name="getInterviewID"
                                                        value="{{ isset($getInterviewID) ? $getInterviewID : '' }}" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-info"
                                                        data-dismiss="modal"> Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-success"> Forward Now </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end Modal-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal to Delete -->
            <!-- Modal -->
            @if (session('deleteModal'))
                @include('hr.InterviewScoreSheet.Modals.warning');
            @endif
            <!--end Modal-->

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
            var appearanceMark = 0;
            var comportmentMark = 0;
            var fiveQuestionsEach = 0;
            var totalScores = 0;

            $("#appearanceMark").on("keyup", function(e) {
                appearanceMark = (isNaN(parseFloat($("#appearanceMark").val())) ? 0 : parseFloat($(
                    "#appearanceMark").val()));
                comportmentMark = (isNaN(parseFloat($("#comportmentMark").val())) ? 0 : parseFloat($(
                    "#comportmentMark").val()));
                fiveQuestionsEach = (isNaN(parseFloat($("#fiveQuestionsEach").val())) ? 0 : parseFloat($(
                    "#fiveQuestionsEach").val()));
                totalScores = (appearanceMark + comportmentMark + fiveQuestionsEach);
                $("#totalMark").val((isNaN(totalScores) ? 0 : totalScores));

                if (!isNaN($("#appearanceMark").val())) {
                    if ($("#appearanceMark").val() > 5) {
                        // $("#appearanceMark").css({"border-width":"5px", "border-color":"red"});
                        $("#appearanceMark").val('');
                        $("#appearanceError").html(
                            'Appearance Mark cannot be less than zero or more than 5!!');
                    } else {
                        $("#appearanceError").html('').hide();
                    }
                } else {
                    $("#appearanceMark").val('');
                    $("#appearanceError").html('Appearance Mark must be number!!');
                }

            });

            $("#comportmentMark").on("keyup", function(e) {
                appearanceMark = (isNaN(parseFloat($("#appearanceMark").val())) ? 0 : parseFloat($(
                    "#appearanceMark").val()));
                comportmentMark = (isNaN(parseFloat($("#comportmentMark").val())) ? 0 : parseFloat($(
                    "#comportmentMark").val()));
                fiveQuestionsEach = (isNaN(parseFloat($("#fiveQuestionsEach").val())) ? 0 : parseFloat($(
                    "#fiveQuestionsEach").val()));
                totalScores = (appearanceMark + comportmentMark + fiveQuestionsEach);
                $("#totalMark").val((isNaN(totalScores) ? 0 : totalScores));

                if (!isNaN($("#comportmentMark").val())) {
                    if ($("#comportmentMark").val() > 5) {
                        // $("#comportmentMark").css({"border-width":"5px", "border-color":"red"});
                        $("#comportmentMark").val('');
                        $("#comportmentError").html(
                            'Comportment/Spoken English Mark cannot be less than zero more than 5!!');
                    } else {
                        $("#comportmentError").html('');
                    }
                } else {
                    $("#comportmentMark").val('');
                    $("#comportmentError").html('Appearance Mark must be number!!');
                }
            });

            $("#fiveQuestionsEach").on("keyup", function(e) {
                appearanceMark = (isNaN(parseFloat($("#appearanceMark").val())) ? 0 : parseFloat($(
                    "#appearanceMark").val()));
                comportmentMark = (isNaN(parseFloat($("#comportmentMark").val())) ? 0 : parseFloat($(
                    "#comportmentMark").val()));
                fiveQuestionsEach = (isNaN(parseFloat($("#fiveQuestionsEach").val())) ? 0 : parseFloat($(
                    "#fiveQuestionsEach").val()));
                totalScores = (appearanceMark + comportmentMark + fiveQuestionsEach);
                $("#totalMark").val((isNaN(totalScores) ? 0 : totalScores));

                if (!isNaN($("#fiveQuestionsEach").val())) {
                    if ($("#fiveQuestionsEach").val() > 10) {
                        // $("#fiveQuestionsEach").css({"border-width":"5px", "border-color":"red"});
                        $("#fiveQuestionsEach").val('');
                        $("#fiveQuestionsError").html('This mark cannot be greater than 10!!');
                    } else {
                        $("#fiveQuestionsError").html('');
                    }
                } else {
                    $("#fiveQuestionsMark").val('');
                    $("#fiveQuestionsError").html('Appearance Mark must be number!!');
                }
            });


            //showing delete modal
            $('#delModal').modal('show');

        }); //end document
    </script>
    <script>
        $(document).ready(function() {
            $("#interviewName").change(function() {
                $('#inverviewName').val($('#interviewName').val());
                $('#getCandidateForm').submit();
            });
        }); //end document
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll(
                'input[name="selectedCandidate[]"]'
            );

            // Check / Uncheck all rows
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
            });

            // Update "Check All" when any row checkbox changes
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    checkAll.checked = [...checkboxes].every(c => c.checked);
                });
            });

        });
    </script>
@endsection
