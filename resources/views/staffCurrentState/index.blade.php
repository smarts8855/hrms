@extends('layouts.layout')
@section('pageTitle')
    Staff Management
@endsection
@section('content')
    <form method="POST" action="{{ url('/update-staff-current-state/retrieve') }}" target="_blank">
        <div class="box-body" style="background:#fff;">
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
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong>
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                {{ csrf_field() }}
                <div class="col-md-12">
                    <h4 class="" style="text-transform:uppercase">Update Staff Current State</h4>
                    <div class="row">

                        @if (Auth::user()->is_global == 1)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Court</label>
                                    <select name="divisionID" id="division" class="form-control" style="font-size: 13px;">
                                        <option value="">Select Court</option>
                                        @foreach ($courtDivisions as $divisions)
                                            <option value="{{ $divisions->divisionID }}"
                                                @if (old('division') == $divisions->divisionID) selected @endif>
                                                {{ $divisions->division }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Division</label>
                                    <input type="text" class="form-control" id="divisionName" name="divisionName"
                                        value="{{ $curDivision->division }}" readonly>
                                </div>
                            </div>
                            <input type="hidden" id="division" name="divisionID" value="{{ Auth::user()->divisionID }}">
                        @endif

                        <div class="col-md-12">
                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success btn-sm pull-right">View Staffs</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </form>
@endsection
@section('styles')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#court").on('change', function(e) {
                e.preventDefault();
                var id = $(this).val();
                //alert(id);
                $token = $("input[name='_token']").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $token
                    },
                    url: murl + '/session/court',

                    type: "post",
                    data: {
                        'courtID': id
                    },
                    success: function(data) {
                        location.reload(true);
                        //console.log(data);
                    }
                });

            });
        });
    </script>
@endsection
