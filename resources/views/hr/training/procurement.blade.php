@extends('layouts.layout')
@section('pageTitle')
    <span style="font-weight: bold">TRAINING</span>
@endsection
@section('content')
    <div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>Create New training.</em></strong> </span></h3>
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
                <div class="card">
                    <div class="card-body">
                        {{-- <h3 class="card-title mb-4" style="margin-left:30px">Create Training</h3> --}}

                        <form class="row gy-2 gx-3 align-items-center" style="padding:30px;" method="POST"
                            action="{{ route('postTraining') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-sm-6 mb-4">
                                <label class="" for="autoSizingInput">Training Name</label>
                                <input type="text" class="form-control" id="autoSizingInput"
                                    placeholder="Enter Training Name" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="" for="autoSizingSelect">Type of Training</label>
                                <select name="training_type" class="form-control">
                                    <option value="">Select Type of Training</option>
                                    @if (isset($trainingType) && $trainingType)
                                        @foreach ($trainingType as $type)
                                            <option value="{{ $type->type_name }}">
                                                {{ $type->type_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-sm-6 mb-4" style="margin-top:5px;">
                                <label class="" for="autoSizingSelect">Venue</label>
                                <input type="text" class="form-control"
                                    placeholder="Enter Venue For Training" name="venue" value="{{ old('venue') }}">
                            </div>

                            <div class="row">
                                <div class="col-sm-3 mb-6" style="margin-top:5px;">
                                    <label class="" for="autoSizingSelect">From:</label>
                                    <input type="date" class="form-control" id="autoSizingInput"
                                         name="training_date" value="{{ old('training_date') }}">
                                </div>
                                <div class="col-sm-3 mb-6" style="margin-top:5px;">
                                    <label class="" for="autoSizingSelect">To:</label>
                                    <input type="date" class="form-control" id="autoSizingInput"
                                         name="training_end_date" value="{{ old('training_end_date') }}">
                                </div>
                            </div>


                            <div class="col-sm-6 mb-4" style="margin-top:5px;">
                                <label class="" for="autoSizingSelect">Time</label>
                                <input type="time" class="form-control" id="autoSizingInput"
                                    placeholder="" name="training_time" value="{{ old('training_time') }}">
                            </div>

                            <div class="col-sm-6 mb-4" style="margin-top:5px;">
                                <label class="" for="autoSizingSelect">Consultant</label>
                                <input type="text" class="form-control" id="autoSizingInput"
                                    placeholder="Consultant Name" name="consultant" value="{{ old('consultant') }}">
                            </div>

                            <div class="col-sm-6 mb-4" style="margin-top:5px;">
                                <label class="" for="autoSizingSelect">Attachment</label>
                                <input type="file" class="form-control" id="autoSizingInput" placeholder="Enter"
                                    name="attachment" value="{{ old('attachment') }}">

                            </div>

                            <div class="col-sm-4 mb-4" style="margin-top:30px">
                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                            </div>
                        </form>
                        <div class="col-sm-4 mb-4" style="margin-top:30px">
                            <a href="{{route('viewAllTraining')}}"> <button type="button" class="btn btn-primary-info w-md">View all training...</button></a>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>
        </div>
    </div>

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
                        <p style="margin-left:14px">Are you sure you would like to Forward this Training ? </p>
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

    <!-- End Push Modal -->


@endsection
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

        $('.delete_module').on('click', function() {
            var id = $(this).attr('data-id');

            $('#delete_id').val(id);


        })


        $('.push_module').on('click', function() {
            var id = $(this).attr('data-id');

            $('#push_id').val(id);


        })
    </script>
@endsection
