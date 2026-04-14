<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.layout')
@section('pageTitle')
    <strong>TRAINING</strong>
@endsection
@section('content')
    <div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>Head of Admin, Forward/Approve.</em></strong> </span></h3>
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


                <h4 class="text-center"><strong>All Training </strong></h4>
                <p class="card-title-desc"></p>

                <div class="table-responsive">
                <table style="padding-left:30px; margin-bottom:150px" id="datatable-buttons" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SN</th>

                            <th data-priority="1">NAME</th>

                            <th data-priority="3">ATTACHMENT</th>
                            <th data-priority="3">FROM</th>
                            <th data-priority="3">LOCATION</th>
                            <th>COMMENT</th>
                            <th>ACTION</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($trainings))
                            @foreach ($trainings as $key => $training)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $training->title }}</td>

                                    <td><a target="__blank"
                                            href="{{ asset('/trainingAttachment/' . $training->attachment) }}">Preview</a>
                                    </td>

                                    <td>{{$training->name}}</td>
                                    
                                    <td>
                                        @if ($training->tStatus == 2)
                                            Head Admin
                                        @elseif($training->tStatus == 3)
                                            Secretary
                                        @elseif($training->tStatus == 4)
                                            Head Of Training
                                        @elseif($training->tStatus == 12)
                                            Approved
                                        @endif
                                    </td>

                                    <td>
                                        <button class="btn btn-success btn-sm btnComment" id="viewComment" data-id="{{$training->ID}}" data-toggle="modal" data-target="#commentModal">View Comment</button>
                                    </td>

                                    <td class="row align-items-center">
                                        @if ($userDet->action_stageID == 3 && $training->approval_status == 0 && $training->tStatus != 3)
                                            {{-- <a href="#" data-toggle="modal" class="text-primary module" data-toggle="modal"
                                                data-target="#edit" data-id="{{ $training->ID }}">Push To Secretary | </a> --}}

                                                <a href="#" data-toggle="modal" class="btn btn-sm btn-info text-warning push_module"
                                                data-toggle="modal" data-target="#push"
                                                data-id="{{ $training->ID }}">Forward Training </a>

                                        @elseif($userDet->action_stageID == 3 && $training->approval_status == 1  && $training->tStatus != 6)
                                            {{-- <a href="#" data-toggle="modal" class="text-warning push_module"
                                                data-toggle="modal" data-target="#push" data-id="{{ $training->ID }}">Push
                                                To Director Training | </a> --}}

                                                <a href="#" data-toggle="modal" class="btn btn-sm btn-info text-warning push_module"
                                                data-toggle="modal" data-target="#push"
                                                data-id="{{ $training->ID }}">Forward Training </a>

                                        @endif

                                        @if ($userDet->action_stageID == 12 && $training->approval_status == 1)
                                            <a href="{{ route('adminSelectDepartment', $training->ID) }}"
                                                class="btn btn-primary" data-id="{{ $training->ID }}">Select Department | </a>
                                        {{-- @elseif(($training->tStatus == 6 || $training->tStatus == 2))
                                            <a href="#" data-toggle="modal" class="text-warning push_training"
                                                data-toggle="modal" data-target="#push_training"
                                                data-id="{{ $training->ID }}">Forward To Training |</a> --}}
                                        @endif
                                            
                                        @if ($training->tStatus == 2)
                                            <a href="#" data-toggle="modal" class="btn btn-sm btn-primary push_sec"
                                                data-toggle="modal" data-target="#pushSec"
                                                data-id="{{ $training->ID }}">Approve</a>
                                        @endif

                                        @if (!$userDet->action_stageID == 12)
                                            <a href="#" data-toggle="modal" class="btn btn-sm btn-warning revert_module"
                                            data-toggle="modal" data-target="#revertTraining"
                                            data-id="{{ $training->ID }}" data-userID="{{$training->myUserID}}">Revert</a>
                                        @endif
                                        
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            </div>
        </div>
    </div>

<!-- View Comment -->
<div id="commentModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0" id="myModalLabel">Training Comment</h4>
            </div>

            <div class="modal-body">
                <h5 id="trainingComment" style="font-weight: bold; font-size:16px;"></h5>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Comment Modal -->

