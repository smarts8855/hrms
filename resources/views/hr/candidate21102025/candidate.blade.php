@extends('layouts.layout')
@section('pageTitle')
    <h3><strong>Add Candidate For Interview: {{ strtoUpper($interviewDetails->title) }}</strong></h3>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
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

        <form method="post" action="{{ route('saveCandidateShorlisted') }}" class="form-horizontal">
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
                            <input class="form-control" name="interviewID" id="interviewID" type="hidden"
                                value="{{ $interviewDetails->interviewID }}">
                            <input class="form-control" name="surname" id="surname" type="text" value="" required>
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

                        <div class="col-lg-4">
                            <label>State Of Origin</label>
                            <select name="state" id="state" required class="form-control">
                                <option value="" selected>-Select-</option>
                                @foreach ($state as $b)
                                    <option value="{{ $b->StateID }}" {{ $state == $b->State ? 'selected' : '' }}>
                                        {{ $b->State }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-lg-6">
                            <label>LGA</label>
                            <select name="lga" id="lga" required class="form-control">


                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label>Address</label>
                            <textarea class="form-control" id="editorx" name="address" rows="3" required></textarea>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-success" name="Save">
                        <i class="fa fa-btn fa-floppy-o"></i> Save
                    </button>

                </div>

        </form>
        
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
                        <td>{{ $b->surname }} {{ $b->first_name }} {{ $b->othernames }}</td>
                        <td>{{ $b->sex }}</td>
                        <td>{{ $b->address }}</td>
                        <td>{{ $b->State }}</td>
                        <td>{{ $b->lga }}</td>
                        <td>

                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="false" data-target="#confirmToDelete{{$key}}">Delete Candidate</button>
                                
                            <!-- Modal to delete -->
                            <div class="modal fade text-left d-print-none" id="confirmToDelete{{$key}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-success text-center"> <h4>Are you sure you want to delete candidate {{ $b->surname }} {{ $b->first_name }} {{ $b->othernames }} </h4></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                            <a href="{{url('delete-candidates/'.$key)}}" class="btn btn-danger"> Delete </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end Modal-->
                            
                            <a href="/edit-candidates/{{ $b->candidateID }}"><span class="btn btn-info btn-sm"> Edit
                                    Candidate</span></a>
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>
        <a href="{{ url('/interview') }}" class="btn btn-warning">Go Back</a>
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
