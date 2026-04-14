@extends('layouts.layout')
@section('pageTitle')
    For numbers
@endsection
@section('content')
    <div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        <div class="box box-success">
            <div class="box-body">
                <div class="row">

                    {{-- Alerts --}}
                    <div class="col-md-12">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <strong>Error!</strong>
                                <ul style="margin:0; padding-left: 20px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                        @endif

                        @if (session('err'))
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <strong>Not Allowed!</strong> {{ session('err') }}
                            </div>
                        @endif
                    </div>

                    {{-- Info Section --}}
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="text-bold" style="margin-bottom:5px;">PRESENT POST: ASSISTANT CLERICAL OFFICER, SGL 03
                        </h4>
                        <h4 class="text-bold" style="margin-bottom:5px;">NO OF EXISTING: ASSISTANT CLERICAL OFFICER, SGL 03
                        </h4>
                        <h4 class="text-bold" style="margin-bottom:5px;">NO OF ASSISTANT CLERICAL OFFICER, SGL 03 DUE FOR
                            PROMOTION TO THE POST OF CLERICAL OFFICER II, SGL 04</h4>
                        <h4 class="text-bold" style="margin-bottom:5px;">ESTABLISHMENT PROVISION: 1</h4>

                        <br><br>

                        <h4 class="text-bold text-center" style="text-decoration:underline;">
                            ASSISTANT CLERICAL OFFICER, SGL 03 DUE FOR PROMOTION TO THE POST OF CLERICAL OFFICER II, SGL 04
                        </h4>
                    </div>
                </div>

                <div class="table-responsive" id="tableID">
                    <table style="padding-left:30px" id="datatable-buttons" class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th data-priority="1">Name</th>
                                <th data-priority="3">DATE OF 1st APPT</th>
                                <th><span>DATE OF CONFIRMATION</span></th>
                                <th data-priority="3">DATE OF LAST PROMOTION</th>
                                <th data-priority="3">PRESENT POST SGL</th>
                                <th data-priority="3">POST SOUGHT SGL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($numbers))
                                @foreach ($numbers as $key => $number)
                                    <tr>
                                        <th>{{ $key + 1 }}</th>
                                        <td>{{ $number->surname . ' ' . $number->othernames . ' ' . $number->first_name }}
                                        </td>
                                        <td>{{ $number->appointment_date }}</td>
                                        <td>{{ $number->date_of_confirmation }}</td>
                                        <td>{{ $number->date_present_appointment }}</td>
                                        <td>{{ $number->designationName }}</td>
                                        <td>{{ $postPost }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border">
                <h4 class="box-title text-uppercase">
                    Enter Candidate Scores
                </h4>
            </div>
            <div class="box box-primary">
                <div class="box-body">
                    @if (isset($numbers))
                        @foreach ($numbers as $key => $number)
                            <div class="row">
                                @if (isset($promotionStatus))
                                    <form method="POST" action="{{ route('saveUpdateForPromotion') }}" id="variableForm">
                                        @csrf
                                        <input type="hidden" value="{{ $number->promotionID }}" name="id">
                                        <input type="hidden" value="{{ $promotionStatus[0]->ID }}" name="promoid">
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <label class="" for="autoSizingInput">Aper Score
                                                    20%</label>
                                                <input type="number" class="variables form-control" id="aper"
                                                    name="aper" value="{{ $promotionStatus[0]->aper }}"
                                                    @if ($number->confirmedPromoted == 1) disabled @endif>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="" for="autoSizingInput">Exam Score
                                                    50%</label>
                                                <input type="number" class=" variables form-control" id="exam"
                                                    name="exam" value="{{ $promotionStatus[0]->exam }}"
                                                    @if ($number->confirmedPromoted == 1) disabled @endif>
                                            </div>
                                            <div class="col-md-4" style="margin-top: 10px;">
                                                <label class="" for="autoSizingInput">Interview Score
                                                    20%</label>
                                                <input type="number" class="variables form-control" id="interview"
                                                    name="interview" value="{{ $promotionStatus[0]->interview }}"
                                                    @if ($number->confirmedPromoted == 1) disabled @endif>
                                            </div>
                                            <div class="col-md-4" style="margin-top: 10px;">
                                                <label class="" for="autoSizingInput">Oral Interview
                                                    Score 10%</label>
                                                <input type="number" class="variables form-control" id="oralInterview"
                                                    name="oralInterview" value="{{ $promotionStatus[0]->oral_interview }}"
                                                    @if ($number->confirmedPromoted == 1) disabled @endif>
                                            </div>
                                            <div class="col-md-4" style="margin-top: 10px;">
                                                <label class="" for="autoSizingInput">
                                                    Total Percentage %</label>
                                                <input type="number" class="form-control" name="total"
                                                    value="{{ $promotionStatus[0]->total }}"
                                                    @if ($number->confirmedPromoted == 1) disabled @endif>
                                            </div>

                                            <div class="col-md-4" style="margin-top: 10px;">
                                                <label class="" for="">&nbsp;</label>
                                                @if (isset($promotionStatus))
                                                    @if ($promotionStatus[0]->status == 1)
                                                        <a href="{{ route('viewPromotion', $numbers[0]->ID) }}"
                                                            target="_blank"
                                                            class="form-control btn btn-primary waves-effect waves-light">View</a>
                                                    @else
                                                        {{-- <button class="btn btn-success edit module form-control"
                                                            data-toggle="modal" data-target="#edit">Save</button> --}}
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('saveForPromotion') }}" id="variableForm">
                                        @csrf
                                        <input type="hidden" value="{{ $number->promotionID }}" name="id">
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <label class="" for="autoSizingInput">Aper Score
                                                    20%</label>
                                                <input type="number" class="variables form-control" id="aper"
                                                    name="aper" min="0" max="20">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="" for="autoSizingInput">Exam Score
                                                    50%</label>
                                                <input type="number" class="variables form-control" id="exam"
                                                    name="exam" min="0" max="50">
                                            </div>
                                            <div class="col-md-4" style="margin-top: 10px;">
                                                <label class="" for="autoSizingInput">Interview
                                                    Score 20%</label>
                                                <input type="number" class="form-control" id="interview"
                                                    name="interview" min="0" max="20">
                                            </div>
                                            <div class="col-md-4" style="margin-top: 10px;">
                                                <label class="" for="autoSizingInput">Oral Interview
                                                    Score
                                                    10%</label>
                                                <input type="number" class="variables form-control" id="oralInterview"
                                                    name="oralInterview" min="0" max="10">
                                            </div>
                                            <div class="col-md-4" style="margin-top: 10px;">
                                                <label class="" for="autoSizingInput">Total
                                                    Percentage</label>
                                                <input type="number" class="form-control" name="total">
                                            </div>

                                        </div>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Modal -->
    <div id="edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Save</h5>

                </div>
                <div class="modal-body">
                    <form class="row gy-2 gx-3 align-items-center" method="POST"
                        action="{{ route('saveViewPromotion') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $numbers[0]->promotionID }}" name="id">
                        <div class="col-sm-12 mb-3">
                            <label class="" for="autoSizingInput">Highest Qualification</label>
                            <input type="text" class="form-control" id="qualification" name="qualification"
                                value="{{ old('qualification') }}">
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label class="" for="autoSizingSelect">Remark</label>
                            <textarea name="remark" class="form-control"></textarea>

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Edit Modal -->

    <!-- Delete Modal -->
    <div id="delete" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Delete Variable</h5>

                </div>


                <div class="modal-body">
                    <form class="row gy-2 gx-3 align-items-center" method="POST"
                        action="{{ route('deleteTraining') }}">
                        {{ csrf_field() }}
                        <p style="margin-left:30px">Are you sure you would like to delete this Training ? </p>
                        <input type="hidden" name="id" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- End Delete Modal -->


@endsection
@section('style')
    <style>
        th span {
            writing-mode: sideways-lr;
            /* +90°: use 'tb-rl' */
            text-align: left;
            /* +90°: use 'right' */
            padding: 10px 5px 0;
        }
    </style>
@endsection
@section('scripts')
    <script type='text/javascript'>
        $('.variables').on('change', function() {
            var aper = $('#aper').val()

            var exam = $('#exam').val()
            var interview = $('#interview').val();
            var oralInterview = $('#oralInterview').val();
            if (aper != "" && exam != "" && interview != "" && oralInterview != "") {
                $("#variableForm").submit();
            }
        })

        $('.module').on('click', function() {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var date = $(this).attr('data-date');
            $('#name').val(name);
            $('#id').val(id);
            $('#date').val(date);
        })

        $('.delete_module').on('click', function() {
            var id = $(this).attr('data-id');
            $('#delete_id').val(id);
        })
    </script>
@endsection