<!-- Revert Modal -->
<div id="revertTraining" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Revert Training</h5>

            </div>

            <div class="modal-body">
                <form class="row gy-2 gx-3 align-items-center" method="POST"
                    action="{{ route('revertTraining') }}">
                    {{ csrf_field() }}

                    <p style="margin-left:14px">Are you sure you want to Revert this Training ? </p>
                    
                    <input type="hidden" name="revertID" id="revertID">
                    <input type="hidden" name="userID" id="userID">
                    <div class="col-sm-10 mb-4">
                        <label class="" for="autoSizingInput">Comment</label>
                        <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Comment"
                            name="comment" value="{{ old('comment') }}">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger waves-effect waves-light">Revert</button>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Revert Modal -->

    <!-- Push Modal -->
    <div id="push" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Forward Training to</h5>

                </div>

                <div class="modal-body">
                    <form class="row gy-2 gx-3 align-items-center" method="POST"
                        action="{{ route('pushToAdminTraining') }}">
                        {{ csrf_field() }}
                        <p style="margin-left:14px">Are you sure you would like to forward this training ? </p>
                        <input type="hidden" name="id" id="push_id">
                        <div class="col-sm-10 mb-4">
                            <label class="" for="autoSizingInput">Comment</label>
                            <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Comment"
                                name="comment" value="{{ old('comment') }}">
                        </div>

                        <div class="col-sm-10 mb-4" style="margin-top:5px;">
                            <label class="" for="autoSizingSelect">Cadre</label>
                            <select name="cadre" id="cadre" class="form-control">
                                <option value=""> --Select Cadre-- </option>
                                @if (isset($cadres) && $cadres)
                                    @foreach ($cadres as $cadre)
                                        <option value="{{ $cadre->statusID }}"
                                            {{ $cadre->cadre == old('cadre') ? 'selected' : '' }}>
                                            {{ $cadre->cadre }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light">Forward</button>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- <!-- Push Modal -->
    <div id="push" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Post to Director Training</h5>

                </div>


                <div class="modal-body">
                    <form class="row gy-2 gx-3 align-items-center" method="POST"
                        action="{{ route('trainingDirectorApproval') }}">
                        {{ csrf_field() }}
                        <p style="margin-left:14px">Are you sure you would like to Push this Training ? </p>
                        <input type="hidden" name="id" id="push_id">
                        <div class="col-sm-10 mb-4">
                            <label class="" for="autoSizingInput">Comment</label>
                            <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Comment"
                                name="comment" value="{{ old('comment') }}">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light">Push</button>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal --> --}}

    <!-- End Push Modal -->

    <!-- Push Modal -->
    <div id="edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Post to Secretary</h5>

                </div>


                <div class="modal-body">
                    <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{ route('secretaryApproval') }}">
                        {{ csrf_field() }}

                        <p style="margin-left:14px">Are you sure you would like to forward this training ? </p>

                        <input type="hidden" name="id" id="edit_id">
                        <div class="col-sm-10 mb-4">
                            <label class="" for="autoSizingInput">Comment</label>
                            <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Comment"
                                name="comment" value="{{ old('comment') }}">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light">Forward</button>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- End Push Modal -->

    <!-- Push Modal -->
    <div id="push_training" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Forward to Training Unit</h5>

                </div>


                <div class="modal-body">
                    <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{ route('pushTrainingUnit') }}">
                        {{ csrf_field() }}

                        <p style="margin-left:14px">Are you sure you would like to forward this training ? </p>

                        <input type="hidden" name="id" id="training_id">
                        <div class="col-sm-10 mb-4">
                            <label class="" for="autoSizingInput">Comment</label>
                            <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Comment"
                                name="comment" value="{{ old('comment') }}">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light">Forward</button>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- End Push Modal -->

    <!-- Secretary Push -->

    <!-- Push Modal -->
    <div id="pushSec" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Approve Training</h5>

                </div>


                <div class="modal-body">
                    <form class="row gy-2 gx-3 align-items-center" method="POST"
                        action="{{ route('secretaryApprovalStage') }}">
                        {{ csrf_field() }}

                        <p style="margin-left:14px">Are you sure you would like to forward this Training ? </p>
                        
                        <input type="hidden" name="id" id="push_secID">
                        <div class="col-sm-10 mb-4">
                            <label class="" for="autoSizingInput">Comment</label>
                            <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Comment"
                                name="comment" value="{{ old('comment') }}">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light">Forward</button>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- End Push Modal -->


    <!--/// End secretary Push -->


@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
     $(function() {
            $(document).on("click", ".btnComment", function() {
                let id = $(this).attr('data-id')
                $.ajax({
                    type: "GET",
                    url: `training-comment/${id}`,
                    dataType: "json",
                    success: function (response) {
                        $('#trainingComment').text(response.data.comment)
                        $('#training').text('')
                    }
                });
            });

        });
</script>
@section('scripts')
    <script type='text/javascript'>

        $('.module').on('click', function() {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var date = $(this).attr('data-date');

            $('#name').val(name);
            $('#id').val(id);
            $('#date').val(date);

        })

        $('.revert_module').on('click', function(){
            var id = $(this).attr('data-id');
            var myUserID = $(this).attr('data-userID')
            $('#revertID').val(id);
            $('#userID').val(myUserID)

        })

        $('.delete_module').on('click', function() {
            var id = $(this).attr('data-id');

            $('#delete_id').val(id);


        })
        $('.push_module').on('click', function() {
            var id = $(this).attr('data-id');
            $('#push_id').val(id);


        })

        $('.push_training').on('click', function() {
            var id = $(this).attr('data-id');

            $('#training_id').val(id);


        })

        $('.module').on('click', function() {
            var id = $(this).attr('data-id');

            $('#edit_id').val(id);


        })

        $('.push_sec').on('click', function() {
            var id = $(this).attr('data-id');

            $('#push_secID').val(id);


        })
    </script>
@endsection
