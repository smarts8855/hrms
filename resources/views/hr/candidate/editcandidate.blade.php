@extends('layouts.layout')
@section('pageTitle')
    <strong>Edit Candidate Details</strong>
@endsection

@section('content')

    <!-- Page Header -->
    @include('hr.partials.page-header')
    <!-- End Page Header -->

    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <div class="row">
                <div class="col-xs-6">
                    <h3 class="box-title">@yield('pageTitle') <span id="processing"></span></h3>
                </div>
                <div class="col-xs-6 text-right">
                    <a href="{{ route('Candidate.add', ['id' => $candidate->interview_titleID]) }}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                        Go Back</a>
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

        <form method="post" action="{{ route('updateCandidateShorlisted') }}" class="form-horizontal">
            {{ csrf_field() }}
            <div class="box-body">

                <div class="form-group" style="margin-left:10px; margin-right:10px">
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>Title</label>
                            <select class="form-control" name="title" id="title" required>
                                <option value="{{ $candidate->candidate_title }}" {{ isset($candidate) ? 'selected' : '' }}>
                                    {{ $candidate->candidate_title }} </option>

                                @if ($candidate->candidate_title == 'Mr')
                                    <option value="Ms">Ms</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                @elseif ($candidate->candidate_title == 'Ms')
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                @elseif ($candidate->candidate_title == 'Mrs')
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Miss">Miss</option>
                                @elseif ($candidate->candidate_title == 'Miss')
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Mrs">Mrs</option>
                                @endif

                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label>Surname</label>
                            <input class="form-control" name="candidateID" id="surname" type="hidden"
                                value="{{ $candidate->candidateID }}">
                            <input class="form-control" name="surname" id="surname" type="text"
                                value="{{ $candidate->surname }}">
                        </div>

                        <div class="col-lg-4">
                            <label>Firstname</label>
                            <input class="form-control" name="firstname" id="firstname" type="text"
                                value="{{ $candidate->first_name }}" required>
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>Othernames</label>
                            <input class="form-control" name="othernames" id="othernames" type="text"
                                value="{{ $candidate->othernames }}">
                        </div>
                        <div class="col-lg-4">
                            <label>Email</label>
                            <input class="form-control" name="email" id="email" type="email"
                                value="{{ $candidate->email }}">
                        </div>
                        <div class="col-lg-4">
                            <label>Phone No.</label>
                            <input class="form-control" name="phoneNo" id="phoneNo" type="text"
                                value="{{ $candidate->phoneNo }}">
                        </div>
                    </div>
                    <div class="form-group row">

                        <div class="col-lg-4">
                            <label>Sex</label>

                            <select name="sex" id="sex" required class="form-control">
                                <option value="{{ $candidate->sex }}" {{ isset($candidate) ? 'selected' : '' }}>
                                    {{ $candidate->sex }}
                                </option>

                                @if ($candidate->sex == 'Male')
                                    <option value="Female">Female</option>
                                @else
                                    <option value="Male">Male</option>
                                @endif

                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label>Marital Status</label>
                            <select name="maritalStatus" id="maritalStatus" required class="form-control">
                                <option value="{{ $candidate->maritalStatus }}"
                                    {{ isset($candidate) ? 'selected' : '' }}>
                                    {{ $candidate->maritalStatus }}</option>

                                @if ($candidate->maritalStatus = 'Single')
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                @elseif ($candidate->maritalStatus = 'Married')
                                    <option value="Single">Single</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                @elseif ($candidate->maritalStatus = 'Divorced')
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                @elseif ($candidate->maritalStatus = 'Widowed')
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                @endif

                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label>State of Origin</label>

                            <select name="state" id="state" required class="form-control">
                                <option value="">Select File</option>
                                @if (isset($candidate) && $candidate)
                                    <option value="{{ $candidate->state }}" {{ isset($candidate) ? 'selected' : '' }}>
                                        {{ $candidate->candidateState }}
                                    </option>
                                    @foreach ($state as $b)
                                        <option value="{{ $b->StateID }}">{{ $b->State }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-lg-6">
                            <label>LGA</label>
                            <select name="lga" id="lga" required class="form-control">
                                @if (isset($candidate) && $candidate)
                                    <option value="{{ $candidate->lga }}" {{ isset($candidate) ? 'selected' : '' }}>
                                        {{ $candidate->candidateLga }}
                                    </option>
                                    @foreach ($lga as $b)
                                        <option value="{{ $b->lgaId }}">{{ $b->lga }}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label>Address</label>
                            <textarea class="form-control" id="editorx" name="address" rows="1" required>{{ $candidate->address }}</textarea>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-success" name="Save">
                        <i class="fa fa-btn fa-floppy-o"></i> Update
                    </button>

                </div>

        </form>

        <div class="table-responsive" style="font-size: 12px; padding:10px;">

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
        $("#state").change(function(e) {

            //console.log(e);
            var state_id = e.target.value;
            //var state_id = $(this).val();

            //alert(state_id);
            //$token = $("input[name='_token']").val();
            //ajax
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
