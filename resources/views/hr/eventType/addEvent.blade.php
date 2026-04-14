@extends('layouts.layout')
@section('pageTitle')
    Self Service
@endsection

@section('content')
    <div class="row">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'>
                    <strong><em>Apply for Event</em></strong> </span></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

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

            @if (session('msg'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <strong>Success!</strong>
                    {!! session('msg') !!}
                </div>
            @endif

            @if (session('err'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <strong>Error Occured!</strong>
                    {!! session('err') !!}
                </div>
            @endif



            <div class="box-body" style="background-color:white;">
                <form method="post" action="{{ url('/applyevent/save') }}" id="form1">
                    {{ csrf_field() }}
                    <!--hidden field for updating record-->

                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="hidden" name="staffid" id="userid" class="form-control input-lg"
                                value="{{ Auth::user()->id }}" />
                            <label label for="">Surname</label>
                            <input type="text" name="surname" id="name" class="form-control input-lg"
                                value="{{ $userinfo->surname }}" readonly />
                        </div>

                        <div class="col-md-6">
                            <label label for="">Firstname</label>
                            <input type="text" name="firstname" id="firstname" class="form-control input-lg"
                                value="{{ $userinfo->first_name }}" readonly />
                        </div>
                        </br>
                        <div class="col-md-6">
                            <label label for="">Event Type</label>
                            <select class="form-control input-md dynamic" id="event_id" name="eventid" required />
                            <option>-Select Event-</option>
                            @foreach ($getAllEvent as $list)
                                <option value="{{ $list->id }}">{{ $list->event_type }}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="Description">Description</label>
                            <textarea class="form-control" id="description" rows="3" name="description" required /></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Venue</label>
                            <input type="text" id="inputCity" class="form-control input-lg" name="venue" required />
                        </div>
                        <div class="form-group col-md-3" data-provide="datepicker">
                            <label for="start">Start Date</label>
                            <input type="text" id="datepicker" class="form-control input-lg" name="start" required />
                        </div>

                        <div class="form-group col-md-3" data-provide="datepicker">
                            <label for="end">End Date</label>
                            <input type="text" id="datepicker2" class="form-control input-lg" name="end" required />
                        </div>

                        <center>
                            <div>
                                <button type="submit" name="button" class="btn btn-sm btn-info">Apply</button>
                            </div>
                        </center>
                    </div>
                </form>
                </br>
                <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                    <table id="mytable" class="table table-hover table-bordered table-striped table-highlight">
                        <thead>
                            <tr bgcolor="#c7c7c7">
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Event Type</th>
                                <th>Event Description</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Cancel</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php $i=1; @endphp

                            @foreach ($getEventOfUser as $key => $list)
                                <tr>
                                    <td>{{ $i++ }} </td>
                                    <td value="{{ $list->staffid }}">{{ $list->surname . ' ' . $list->first_name }}</td>
                                    <td>{{ $list->event_type }} </td>
                                    <td>{{ $list->description }}</td>
                                    <td>{{ date('d-M-Y', strtotime($list->event_start_date)) }}</td>
                                    <td>{{ date('d-M-Y', strtotime($list->event_end_date)) }}</td>
                                    <td>{{ $list->number_of_days }} working days</td>
                                    <td>
                                        @if ($list->event_status == 0)
                                            <button type="button" class="btn btn-primary btn-sm">Pending</button>
                                        @elseif ($list->event_status == 1)
                                            <button type="button" class="btn btn-success btn-sm">Approved</button>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="false" data-target="#deleteEvent{{$list->staffEventId }}"><i class="fa fa-trash"></i></button>
                                    </td>

                                </tr>

                                <!-- Modal to delete -->
                                <form action='{{url("/delete/$list->staffid/$list->staffEventId")}}' method="get">
                                    @csrf
                                    <div class="modal fade text-left d-print-none" id="deleteEvent{{ $list->staffEventId }}"
                                        tabindex="-1" role="dialog" aria-labelledby="deleteEvent" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm! </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-success text-center">
                                                        <h4>Are you sure you want to delete this {{$list->event_type}} Event? </h4>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-info" data-dismiss="modal">
                                                        Cancel </button>
                                                    <button type="submit" id="confirmRemoveEvent" class="btn btn-success">
                                                            Confirm </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end Modal-->

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        <script src = "https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  

    <script>
        $(function() {
            $("#datepicker").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });

        $(function() {
            $("#datepicker2").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
    <script>
        function funcDelete(x, y) {
            // alert(y);
            var i = confirm("Do you want to delete?");
            if (i == true) {
                //delete
                document.location = "/delete/" + x + "/" + y;
            } else {
                //do nothing
            }
        }
    </script>
@endsection
