@extends('layouts.layout')
@section('pageTitle')
@endsection
@section('content')
    <div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border">
            <h3 class="box-title" style="font-weight:600; font-size:18px;">
                <i class="fa fa-users"></i> List of Shortlisted Staff Promotion
            </h3>
        </div>

        <div class="box box-success shadow">

            <div class="box-body" style="padding:25px;">

                {{-- Alert Messages --}}
                <div class="row">
                    <div class="col-md-12">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade in" role="alert"
                                style="border-radius: 6px;">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                <strong><i class="fa fa-exclamation-triangle"></i> Error!</strong>
                                @foreach ($errors->all() as $error)
                                    <p style="margin:4px 0;">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade in" role="alert"
                                style="border-radius: 6px;">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                <strong><i class="fa fa-check-circle"></i> Success!</strong>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('err'))
                            <div class="alert alert-warning alert-dismissible fade in" role="alert"
                                style="border-radius: 6px;">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                <strong><i class="fa fa-ban"></i> Not Allowed!</strong>
                                {{ session('err') }}
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Table --}}
                <div class="row">
                    <div class="col-md-12" id="report">
                        <div class="table-responsive" style="border-radius: 6px;">

                            <table id="datatable-buttons" class="table table-hover table-striped table-bordered"
                                style="background:#fff;">
                                <thead style="background:#f4f6f9; font-size:13px; font-weight:600;">
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Date of 1st Appt</th>
                                        <th>Date of Present Appointment</th>
                                        <th>Post Sought</th>
                                        <th>Department</th>
                                    </tr>
                                </thead>

                                <tbody style="font-size:13px;">
                                    @php $count = 1; @endphp

                                    @foreach ($shortlisted as $number)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $number->surname . ' ' . $number->othernames . ' ' . $number->first_name }}
                                            </td>
                                            <td>{{ formatDate($number->appointment_date) }}</td>
                                            <td>{{ formatDate($number->date_present_appointment) }}</td>
                                            <td>{{ $number->designationName }}</td>
                                            <td>{{ $number->department }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>

                {{-- Print Button --}}
                <div class="text-right" style="margin-top: 20px;">
                    <button type="button" class="btn btn-primary btn-sm" style="border-radius:6px;"
                        onclick="printReport()">
                        <i class="fa fa-print"></i> Print Report
                    </button>
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
                    <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{ route('saveViewPromotion') }}"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}

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
                    <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{ route('deleteTraining') }}">
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
            /* +90째: use 'tb-rl' */
            text-align: center;
            /* +90째: use 'right' */
            padding: 10px 5px 0;
        }
    </style>
@endsection
@section('scripts')
    <script>
        function printReport() {

            var divToPrint = document.querySelector('#report');
            var htmlToPrint = '' +
                '<style type="text/css">' +
                'table th, table td {' +
                'border:1px solid #000;' +
                'padding:0.5em;' +
                '}' +
                '</style>';
            htmlToPrint += divToPrint.outerHTML;
            newWin = window.open("");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
        }
    </script>
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
