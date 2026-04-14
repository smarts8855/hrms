@extends('layouts.layout')
@section('pageTitle')
    <strong>Edit Interview: {{ $interview->title }}</strong>

    {{-- <p style="margin-top:5px;">Date: {{ date('d-M-Y', strtotime($newDate)) }}</p> --}}
@endsection

@section('content')
    <!-- Page Header -->
    @include('hr.partials.page-header')
    <!-- End Page Header -->
    <div style="padding-bottom: 20px;">
        <div class="box box-default">
            <div class="box-header with-border hidden-print">
                <div class="row">
                    <div class="col-xs-6">
                        <h3 class="box-title">@yield('pageTitle') <span id="processing"></span></h3>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="{{ url('/interview') }}">
                            <button type="button" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back</button>
                        </a>

                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="false"
                            data-target="#confirmToDelete{{ $interview->interviewID }}">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            Delete Interview</button>
                    </div>
                </div>
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

            <form method="post" action="{{ route('updateInterview', $interview->interviewID) }}" class="form-horizontal"
                enctype="multipart/form-data">
                {{ csrf_field() }} @method('PUT')
                <div class="box-body">

                    <div id="divIDx" style="margin-left:10px; margin-right:10px">
                        <div class="form-group">

                            <div class="row mb-3" style="margin: 10px">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Title:</label>
                                    <input class="form-control" name="title" id="title" type="text"
                                        value="{{ $interview->title }}" required>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Date:</label>
                                    <input class="form-control" name="date" id="date" type="date"
                                        value="{{ $interview->date }}">
                                </div>
                            </div>

                            <div class="fieldGroupContainer">
                                <div class="row mb-3 fieldGroup" style="margin:10px;">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Document Description:</label>
                                        <input type="text" name="description[]" class="form-control" />
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Interview Documents:</label>
                                        <div class="input-group">
                                            <input type="file" name="filenames[]" class="form-control" />
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-success addMore"><span
                                                        class="fldemo glyphicon glyphicon glyphicon-plus"
                                                        aria-hidden="true"></span>
                                                    Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8" style="margin-top:22px;">
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-success pull-left" name="Save">
                                        <i class="fa fa-btn fa-floppy-o"></i> Update Interview
                                    </button>
                                </div>

                            </div>

                        </div>

                    </div>

            </form>

            <!-- Hidden copy for cloning -->
            <div class="row mb-3 fieldGroupCopy" style="margin:10px; display:none;">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <label>Document Description:</label>
                    <input type="text" name="description[]" class="form-control" />
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <label>Interview Documents:</label>
                    <div class="input-group">
                        <input type="file" name="filenames[]" class="form-control" />
                        <div class="input-group-btn">
                            <button class="btn btn-danger remove"><span class="glyphicon glyphicon glyphicon-remove"
                                    aria-hidden="true"></span> Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end copy  --}}

            <div class="row">
                <div class="col-md-12">
                    <!-- Modal to delete -->
                    <div class="modal fade text-left d-print-none" id="confirmToDelete{{ $interview->interviewID }}"
                        tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-success text-center">
                                        <h4>Are you sure you want to delete this Interview? </h4>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel
                                    </button>
                                    <a href="{{ url('delete-candidate-interview/' . $interview->interviewID) }}"
                                        class="btn btn-danger"> Delete </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end Modal-->

                </div>

            </div>

            @if (session('memo'))
                @include('candidate.modals.memo');
            @endif
        </div>
    </div>


    <div class="box box-default">

        {{-- end copy  --}}
        <div class="box box-primary custom-card">
            <div class="box-header with-border">
                <h3 class="box-title text-uppercase">INTERVIEW DOCUMENTS List</h3>
            </div>

            <div class="box-body">
                <div class="table-responsive" style="font-size: 12px; padding:10px;">
                    <table class="table table-bordered table-striped table-highlight table-responsive">
                        <thead>
                            <tr bgcolor="#c7c7c7">
                                <th width="1%">S/N</th>

                                <th>DESCRIPTION</th>
                                <th>ATTACHMENT</th>

                                <th>ACTION</th>
                            </tr>
                        </thead>
                        @php $serialNum = 1; @endphp


                        @forelse ($interviewAttachments as $key => $b)
                            <tr>
                                <td>{{ $serialNum++ }} </td>
                                <td>
                                    {{ $b->description }}
                                </td>
                                <td>
                                    <a href="{{ asset('interviewAttachmentfiles/' . $b->attachment) }}" target="_blank">
                                        <button type="button" class="btn btn-primary btn-sm">View Attached
                                            Document</button> </a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-backdrop="false" data-target="#confirmToSubmit{{ $key }}"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            </tr>

                            <!-- Modal to delete -->
                            <div class="modal fade text-left d-print-none" id="confirmToSubmit{{ $key }}"
                                tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-success text-center">
                                                <h4>Are you sure you want to delete this Document Attachment? </h4>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-info" data-dismiss="modal">
                                                Cancel </button>
                                            <a href="{{ url('delete-interview-document/' . $b->id) }}"
                                                class="btn btn-danger"> Delete </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end Modal-->


                        @empty
                            <tr><em>No Documents Attached</em></tr>
                        @endforelse
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
