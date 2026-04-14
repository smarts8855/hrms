@extends('layouts.layout')
@section('pageTitle')
<strong>TRAINING</strong>
@endsection
@section('content')
    <div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>Select Staff's for training.</em></strong> </span></h3>
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

                <div class="text-center">
                    @php $date = $cTraining[0]->training_date; @endphp
                    <h4> <strong><u>{{ strtoUpper($cTraining[0]->title) }}</u> <br>
                            <u>SCHEDULED FOR: @php echo date('d-M-Y', strtotime($date)) @endphp at {{strtoUpper($cTraining[0]->venue)}}</u>
                        </strong>
                    </h4>
                </div>

                <div class="card">

                    <div class="row">
                        <div class="card-body">

                            <div class="col-md-8">
                                <form class="row gy-2 gx-3 align-items-center" style="padding:30px;" method="GET"
                                action="{{ route('adminSelectDepartment', $currentTraining) }}" enctype="multipart/form-data">
    
                                <div class="col-sm-6 mb-4">
                                    <label class="" for="autoSizingInput">Department</label>
                                    <select class="form-control" id="autoSizingInput" name="department"
                                        value="{{ old('department') }}">
                                        <option value="">-- Select Department --</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                @if ($department->id == session('department')) selected @endif>{{ $department->department }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2 mb-4" style="margin-top:30px">
                                    <button type="submit" class="btn btn-primary w-md">Submit</button>
                                </div>
                                </form>
                            </div>

                            <div class="col-md-4">
                                <h4><strong>Previous Batches</strong></h4>
                                @foreach ($batches as $batch)
                                    <ul>
                                        <li><a href="{{ route('trainingBatch', $batch->batchID) }}">View Batch
                                                {{ $batch->batchID }} Selection</a></li> 
                                    </ul>
                                @endforeach
                            </div>
                        
                        </div>
                    </div>
                    

                        


                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="row">
                    <div class="col-md-6">
                        <h4 style="margin-left:30px; margin-bottom:0px;"><strong>VIEW ALL STAFF IN DEPARTMENT</strong></h4>
                        <div class="staffInDepartment">
                        <table style="padding-left:30px" id="datatable-buttons" class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th data-priority="1">NAME</th>
                                    {{-- <th data-priority="3">DEPARTMENT</th> --}}
                                    <th data-priority="3">DESIGNATION</th>
                                    <th data-priority="3">SGL</th>

                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($staffs))
                                    <p style="display:none">{{ $count = 0 }}</p>
                                    @foreach ($staffs as $key => $staff)
                                        @if ($staff->selected == 0)
                                            <p style="display:none">{{ $count = $count + 1 }}</p>
                                            <tr>
                                                <th>{{ $count }}</th>
                                                <td>{{ $staff->surname . ' ' . $staff->othernames . ' ' . $staff->first_name }}
                                                </td>
                                                {{-- <td>{{ $staff->departmentName }}</td> --}}
                                                <td>{{ $staff->designation }}</td>
                                                <td>{{ $staff->grade }}</td>

                                                <td class="row align-items-center">
                                                    @if ($staff->selected == 0)
                                                        <form class="" method="POST"
                                                            action="{{ route('adminSelectStaff') }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" value="{{ $currentTraining }}"
                                                                name="trainingID">
                                                            <input type="hidden" value="{{ session('department') }}"
                                                                name="department">
                                                            <input type="hidden" value="{{ $staff->ID }}"
                                                                name="staffID">
                                                            <button type="submit" class="btn btn-primary btn-sm">Select</a>
                                                        </form>
                                                    @else
                                                        <button disabled class="btn btn-primary btn-sm">Selected</a>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        </div>
                    </div>


                    <div class="col-md-6">
                        
                        <h4 class="card-title-desc"><strong>VIEW ALL SELECTED STAFF</strong> 
                            {{-- From @if (isset($staffs))
                                {{ $staffs[0]->departmentName }}
                            @else
                                No
                            @endif Department</h4> --}}

                        <div class="staffFromDept">
                        <table style="padding-left:30px" id="datatable-buttons" class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>SN</th>

                                    <th data-priority="1">NAME</th>
                                    <th>DEPARTMENT</th>
                                    <th data-priority="3">SGL</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($trainings))
                                    @foreach ($trainings as $key => $training)
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            <td>{{ $training->surname . ' ' . $training->othernames . ' ' . $training->first_name }}
                                            </td>
                                            <td>{{$training->Dept}}</td>
                                            <td>{{ $training->grade }}</td>
                                            <td class="row align-items-center">
                                                <form class="" method="POST"
                                                    action="{{ route('adminDeSelectStaff') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" value="{{ $training->ID }}" name="ID">

                                                    {{-- <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> --}}
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="false" data-target="#confirmToSubmit{{$key}}"><i class="fa fa-remove"></i></button>

                                                    <!-- Modal to delete -->
                                                    <div class="modal fade text-left d-print-none" id="confirmToSubmit{{$key}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit{{$key}}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="text-success text-center"> <h4>Are you sure you want to remove 
                                                                        {{ $training->surname . ' ' . $training->othernames . ' ' . $training->first_name }}? </h4></div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                                    <button type="submit" class="btn btn-danger btn-sm">Yes Remove</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end Modal-->

                                                </form>

                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        </div>
                        <button type="submit" data-toggle="modal" data-target="#delete" data-target="#delete"
                            class="btn btn-success delete_module" data-id="{{ $currentTraining }}">Submit Nomination

                        </button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Edit Modal -->
        <div id="edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Update Trainings</h5>

                    </div>
                    <div class="modal-body">
                        <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{ route('editTraining') }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" id="id" name="id">
                            <div class="col-sm-4 mb-3">
                                <label class="" for="autoSizingInput">Training Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}">
                            </div>

                            <div class="col-sm-5 mb-3">
                                <label class="" for="autoSizingSelect">Date</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    value="{{ old('date') }}">

                            </div>
                            <div class="col-sm-5 mb-3">
                                <label class="" for="autoSizingSelect">Attachment</label>
                                <input type="file" class="form-control" id="attachment" name="attachment"
                                    value="{{ old('attachment') }}">

                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Edit Modal -->

        <!-- Delete Modal -->
        <div id="delete" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Submit Nomination</h5>

                    </div>


                    <div class="modal-body">
                        <form class="row gy-2 gx-3 align-items-center" method="POST"
                            action="{{ route('concludeTraining') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" id="delete_id">
                            <div class="col-sm-12 mb-3">
                                <label class="" for="autoSizingInput">Comment</label>
                                <input type="text" class="form-control" id="comment" placeholder="Enter Comments"
                                    name="comment" value="{{ old('comment') }}">
                            </div>
                            {{-- <div class="col-sm-12 mb-4">
                                <label class="" for="autoSizingInput">Nominal Letter</label>
                                <textarea class="form-control" id="autoSizingInput" name="report"
                                    value="Report"></textarea>
                            </div> --}}

                            {{-- <div class="col-sm-6 mb-4">
                                <label class="" for="autoSizingInput">Date</label>
                                <input type="date" class="form-control" name="date">
                            </div>

                            <div class="col-sm-6 mb-4">
                                <label class="" for="autoSizingSelect">Attach Attendance Sheet</label>
                                <input type="file" class="form-control" id="autoSizingInput" placeholder="Enter"
                                    name="attachment" value="{{ old('attachment') }}">

                            </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">Submit</button>

                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- End Delete Modal -->

        <style>
            .staffInDepartment {
              max-height: 700px;
              overflow: auto;
            }

            .staffFromDept{
                max-height: 700px;
                overflow: auto;
            }
        </style>
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
        </script>
    @endsection
