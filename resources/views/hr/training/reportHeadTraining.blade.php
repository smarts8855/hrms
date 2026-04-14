@extends('layouts.layout')
@section('pageTitle')
    <strong>TRAINING</strong>
@endsection
@section('content')
    <div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>Head of Training, View Report.</em></strong> </span></h3>
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
                        <h4 class="text-center"><strong>All Training </strong></h4>
                        <p class="card-title-desc"></p>

                        <div class="table-responsive">
                        <table style="padding-left:30px" id="datatable-buttons" class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th data-priority="1">TITLE</th>
                                    <th>DATE</th>
                                    <th>CONSULTANT</th>
                                    <th>COMMENT</th>
                                    {{-- <th>REPORT</th> --}}
                                    <th data-priority="3">ATTACHMENT</th>
                                    <th>ATTENDANCE</th>
                                    <th>SENT FROM</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($trainings))
                                    @foreach ($trainings as $key => $training)
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            <td>{{ $training->title }}</td>
                                            <td>{{ date('d-M-Y', strtotime($training->training_date)). ' to ' .date('d-M-Y', strtotime($training->training_end_date))}}</td>
                                            <td>{{ $training->consultant }}</td>
                                            <td>{{$training->Comment}}</td>
                                            {{-- <td>{{$training->Report}}</td> --}}
                                            <td><a target="__blank"
                                                    href="{{ asset('/trainingAttachment/' . $training->attachment) }}">Preview</a>
                                            </td>
                                            <td>
                                                <a target="_blank" 
                                                    href="{{ asset('/trainingAttachment/'.$training->attendance_attachment) }}"><button type="button" class="btn btn-primary btn-sm"> View Attendance <span class="fa fa-print"></span></button></a>
                                            </td>
                                            <td>{{$training->name}}</td>
                                            <td class="row align-items-center">     

                                                <a href="#" data-toggle="modal" data-target="#forward"
                                                    class="btn btn-success btn-sm forward_module" data-toggle="modal" data-target="#delete"
                                                    data-id="{{ $training->ID }}">Forward Report</a>
                                                    

                                            </td>
        
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>
        </div>
    </div>

        <!-- Forward Modal -->
        <div id="forward" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Forward Training to</h5>
    
                    </div>
    
                    <div class="modal-body">
                        <form class="row gy-2 gx-3 align-items-center" method="POST"
                            action="{{route('forwardTrainingReport')}}">
                            {{ csrf_field() }}
                            <p style="margin-left:14px">Are you sure you would like to Forward this Training Report? </p>
                            <input type="hidden" name="id" id="forward_id">
                            <div class="col-sm-12 mb-4">
                                <label class="" for="autoSizingInput">Comment</label>
                                <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Comment"
                                    name="comment" value="{{ old('comment') }}">
                            </div>
    
                            <div class="col-sm-12 mb-4" style="margin-top:5px;">
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

    $('.forward_module').on('click', function() {
        var id = $(this).attr('data-id');
        // console.log(id)
        $('#forward_id').val(id);


    })

    $('.push_module').on('click', function() {
        var id = $(this).attr('data-id');
        // console.log(id)
        $('#push_id').val(id);


    })
</script>
@endsection

