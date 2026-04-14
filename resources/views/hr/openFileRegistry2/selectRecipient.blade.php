@extends('layouts.layout')

@section('pageTitle')
    Incoming Mail
@endsection
<style type="text/css">
    .table {

        overflow-x: auto;
    }
</style>
@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <!--1st col-->
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span> </button>
                                <strong>Error!</strong>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if (session('msg'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span> </button>
                                <strong>Success!</strong> {{ session('msg') }}
                            </div>
                        @endif

                        @if (session('err'))
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span> </button>
                                <strong>Not Allowed ! </strong> {{ session('err') }}
                            </div>
                        @endif
                    </div>
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <!--2nd col-->

                        <!-- /.row -->
                        <form method="post" action="{{ url('/select-move-recipient') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $mailID }}">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="user">Select Recipient</label>
                                        <select name="user" id="user" class="form-control">
                                            @foreach ($users as $key => $user)
                                                <option value="{{ $user->ID }}">
                                                    {{ $user->title . ' ' . $user->surname . ' ' . $user->othernames . ' ' . $user->first_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                                    <button name="action" class="btn btn-success" type="submit"> Add Recipient </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>

    </div>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->



    </div>
    </div>


@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .select2 {
            width: 20vw !important;
        }

        .blink {
            animation: blinker 0.6s linear infinite;
            color: #1c87c9;
            font-size: 10px;
            font-weight: bold;
            font-family: sans-serif;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .input-group-btn {}

        #kiv {
            position: relative;
            z-index: 2;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/datepicker_scripts.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#searchName').attr("disabled", true);
            $("#autocomplete").autocomplete({
                serviceUrl: murl + '/open-file-registry/searchincoming',
                minLength: 2,
                onSelect: function(suggestion) {
                    $('#ownername').val(suggestion.data);
                    $('#searchName').attr("disabled", false);
                    //showAll();
                }
            });
        });
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
    <script type="text/javascript">
        $(function() {
            $(".date").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1910:2090', // specifying a hard coded year range
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: "dd MM, yy",
                //dateFormat: "D, MM d, yy",
                onSelect: function(dateText, inst) {
                    var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                    var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
                    $("#dte").val(dateFormatted);
                },
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $("table tr td .edit").click(function() {

                var sender = $(this).attr('sender');
                var attachments = JSON.parse($(this).attr('attachments'));

                var recieveddate = $(this).attr('recievedDate');
                var staffid = $(this).attr('staffid');
                var detail = $(this).attr('detail');
                var owner = $(this).attr('owner');
                var kiv = $(this).attr('kiv');
                var notifications = $(this).attr('notification');

                var owner = $(this).attr('owner');
                var id = $(this).attr('id');
                var organization = $(this).attr('organization');

                var timeOut = $(this).attr('timeOut');
                var timeIn = $(this).attr('timeIn');
                var dateOut = $(this).attr('toDate');

                $("#editModal").modal('show');
                $("#dateOuteds").val(dateOut);
                $("#senders").val(sender);
                $("#owner").val(owner);
                $("#kivs").val(kiv);
                $("#notifications").val(notifications);
                $("#details").val(detail);
                $("#dateRecieved").val(recieveddate);
                var location = "{{ asset('/sayofiles/') }}";


                $('#attachments').empty();
                $("#timeOutss").val(timeOut);
                $("#timeIns").val(timeIn);
                $("#organizations").val(organization);
                $("#itemID").val(id);

                for (var i = 0; i <= attachments.length; i++) {
                    var numero = attachments[i].attachmentID
                    var removelocation = "{{ route('removeAttachment', '') }}"
                    removelocation = removelocation + "/" + numero
                    $("#attachments").append("<div class='col-md-4'><img width='100%'src='" + location +
                        "/" + attachments[i].location + "'/><a href='" + removelocation +
                        "'>Remove</a></div>")
                };




            });


            $("table tr td .move").click(function() {
                var id = $(this).attr('id');


                var timeOut = $(this).attr('timeOut');


                var dateOut = $(this).attr('toDate');


                $("#dateOuted").val(dateOut);
                $("#timeOuts").val(timeOut);
                $("#itemIDs").val(id);


            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".sayo-add").click(function() {
                var lsthmtl = $(".clone").html();
                $("#increment").after(lsthmtl);
            });
            $("body").on("click", ".sayo-remove", function() {

                var father = $(this).closest(".hdtuto").remove()

            });

            $(".modal-sayo-add").click(function() {
                var lsthmtl = $(".sayo-clone").html();
                $("#sayo-increment").after(lsthmtl);
            });
            $("body").on("click", ".modal-sayo-remove", function() {
                console.log('here')
                $(this).closest(".hdtuto").remove();
            });
        });
    </script>
@endsection
