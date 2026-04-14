@extends('layouts.layout')

@section('pageTitle')
    <span style="font-weight: bold">TRAINING</span>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>View all training.</em></strong> </span></h3>
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
                <table style="padding-left:30px;" id="datatable-buttons" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th data-priority="1">NAME</th>
                            <th>TYPE</th>
                            <th>FROM</th>
                            <th>TO</th>
                            <th>TIME</th>
                            <th>VENUE</th>
                            <th>CONSULTANT</th>
                            <th data-priority="3">ATTACHMENT</th>


                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($trainings))
                            @foreach ($trainings as $key => $training)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $training->title }}</td>
                                    <td>{{ $training->training_type }}</td>
                                    <td>{{ $training->training_date }}</td>
                                    <td>{{ $training->training_end_date }}</td>
                                    <td>{{ $training->training_time }}</td>
                                    <td>{{ $training->venue }}</td>
                                    <td>{{ $training->consultant }}</td>
                                    <td><a target="__blank"
                                            href="{{ asset('/trainingAttachment/' . $training->attachment) }}">Preview</a>
                                    </td>

                                    <td class="row align-items-center">
                                        @if ($training->status == 6 || $training->status == 12) <!-- stat of 6shows approved -->
                                            <p>Approved</p>
                                        @elseif($training->status == 4)
                                            <p>Forwarded to Head of Training</p>
                                        @elseif($training->status == 3)
                                            <p>Forwarded to Chief Registrar</p>
                                        @elseif($training->status == 2)
                                            <p>Forwarded to Head Admin</p>
                                        @else
                                            <a href="{{url('edit-training/'.$training->ID)}}" class="btn btn-primary btn-sm module"
                                                data-name="{{ $training->title }}" data-date="{{ $training->date }}"
                                                data-id="{{ $training->ID }}">Edit | </a>
                                            @if ($training->status < 1)
                                                <a href="#" data-toggle="modal" class="btn btn-primary btn-sm push_module"
                                                    data-toggle="modal" data-target="#push"
                                                    data-id="{{ $training->ID }}">Forward Training | </a>
                                            @endif
                                            <a href="#" data-toggle="modal" data-target="#delete"
                                                class="btn btn-danger btn-sm delete_module" data-toggle="modal" data-target="#delete"
                                                data-id="{{ $training->ID }}">Delete</a>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="margin-left:15px">
                        {{$trainings->links()}}
                    </div>
                </div>
                
                <div class="col-sm-4 mb-4" style="margin-top:30px">
                    <a href="{{route('showTraining')}}"> <button type="button" class="btn btn-primary-info w-md">Back to Create training...</button></a>
                </div>

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
