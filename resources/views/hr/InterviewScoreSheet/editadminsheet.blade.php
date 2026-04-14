@extends('layouts.layout')

@section('pageTitle')
    EDIT SCORE SHEET
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <div class="row">
                    <div class="col-xs-6">
                        <h3 class="box-title">@yield('pageTitle') <span id="processing"></span></h3>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="{{ url('interview-score-sheet') }}"><button name="action" class="btn btn-danger btn-sm"
                                type="button">
                                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back
                            </button>
                        </a>
                    </div>

                </div>
            </div>

            <div class="box box-success">
                <div class="box-body">
                    <div class="row">

                        @includeIf('Share.message')

                        <div class="col-md-12"><!--2nd col-->
                            <form method="post" action="{{ url('/update-score-sheet') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="redirect_url" value="{{ request('redirect') }}">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="candidateName">Candidate Name</label>
                                            <input type="hidden" name="score_sheetID" id="score_sheetID"
                                                value="{{ $candidate->score_sheetID }}" class="form-control">
                                            <input type="text" name="candidateName" id="candidateName"
                                                value="{{ $candidate->surname }} {{ $candidate->first_name }} {{ $candidate->othernames }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="appearanceMark">Appearance (5 Marks)</label>
                                            <input type="text" name="appearanceMark" id="appearanceMark"
                                                value="{{ $candidate->appearance_mark }}" class="form-control">
                                            <em><span id="appearanceError" class="text-danger"></span></em>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="comportmentMark">Comportment/Spoken English (5 Marks)</label>
                                            <input type="text" name="comportmentMark" id="comportmentMark"
                                                value="{{ $candidate->comportment_mark }}" class="form-control">
                                            <em><span id="comportmentError" class="text-danger"></span></em>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fiveQuestionsEach"> 5 Questions 2 Mks Each (10 Marks) </label>
                                            <input type="text" name="fiveQuestionsEach" id="fiveQuestionsEach"
                                                value="{{ $candidate->question_each_mark }}" class="form-control">
                                            <em><span id="fiveQuestionsError" class="text-danger"></span></em>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="totalMark">Total Scores</label>
                                            <input type="text" name="totalMark" id="totalMark" readonly="readonly"
                                                value="{{ $candidate->total_mark }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="review">Write Remark(s)</label>
                                            <textarea name="review" class="form-control" rows="1">{{ $candidate->review }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" style="visibility: hidden">save</label>
                                            <button name="action" class="btn btn-success form-control" type="submit">
                                                Update Candidate <i class="fa fa-save"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr />
                        </div>
                    </div>
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

@section('style')
    <style>
        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }
    </style>
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
                        $("#appearanceError").html('');
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

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });

            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}"
                });
            @endif

            @if ($errors->any())
                Toast.fire({
                    icon: 'error',
                    title: "{{ $errors->first() }}"
                });
            @endif

        });
    </script>
@endsection
