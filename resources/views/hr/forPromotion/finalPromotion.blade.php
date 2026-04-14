@extends('layouts.layout')
@section('pageTitle')
@endsection
@section('content')
    <div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        <div class="box-body">
            <div class="row">

                <div class="col-md-12"><!--1st col-->
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
                <div class="col-md-10 col-md-offset-1">
                    <h3 style="font-size:14px;font-weight:bold;margin-bottom:-30px;"> PRESENT POST: ASSISTANT CLERICAL
                        OFFICER, SGL 03:</h3><br>
                    <h3 style="font-size:14px;font-weight:bold;margin-bottom:-30px;">NO OF EXISTING: ASSISTANT CLERICAL
                        OFFICER, SGL 03:</h3><br>
                    <h3 style="font-size:14px;font-weight:bold;margin-bottom:-30px;">NO OF ASSISTANT CLERICAL OFFICER, SGL
                        03 DUE FOR PROMOTION TO THE POST OF CLERICAL OFFICER II, SGL 04:</h3><br>
                    <h3 style="font-size:14px;font-weight:bold;margin-bottom:-30px;">ESTABLISMENT PROVISION: 1</h3><br>
                    <br>
                    <br>

                    <h3 style="font-size:14px;font-weight:bold;margin-bottom:30px;text-decoration:underline">
                        ASSISTANT CLERICAL OFFICER, SGL 03 DUE FOR PROMOTION TO THE POST OF CLERICAL OFFICER II, SGL 04</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table style="" id="datatable-buttons" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th data-priority="1">
                                <p style="text-align:center">Name</p>
                            </th>
                            <th data-priority="3">DATE OF 1st APPT</th>
                            <th data-priority="3"><span>DATE OF<br> CONFIRMATION</span></th>
                            <th data-priority="3"><span>DATE OF LAST<br> PROMOTION</span></th>
                            <th data-priority="3"><span>PRESENT POST<br> SGL</span></th>
                            <th data-priority="3"><span>POST SOUGHT<br> SGL</span></th>
                            <th data-priority="3"><span>APER SCORE <br>20%</span></th>
                            <th data-priority="3"><span>EXAM SCORE<br> 50%</span></th>
                            <th data-priority="3"><span>INTERVIEW SCORE <br>20%</span></th>
                            <th data-priority="3"><span>ORAL INTERVIEW SCORE <br>10%</span></th>
                            <th data-priority="3"><span>TOTAL <br>PERCENTAGE</span></th>
                            <th>Highest Qualification</th>
                            <th>Remarks</th>
                            <th class="hidden-print">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($numbers))
                            <p style="display:none;">{{ $count = 0 }}</p>
                            @foreach ($numbers as $key => $number)
                                @if ($number->promoStatus == 1)
                                    <p style="display:none;">{{ $count = $count + 1 }}</p>
                                    <tr>
                                        <th>{{ $count }}</th>
                                        <td>{{ $number->surname . ' ' . $number->othernames . ' ' . $number->first_name }}
                                        </td>
                                        <td>
                                            {{ formatDate($number->appointment_date) }}
                                        </td>
                                        <td>{{ formatDate($number->date_of_confirmation) }}</td>
                                        <td>{{ formatDate($number->date_present_appointment) }}</td>
                                        <td>{{ $number->designationName }}</td>
                                        <td>{{ $number->postPost }}</td>
                                        <td>{{ $number->aper }}</td>
                                        <td>{{ $number->exam }}</td>
                                        <td>{{ $number->interview }}</td>
                                        <td>{{ $number->oral_interview }}</td>
                                        <td>{{ $number->total }}</td>

                                        <td>{{ $number->qualification }}</td>
                                        <td>{{ $number->remark }}</td>
                                        <td>
                                            @if ($number->confirmed_promoted == 0)
                                                <a href="javascript:void()"
                                                    class="btn btn-primary btn-xs waves-effect waves-light hidden-print confirmPromotion"
                                                    staffid="{{ $number->staffid }}"> Confirm Promotion </a>
                                            @else
                                                <span>Promoted</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
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
                    <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{ route('saveViewPromotion') }}"
                        enctype="multipart/form-data">
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

    <!-- confirm Promotion -->
    <form method="post" action="{{ url('/confirm/promotion') }}">
        {{ csrf_field() }}
        <div id="confirmPromotionModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <p id="message"></p>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="staffid" id="sid" />
                        <h4> Do you want to confirm that this staff is promoted ?</h4>
                        <h5> By clicking yes you affirm that this staff has been successfull in all promotion exercise
                            organised by the council.</h5>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary save" staffDataID="" id="save">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- confirm Promotion -->
@endsection

@section('styles')
    <style>
        th span {
            writing-mode: vertical-rl;
            /* +90°: use 'tb-rl' */
            text-align: center;
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
            if (aper != "" && exam != "" && interview != "") {
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

    <script type="text/javascript">
        $(document).ready(function() {
            $("table tr td .confirmPromotion").on('click', function() {
                var id = $(this).attr('staffid');
                $('.save').attr('staffDataID', id);
                $('#sid').val(id);
                $("#confirmPromotionModal").modal('show');
            });

            $(".save").on('click', function() {
                var id = $(this).attr('staffDataID');
                var position = $('#postionConsidered').val();
                var year = $('#promotionYear').val();
                $('#shortlist' + id).html('Processing....')
                $.ajax({

                    url: "{{ url('/confirm/promotion') }}",

                    type: "post",
                    data: {
                        'staffid': id,
                        'promotionYear': year,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {

                        $('#message').html(data);
                        //location.reload(true);
                        $('#shortlist' + id).html(
                            '<span class="text-success">Shortlisted</span>')
                    }
                });


            });
        });
    </script>
@endsection
