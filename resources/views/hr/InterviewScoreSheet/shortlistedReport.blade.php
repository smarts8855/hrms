@extends('layouts.layout')

@section('pageTitle')
    New Appointment
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span
                        id='processing'><strong><em>Candidates Shortlisted For Appointments.</em></strong></span></h3>
            </div>

            {{-- Showing the title and the date of the selected options --}}
            @if (isset($getRecords) && !empty($getRecords[0]))
                <div class="row">
                    <div class="ml-3 col-md-4">
                        For: <strong> {{ $getRecords[0]->title }} </strong> <br>
                        Date: <strong> {{ date('F j, Y', strtotime($getRecords[0]->date)) }} </strong> <i
                            class="fa fa-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            @endif

            <div class="box-body hidden-print">
                <div class="row">

                    @includeIf('hr.Share.message')

                    <div class="col-md-12"><!--2nd col-->
                        <form method="post" action="{{ url('/interview-score-sheet') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="interviewNameLabel">SELECT INTERVIEW NAME</label>
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
                                </div>
                            </div>

                        </form>
                        <hr />
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->


            <div class="row">
                <div class="col-md-12">

                    <div class="box-header with-border text-center">
                        <div align="center">
                            <h3 class="box-title"><u><b>INTERVIEW SCORE SHEET</b> </u><span id='processing'></span></h3>
                        </div>
                        <br />
                        <div align="center">
                            <h4 class="box-title"><u><b>ASSISTANT DIRECTOR, ADMINISTRATION, SGL 15 TO DEPUTY DIRECTOR,
                                        ADMINISTRATION, SGL 16</b> </u><span id='processing'></span></h4>
                        </div>
                        <br /><br />
                    </div>

                    <table class="table table-bordered table-striped table-responsive" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                {{-- <th>INTERVIEW NAME</th> --}}
                                <th>CANDIDATE NAME</th>
                                <th>APPEARANCE <br> (5 MARKS)</th>
                                <th>COMPORTMENT/SPOKEN ENGLISH <br> (5 MARKS)</th>
                                <th>5 QUESTIONS 2 MARKS EACH <br> (10 MARKS) </th>
                                <th>TOTAL SCORES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($getRecords) && $getRecords)
                                @foreach ($getRecords as $key => $list)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        {{-- <td>{{$list->title}}</td> --}}
                                        <td>{{ $list->surname . ' ' . $list->first_name . ' ' . $list->othernames }}</td>
                                        <td>{{ $list->appearance_mark }}</td>
                                        <td>{{ $list->comportment_mark }}</td>
                                        <td>{{ $list->question_each_mark }}</td>
                                        <td>{{ $list->total_mark }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>


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

@section('styles')
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
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
        }); //end document
    </script>
@endsection
