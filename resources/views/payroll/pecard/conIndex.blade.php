@extends('layouts.layout')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@section('pageTitle')
    PE-Card
@endsection
@section('content')
    <style>
        .panel {
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .panel-heading {
            border-radius: 10px 10px 0 0;
        }

        .btn {
            border-radius: 5px;
        }
    </style>

    {{-- <div id="" class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:0 5px;">
            <h3 class="text-center"> PE-Card</h3>
            <hr style="border: 2px solid green">



        </div>



        <!-- Card (Bootstrap 3 uses panel) -->
        <div class="panel panel-default">


            <div class="panel-body">
                <form method="POST" action="{{ url('/con-pecard/view') }}">
                    {{ csrf_field() }}

                    <!-- ALERT MESSAGES -->
                    <div class="col-md-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Error!</strong>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Success!</strong> {{ session('message') }}
                            </div>
                        @endif

                        @if (session('err'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Error!</strong> {{ session('err') }}
                            </div>
                        @endif
                    </div>

                    <div class="clearfix"></div>
                    <br>

                    <!-- FORM CONTENT -->
                    <div class="row">

                        <!-- COURT SELECTION -->
                        @if ($CourtInfo->courtstatus == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Court</label>
                                    <select name="court" id="court" class="form-control">
                                        <option value="">Select Court</option>
                                        @foreach ($courts as $court)
                                            <option value="{{ $court->id }}"
                                                {{ $court->id == session('anycourt') ? 'selected' : (old('court') == $court->id ? 'selected' : '') }}>
                                                {{ $court->court_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <input type="hidden" id="court" name="court" value="{{ $CourtInfo->courtid }}">
                        @endif

                        <!-- DIVISION -->
                        @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Division</label>
                                    <select name="division" id="division_" class="form-control">
                                        <option value="">Select Division</option>
                                        @foreach ($courtDivisions as $divisions)
                                            <option value="{{ $divisions->divisionID }}">{{ $divisions->division }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Division</label>
                                    <input type="text" class="form-control" id="divisionName" name="divisionName"
                                        value="{{ $curDivision->division }}" readonly>
                                </div>
                            </div>
                            <input type="hidden" id="division" name="division" value="{{ Auth::user()->divisionID }}">
                        @endif

                        <!-- STAFF NAME -->
                        @if ($CourtInfo->courtstatus == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="staff">Staff Name</label>
                                    <select name="staffName" class="form-control">
                                        <option value="">Select Staff</option>
                                        @foreach ($staff as $lists)
                                            <option value="{{ $lists->ID }}">{{ $lists->surname }}
                                                {{ $lists->first_name }} {{ $lists->othernames }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Staff Name</label>
                                    <input type="text" id="user" autocomplete="off" name='staffName'
                                        list="enrolledUsers" class="form-control" onchange="StaffSearchReload()">
                                    <datalist id="enrolledUsers">
                                        @foreach ($staffData as $b)
                                            <option value="{{ $b->ID }}">{{ $b->fileNo }}: {{ $b->surname }}
                                                {{ $b->first_name }} {{ $b->othernames }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                @foreach ($staffData as $b)
                                    <input type="hidden" id="id{{ $b->ID }}"
                                        value="{{ $b->fileNo }}: {{ $b->surname }} {{ $b->first_name }} {{ $b->othernames }}">
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Staff Name</label>
                                    <input type="hidden" id="fileNo" name="fileNo">
                                    <input type="text" id="staffname" class="form-control" readonly />
                                </div>
                            </div>
                        @endif

                        <!-- YEAR -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Year</label>
                                <select name="year" id="section" class="form-control">
                                    <option value="">Select Year</option>
                                    @for ($i = 2010; $i <= 2040; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- SUBMIT BUTTON -->
                        <div class="col-md-6">
                            <div class="form-group" style="margin-top:25px;">
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fa fa-eye"></i> Display
                                </button>
                            </div>
                        </div>

                    </div><!-- /row -->
                </form>
            </div><!-- /panel-body -->
        </div><!-- /panel -->

    </div> --}}

    <div class="container">
        <div class="panel panel-default" style="border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); border:none;">
            <div class="panel-heading text-center"
                style="background-color:#f5f5f5; border-bottom:2px solid #4cae4c; border-top-left-radius:10px; border-top-right-radius:10px;">
                <h3 class="panel-title" style="font-weight:bold; color:#333;">PE-Card</h3>
            </div>

            <div class="panel-body">
                <form method="POST" action="{{ url('/con-pecard/view') }}">
                    {{ csrf_field() }}

                    <!-- ALERT MESSAGES -->
                    <div class="col-md-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                <strong>Error!</strong>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                <strong>Success!</strong> {{ session('message') }}
                            </div>
                        @endif

                        @if (session('err'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                <strong>Error!</strong> {{ session('err') }}
                            </div>
                        @endif
                    </div>

                    <div class="clearfix"></div>
                    <hr>

                    <!-- FORM CONTENT -->
                    <div class="row">

                        <!-- COURT -->
                        @if ($CourtInfo->courtstatus == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Court</label>
                                    <select name="court" id="court" class="form-control">
                                        <option value="">Select Court</option>
                                        @foreach ($courts as $court)
                                            <option value="{{ $court->id }}"
                                                {{ $court->id == session('anycourt') ? 'selected' : (old('court') == $court->id ? 'selected' : '') }}>
                                                {{ $court->court_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <input type="hidden" id="court" name="court" value="{{ $CourtInfo->courtid }}">
                        @endif

                        <!-- DIVISION -->
                        @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Division</label>
                                    <select name="division" id="division_" class="form-control">
                                        <option value="">Select Division</option>
                                        @foreach ($courtDivisions as $divisions)
                                            <option value="{{ $divisions->divisionID }}">{{ $divisions->division }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Division</label>
                                    <input type="text" class="form-control" id="divisionName" name="divisionName"
                                        value="{{ $curDivision->division }}" readonly>
                                </div>
                            </div>
                            <input type="hidden" id="division" name="division" value="{{ Auth::user()->divisionID }}">
                        @endif

                        <!-- STAFF -->
                        @if ($CourtInfo->courtstatus == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="staff">Staff Name</label>
                                    <select name="staffName" class="form-control">
                                        <option value="">Select Staff</option>
                                        @foreach ($staff as $lists)
                                            <option value="{{ $lists->ID }}">{{ $lists->surname }}
                                                {{ $lists->first_name }} {{ $lists->othernames }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Staff Name</label>
                                    <input type="text" id="user" autocomplete="off" name='staffName'
                                        list="enrolledUsers" class="form-control" onchange="StaffSearchReload()">
                                    <datalist id="enrolledUsers">
                                        @foreach ($staffData as $b)
                                            <option value="{{ $b->ID }}">{{ $b->fileNo }}: {{ $b->surname }}
                                                {{ $b->first_name }} {{ $b->othernames }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                @foreach ($staffData as $b)
                                    <input type="hidden" id="id{{ $b->ID }}"
                                        value="{{ $b->fileNo }}: {{ $b->surname }} {{ $b->first_name }} {{ $b->othernames }}">
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Staff Name</label>
                                    <input type="hidden" id="fileNo" name="fileNo">
                                    <input type="text" id="staffname" class="form-control" readonly />
                                </div>
                            </div>
                        @endif

                        <!-- YEAR -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Year</label>
                                <select name="year" id="section" class="form-control">
                                    <option value="">Select Year</option>
                                    @for ($i = 2025; $i <= 2040; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- SUBMIT BUTTON -->
                        <div class="col-md-6">
                            <div class="form-group" style="margin-top:25px;">
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fa fa-eye"></i> Display
                                </button>
                            </div>
                        </div>

                    </div><!-- /row -->
                </form>
            </div><!-- /panel-body -->
        </div><!-- /panel -->
    </div>


@endsection
<!--@section('styles')-->

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        (function() {
            $('#user').change(function() {

                var myuser = $('#user').val();
                document.getElementById('staffname').value = document.getElementById('id' + myuser).value;
                $('#fileNo').val(myuser);
            });
        })();
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#division').change(function() {
                //alert('ok')
                var d = 'division';
                $.ajax({
                    url: murl + '/division/session',
                    type: "post",
                    data: {
                        'division': $('#division').val(),
                        'val': d,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        console.log(data);
                        location.reload(true);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#staffName').change(function() {
                //alert('ok')
                var s = 'staff';
                $.ajax({
                    url: murl + '/division/session',
                    type: "post",
                    data: {
                        'staff': $('#staffName').val(),
                        'val': s,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        console.log(data);
                        location.reload(true);
                    }
                });
            });
        });
    </script>

    {{-- ///////////////////////////////////// --}}

    <script type="text/javascript">
        $(document).ready(function() {
            // alert('danger')

            $('select[name="division"]').on('change', function() {
                var division_id = $(this).val();
                // alert(division_id)

                if (division_id) {
                    $.ajax({
                        url: "{{ url('/division/staff/ajax') }}/" + division_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(1111111111, data);
                            var d = $('select[name="staffName"]').html('');
                            $.each(data, function(key, value) {
                                $('select[name="staffName"]').append(`<option value=${value.ID}>
                              ${value.surname}  ${value.first_name}  ${value.othernames}  </option>`);
                            });
                        }
                    });
                } else {
                    alert('danger')
                }

            }); // end sub category

        });
    </script>
    {{-- ///////////////////////////////////// --}}
@endsection
