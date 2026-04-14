@extends('layouts.layout')
@section('pageTitle')
    <strong>Add New Staff</strong>
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
                        {{-- <a href="{{ url('/interview') }}">
                            <button type="button" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back
                            </button>
                        </a> --}}
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

            <form method="post" action="{{ route('adminSaveNewStaff') }}" class="form-horizontal">
                {{ csrf_field() }}
                <div class="box-body">

                    <div class="form-group" style="margin-left:10px; margin-right:10px">
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>Title</label>
                                <select class="form-control" name="title" id="title" required>
                                    <option value=""> -Select- </option>
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label>Surname</label>
                                <input class="form-control" name="surname" id="surname" type="text" value=""
                                    required>
                            </div>

                            <div class="col-lg-4">
                                <label>First name</label>
                                <input class="form-control" name="firstname" id="firstname" type="text" placeholder=""
                                    required>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>Othernames</label>
                                <input class="form-control" name="othernames" id="othernames" type="text" placeholder="">
                            </div>

                            <div class="col-lg-4">
                                <label>Email</label>
                                <input class="form-control" name="email" id="email" type="email" placeholder="">
                            </div>

                            <div class="col-lg-4">
                                <label>Phone No.</label>
                                <input class="form-control" name="phoneNo" id="phoneNo" type="text" placeholder="">
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-lg-4">
                                <label>Sex</label>
                                <select name="sex" id="sex" required class="form-control">
                                    <option value="" selected>-Select-</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <label>Marital Status</label>
                                <select name="maritalStatus" id="maritalStatus" required class="form-control">
                                    <option value="" selected>-Select-</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <label>Grade</label>
                                <select name="grade" required class="form-control">
                                    @for ($i = 1; $i <= 17; $i++)
                                        @if($i != 11)
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <label>Step</label>
                                <select name="step" required class="form-control">
                                    <option value="" selected>-Select-</option>
                                    @for ($i = 1; $i <= 15; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>

                            

                        </div>

                        <button type="submit" class="btn btn-success" name="Save">
                            <i class="fa fa-btn fa-floppy-o"></i> Save
                        </button>

                    </div>

            </form>
        </div>
    </div>

    <div class="box box-default">

        {{-- end copy  --}}
        {{-- <div class="box box-primary custom-card">
            <div class="box-header with-border">
                <h3 class="box-title">Newly Added Staff</h3>
            </div>

            <div class="box-body">
                <div class="table-responsive" style="font-size: 12px; padding:10px;">
                    <table class="table table-bordered table-striped table-highlight">
                        <thead>
                            <tr bgcolor="#c7c7c7">
                                <th width="1%">S/N</th>
                                <th>FULLNAME</th>
                                <th>SEX</th>
                                <th>ADDRESS</th>
                                <th>STATE</th>
                                <th>LGA</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        @php $serialNum = 1; @endphp

                        @foreach ($interviewList as $key => $b)
                            <tr>
                                <td>{{ $serialNum++ }}</td>
                                <td>
                                    {{ $b->surname }} {{ $b->first_name }} {{ $b->othernames }}
                                    <br>
                                    @if ($b->candidate_source == 'CR')
                                        <span class="label label-success"> {{ $b->candidate_source }}</span>
                                    @endif
                                </td>
                                <td>{{ $b->sex }}</td>
                                <td>{{ $b->address }}</td>
                                <td>{{ $b->State }}</td>
                                <td>{{ $b->lga }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-backdrop="false" data-target="#confirmToDelete{{ $key }}">
                                        <span class="glyphicon glyphicon-trash"></span> Delete Candidate
                                    </button>

                                    <a href="/edit-candidates/{{ $b->candidateID }}" class="btn btn-info btn-sm">
                                        <span class="glyphicon glyphicon-edit"></span> Edit Candidate
                                    </a>
                                </td>

                                <div class="modal fade text-left d-print-none" id="confirmToDelete{{ $key }}"
                                    tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">

                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">

                                            <div class="modal-header bg-danger">
                                                <h4 class="modal-title text-white">
                                                    <span class="glyphicon glyphicon-warning-sign"></span> Confirm
                                                    Deletion
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center text-danger">
                                                    <h4>Are you sure you want to delete candidate
                                                        <strong>{{ $b->surname }} {{ $b->first_name }}
                                                            {{ $b->othernames }}</strong>?
                                                    </h4>
                                                </div>
                                            </div>

                                            <form action="{{ route('candidate.delete') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="candidateID" value="{{ $b->candidateID }}">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-info"
                                                        data-dismiss="modal">
                                                        <span class="glyphicon glyphicon-remove"></span> Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div> --}}
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
        $("#state").change(function(e) {
            var state_id = e.target.value;
            $.get('../get-lga-from-state?state_id=' + state_id, function(data) {
                $('#lga').empty();
                //console.log(data);
                $('#lga').append('<option value="">Select One</option>');
                $.each(data, function(index, obj) {
                    $('#lga').append('<option value="' + obj.lgaId + '">' + obj.lga + '</option>');
                });


            })
        });
    </script>
@endsection
