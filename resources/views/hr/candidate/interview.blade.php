@extends('layouts.layout')
@section('pageTitle')
    <strong>New Appointment</strong>
@endsection

@section('content')
    <!-- Page Header -->
    @include('hr.partials.page-header')
    <!-- End Page Header -->
    <div style="padding-bottom: 20px;">
        <div class="box box-default">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">
                    <b>@yield('pageTitle')</b>
                    <i class="fa fa-arrow-right"></i>
                    <span id='processing'>
                        <strong><em>Initiate Interview For New Candidate.</em></strong>
                    </span>
                </h3>
            </div>

            @if (session('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span> </button>
                    <strong>Successful!</strong> {{ session('message') }}
                </div>
            @endif
            @if (session('error_message'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span> </button>
                    <strong>Error!</strong> {{ session('error_message') }}
                </div>
            @endif


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

            <form method="post" action="{{ route('saveInterview') }}" class="form-horizontal"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">

                    <div id="divIDx" style="margin-left:10px; margin-right:10px">
                        <div class="form-group">

                            <div class="row mb-3" style="margin: 10px">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Title:</label>
                                    <input class="form-control" name="title" id="title" type="text" value=""
                                        required>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Date:</label>
                                    <input class="form-control" name="date" id="date" type="date" value=""
                                        required placeholder="dd-mm-yyyy">
                                </div>
                            </div>


                            <!-- Container Row for Fields -->
                            <div class="fieldGroupContainer">

                                <div class="row mb-3 fieldGroup" style="margin:10px;">
                                    <!-- Document Description -->
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Document Description:</label>
                                        <input type="text" name="description[]" required class="form-control" />
                                    </div>

                                    <!-- Interview Documents | Memo -->
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Interview Documents | Memo:</label>
                                        <div class="input-group">
                                            <input type="file" name="filenames[]" class="form-control" />
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-success addMore">
                                                    <span class="glyphicon glyphicon-plus"></span> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Hidden copy for cloning -->
                            <div class="row mb-3 fieldGroupCopy" style="margin:10px; display:none;">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Document Description:</label>
                                    <input type="text" name="description[]" class="form-control" />
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Interview Documents | Memo:</label>
                                    <div class="input-group">
                                        <input type="file" name="filenames[]" class="form-control" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger remove" type="button">
                                                <span class="glyphicon glyphicon-remove"></span> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-2" style="margin-top:22px;">
                                <button type="submit" class="btn btn-success" name="Save">
                                    <i class="fa fa-btn fa-floppy-o"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>


    <div class="box box-default">

        {{-- end copy  --}}
        <div class="box box-primary custom-card">
            <div class="box-header with-border">
                <h3 class="box-title">Interview Schedule List</h3>
            </div>

            <div class="box-body">
                <div class="table-responsive" style="font-size: 12px; padding:10px;">
                    <table class="table table-bordered table-striped table-highlight table-responsive">
                        <thead>
                            <tr bgcolor="#c7c7c7">
                                <th width="1%">S/N</th>
                                <th>TITLE</th>
                                <th>SCHEDULE DATE</th> {{-- new --}}
                                <th>STATUS</th>
                                <th>VIEW</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        @php $serialNum = 1; @endphp

                        @foreach ($interviewDetails as $b)
                            <tr>
                                <td>{{ $serialNum++ }} </td>

                                <td>{{ $b->title }} </td>
                                <td>{{ date('d-M-Y', strtotime($b->date)) }}</td>
                                <td>
                                    @if ($b->interview_status == 0)
                                        <span class="badge badge-info"> Closed</span>
                                    @elseif($b->interview_status == 1)
                                        <span class="badge badge-success">In Progres</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('viewInterviewAndEdit', $b->interviewID) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i> </a>
                                </td>
                                <td>
                                    @if ($b->close_candidate == 0 && $b->interview_status == 1)
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-backdrop="false" data-target="#confirmEnable{{ $b->interviewID }}"><i
                                                class="fa fa-btn fa-stop"></i>
                                            Enable Candidate Entry</button>

                                        <!-- Modal to disable -->
                                        <div class="modal fade text-left d-print-none"
                                            id="confirmEnable{{ $b->interviewID }}" tabindex="-1" role="dialog"
                                            aria-labelledby="confirmToSubmit" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h4 class="modal-title text-white"><i class="ti-save"></i>
                                                            Confirm!</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-success text-center">
                                                            <h4>Are you sure you want to Enable Candidate Entry For:
                                                                {{ $b->title }}? </h4>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-info"
                                                            data-dismiss="modal">
                                                            Cancel </button>
                                                        <a href="{{ url('open-names-entering/' . $b->interviewID) }}"
                                                            class="btn btn-info"> Enable </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end Modal-->
                                    @elseif($b->close_candidate == 1 && $b->interview_status == 0)
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-backdrop="false" data-target="#confirmDisable{{ $b->interviewID }}"><i
                                                class="fa fa-btn fa-stop"></i> Disable Candidate Entry</button>

                                        <!-- Modal to disable -->
                                        <div class="modal fade text-left d-print-none"
                                            id="confirmDisable{{ $b->interviewID }}" tabindex="-1" role="dialog"
                                            aria-labelledby="confirmToSubmit" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h4 class="modal-title text-white"><i class="ti-save"></i>
                                                            Confirm!</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-success text-center">
                                                            <h4>Are you sure you want to Disable Candidate Entry For:
                                                                {{ $b->title }}? </h4>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-info"
                                                            data-dismiss="modal">
                                                            Cancel </button>
                                                        <a href="{{ url('close-names-entering/' . $b->interviewID) }}"
                                                            class="btn btn-danger"> Disable </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end Modal-->
                                    @endif

                                    @if ($b->interview_status == 1 && $b->close_candidate == 1)
                                        <a href="add-candidates/{{ $b->interviewID }}"><span
                                                class="btn btn-success btn-sm" style="margin-bottom: 3px;"> <i
                                                    class="fa fa-btn fa-plus"></i> Add
                                                Candidates</span></a>

                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-backdrop="false" data-target="#confirmDisable{{ $b->interviewID }}"><i
                                                class="fa fa-btn fa-stop"></i> Disable Candidate Entry</button>

                                        <!-- Modal to disable -->
                                        <div class="modal fade text-left d-print-none"
                                            id="confirmDisable{{ $b->interviewID }}" tabindex="-1" role="dialog"
                                            aria-labelledby="confirmToSubmit" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h4 class="modal-title text-white"><i class="ti-save"></i>
                                                            Confirm!</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-success text-center">
                                                            <h4>Are you sure you want to Disable Candidate Entry For:
                                                                {{ $b->title }}? </h4>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-info"
                                                            data-dismiss="modal">
                                                            Cancel </button>
                                                        <a href="{{ url('close-names-entering/' . $b->interviewID) }}"
                                                            class="btn btn-danger"> Disable </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end Modal-->
                                    @endif

                                    @if ($b->interview_status == 0 && $b->close_candidate == 0)
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-backdrop="false" data-target="#confirmOpen{{ $b->interviewID }}"><i
                                                class="fa fa-btn fa-stop"></i> Open Interview</button>

                                        <!-- Modal to disable -->
                                        <div class="modal fade text-left d-print-none"
                                            id="confirmOpen{{ $b->interviewID }}" tabindex="-1" role="dialog"
                                            aria-labelledby="confirmToSubmit" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h4 class="modal-title text-white"><i class="ti-save"></i>
                                                            Confirm!</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-success text-center">
                                                            <h4>Are you sure you want to Open: {{ $b->title }}? </h4>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-info"
                                                            data-dismiss="modal">
                                                            Cancel </button>
                                                        <a href="{{ url('open-interview/' . $b->interviewID) }}"
                                                            class="btn btn-info"> Open </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end Modal-->

                                        <a href="{{ route('candidates.interview', ['id' => $b->interviewID]) }}"
                                            class="btn btn-primary btn-sm" style="margin-bottom: 3px;">View Candidates</a>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-backdrop="false" data-target="#confirmClose{{ $b->interviewID }}"><i
                                                class="fa fa-btn fa-stop"></i> Close Interview</button>

                                        <!-- Modal to disable -->
                                        <div class="modal fade text-left d-print-none"
                                            id="confirmClose{{ $b->interviewID }}" tabindex="-1" role="dialog"
                                            aria-labelledby="confirmToSubmit" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h4 class="modal-title text-white"><i class="ti-save"></i>
                                                            Confirm!</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-success text-center">
                                                            <h4>Are you sure you want to Close Interview:
                                                                {{ $b->title }}?
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-info"
                                                            data-dismiss="modal">
                                                            Cancel </button>
                                                        <a href="{{ url('close-interview/' . $b->interviewID) }}"
                                                            class="btn btn-danger"> Close </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end Modal-->
                                    @endif

                                </td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('editor');
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var maxGroup = 10;

            // Add new group
            $(".addMore").click(function() {
                if ($('.fieldGroup').length < maxGroup) {
                    var fieldHTML = '<div class="row mb-3 fieldGroup" style="margin:10px;">' + $(
                        ".fieldGroupCopy").html() + '</div>';
                    $(".fieldGroupContainer").append(fieldHTML);
                } else {
                    alert('Maximum ' + maxGroup + ' groups are allowed.');
                }
            });

            // Remove group
            $("body").on("click", ".remove", function() {
                $(this).closest(".fieldGroup").remove();
            });
        });
    </script>
@endsection
