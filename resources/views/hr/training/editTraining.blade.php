@extends('layouts.layout')
@section('pageTitle')
    <span style="font-weight: bold">EDIT Training</span>
@endsection
@section('content')
    <div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
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
                        <h3 class="card-title mb-4" style="margin-left:30px">Edit Training</h3>

                        <form class="row gy-2 gx-3 align-items-center" style="padding:30px;" method="POST"
                            action="{{ route('editTraining') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" id="id" name="id" value="{{$getTraining->ID}}">
                            <div class="col-sm-6 mb-4">
                                <label class="" for="autoSizingInput">Training Name</label>
                                <input type="text" class="form-control" id="autoSizingInput"
                                    placeholder="Enter Training Name" name="name" value="{{ old('name', $getTraining->title) }}">
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="" for="autoSizingSelect">Type of Training</label>
                                <select name="type_of_training" class="form-control">
                                    <option value="">Select Type of Training</option>
                                    @if (isset($getTraining) && $getTraining)
                                        @foreach ($trainingType as $type)
                                            <option value="{{ $type->type_name}}" {{ $type->type_name == $getTraining->training_type ? 'selected' : '' }}>
                                                {{ $type->type_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-sm-6 mb-4" style="margin-top:5px;">
                                <label class="" for="autoSizingSelect">Venue</label>
                                <input type="text" class="form-control"
                                    placeholder="Enter Venue for training" name="venue" value="{{ old('venue', $getTraining->venue) }}">
                            </div>

                            <div class="row">
                                <div class="col-sm-3 mb-6" style="margin-top:5px;">
                                    <label class="" for="autoSizingSelect">Date</label>
                                    <input type="date" class="form-control" id="autoSizingInput"
                                        name="training_date" value="{{ old('training_date', $getTraining->training_date) }}">
                                </div>

                                <div class="col-sm-3 mb-6" style="margin-top:5px;">
                                    <label class="" for="autoSizingSelect">To:</label>
                                    <input type="date" class="form-control" id="autoSizingInput"
                                        name="training_end_date" value="{{ old('training_end_date', $getTraining->training_end_date) }}">
                                </div>
                            </div>

                            <div class="col-sm-6 mb-4" style="margin-top:5px;">
                                <label class="" for="autoSizingSelect">Time</label>
                                <input type="text" class="form-control" id="autoSizingInput"
                                    placeholder="12 PM" name="training_time" value="{{ old('training_time', $getTraining->training_time) }}">
                            </div>

                            <div class="col-sm-6 mb-4" style="margin-top:5px;">
                                <label class="" for="autoSizingSelect">Consultant</label>
                                <input type="text" class="form-control" id="autoSizingInput"
                                    placeholder="Consultant name" name="consultant" value="{{ old('consultant', $getTraining->consultant) }}">
                            </div>

                            <div class="col-sm-6 mb-4" style="margin-top:5px;">
                                <label class="" for="autoSizingSelect">Attachment</label>
                                <input type="file" class="form-control" id="autoSizingInput" placeholder="Enter"
                                    name="attachment" value="{{ old('attachment') }}">

                            </div>

                            <div class="col-sm-4 mb-4" style="margin-top:30px">
                                <button type="submit" class="btn btn-primary w-md">Save Changes</button>
                            </div>
                        </form>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>
        </div>
    </div>

@endsection
