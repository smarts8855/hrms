@extends('layouts.layout')
@section('pageTitle')
    For numbers
@endsection
@section('content')
    <div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        <div class="box-body">
            <div class="row">

                <div class="col-md-12">
                    <!--1st col-->
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

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('err'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Not Allowed ! </strong>
                            {{ session('err') }}
                        </div>
                    @endif
                </div>

                <div class="col-md-8 col-md-offset-2">
                    <h3 style="font-size:14px;font-weight:bold;margin-bottom:-30px;"> PRESENT POST: ASSISTANT CLERICAL
                        OFFICER, SGL 03:</h3><br>
                    <h3 style="font-size:14px;font-weight:bold;margin-bottom:-30px;">NO OF EXISTING: ASSISTANT CLERICAL
                        OFFICER, SGL 03:</h3><br>
                    <h3 style="font-size:14px;font-weight:bold;margin-bottom:-30px;">NO OF ASSISTANT CLERICAL OFFICER, SGL
                        03 DUE FOR PROMOTION TO THE POST OF CLERICAL OFFICER II, SGL 04:</h3><br>
                    <h3 style="font-size:14px;font-weight:bold;margin-bottom:-30px;">ESTABLISMENT PROVISION: 1</h3><br>
                    <br>
                    <br>

                    <h3 style="font-size:14px;font-weight:bold;margin-bottom:0px;text-decoration:underline">
                        ASSISTANT CLERICAL OFFICER, SGL 03 DUE FOR PROMOTION TO THE POST OF CLERICAL OFFICER II, SGL 04</h3>
                </div>
            </div>
        </div>


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
                    {{-- <th data-priority="3">APER SCORE 20%</th>
                    <th data-priority="3">EXAM SCORE 60%</th>
                    <th data-priority="3">INTERVIEW SCORE 20%</th>
                    <th data-priority="3">TOTAL PERCENTAGE</th>
                    <th>CONFIRM PROMOTION</th> --}}
                </tr>
            </thead>
            <tbody>
                @if (isset($numbers))
                    @foreach ($numbers as $key => $number)
                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td>{{ $number->surname . ' ' . $number->othernames . ' ' . $number->first_name }}</td>
                            <td>{{ $number->appointment_date }}</td>
                            <td>{{ $number->date_of_confirmation }}</td>
                            <td>{{ $number->date_present_appointment }}</td>
                            <td>{{ $number->designationName }}</td>
                            <td>{{ $postPost }}</td>
                            {{--
                            @if (isset($promotionStatus))
                                <form method="POST" action="{{ route('saveUpdateForPromotion') }}" id="variableForm">
                                    @csrf
                                    <input type="hidden" value="{{ $number->promotionID }}" name="id">
                                    <input type="hidden" value="{{ $promotionStatus[0]->ID }}" name="promoid">
                                    <td><input type="number" id="aper" name="aper" class=" variables col-md-12 form-control"
                                            value="{{ $promotionStatus[0]->aper }}"></td>
                                    <td><input type="number" id="exam" name="exam" class=" variables col-md-12 form-control"
                                            value="{{ $promotionStatus[0]->exam }}"></td>
                                    <td><input type="number" id="interview" name="interview"
                                            class=" variables col-md-12 form-control"
                                            value="{{ $promotionStatus[0]->interview }}"></td>
                                    <td><input type="number" name="total" class="col-md-12 form-control"
                                            value="{{ $promotionStatus[0]->total }}"></td>
                                </form>
                            @else
                                <form method="POST" action="{{ route('saveForPromotion') }}" id="variableForm">
                                    @csrf
                                    <input type="hidden" value="{{ $number->promotionID }}" name="id">
                                    <td><input type="number" id="aper" name="aper" min="0" max="20"
                                            class=" variables col-md-12 form-control"></td>
                                    <td><input type="number" id="exam" name="exam" min="0" max="60"
                                            class=" variables col-md-12 form-control"></td>
                                    <td><input type="number" id="interview" name="interview" min="0" max="20"
                                            class=" variables col-md-12 form-control"></td>
                                    <td><input type="number" name="total" class="col-md-12 form-control"></td>
                                </form>
                            @endif

                            <td>
                                @if (isset($promotionStatus))
                                    @if ($promotionStatus[0]->status == 1)
                                        <a href="{{ route('viewPromotion', $numbers[0]->ID) }}">View</a>
                                    @else
                                        <button class="btn btn-success edit module" data-toggle="modal"
                                            data-target="#edit">Save</button>
                                    @endif
                                @endif
                            </td> --}}
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        @if (isset($numbers))
            @foreach ($numbers as $key => $number)
                <div class="row">
                    @if (isset($promotionStatus))
                        <form method="POST" action="{{ route('saveUpdateForPromotion') }}" id="variableForm">
                            @csrf
                            <input type="hidden" value="{{ $number->promotionID }}" name="id">
                            <input type="hidden" value="{{ $promotionStatus[0]->ID }}" name="promoid">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label class="" for="autoSizingInput">Aper Score 20%</label>
                                    <input type="number" class="variables form-control" id="aper" name="aper"
                                        value="{{ $promotionStatus[0]->aper }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="" for="autoSizingInput">Exam Score 50%</label>
                                    <input type="number" class=" variables form-control" id="exam" name="exam"
                                        value="{{ $promotionStatus[0]->exam }}">
                                </div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <label class="" for="autoSizingInput">Interview Score 20%</label>
                                    <input type="number" class="variables form-control" id="interview" name="interview"
                                        value="{{ $promotionStatus[0]->interview }}">
                                </div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <label class="" for="autoSizingInput">Oral Interview Score 10%</label>
                                    <input type="number" class="variables form-control" id="oralInterview"
                                        name="oralInterview" value="{{ $promotionStatus[0]->oral_interview }}">
                                </div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <label class="" for="autoSizingInput">Total Percentage %</label>
                                    <input type="number" class="form-control" name="total"
                                        value="{{ $promotionStatus[0]->total }}">
                                </div>

                            </div>
                        </form>
                    @else
                        <form method="POST" action="{{ route('saveForPromotion') }}" id="variableForm">
                            @csrf
                            <input type="hidden" value="{{ $number->promotionID }}" name="id">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label class="" for="autoSizingInput">Aper Score 20%</label>
                                    <input type="number" class="variables form-control" id="aper" name="aper"
                                        min="0" max="20">
                                </div>
                                <div class="col-md-6">
                                    <label class="" for="autoSizingInput">Exam Score 50%</label>
                                    <input type="number" class="variables form-control" id="exam" name="exam"
                                        min="0" max="50">
                                </div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <label class="" for="autoSizingInput">Interview Score 20%</label>
                                    <input type="number" class="form-control" id="interview" name="interview"
                                        min="0" max="20">
                                </div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <label class="" for="autoSizingInput">Oral Interview Score 10%</label>
                                    <input type="number" class="variables form-control" id="oralInterview"
                                        name="oralInterview" min="0" max="10">
                                </div>
                                <div class="col-md-6" style="margin-top: 10px;">
                                    <label class="" for="autoSizingInput">Total Percentage</label>
                                    <input type="number" class="form-control" name="total">
                                </div>

                            </div>
                        </form>
                    @endif

                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="col-md-6">
                            @if (isset($promotionStatus))
                                @if ($promotionStatus[0]->status == 1)
                                    <a href="{{ route('viewPromotion', $numbers[0]->ID) }}">View</a>
                                @else
                                    <button class="btn btn-success edit module" data-toggle="modal"
                                        data-target="#edit">Save</button>
                                @endif
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        @endif
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
