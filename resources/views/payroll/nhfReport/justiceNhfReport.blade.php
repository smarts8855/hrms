@extends('layouts.layout')
@section('pageTitle')
    NHF Reports
@endsection
@section('content')
    <form method="post" action="{{ url('justiceNhf/report/new') }}">
        <div class="box-body" style="background:#FFF;">
            <div class="row">
                <div class="col-md-12"><!--1st col-->
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
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong>
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="row">



                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Select a Month </label>
                                <select name="month" id="section" class="form-control">
                                    <option value="">Select Month </option>
                                    <option value="JANUARY" @if (old('month') == 'JANUARY') selected @endif>January
                                    </option>
                                    <option value="FEBRUARY" @if (old('month') == 'FEBRUARY') selected @endif>February
                                    </option>
                                    <option value="MARCH" @if (old('month') == 'MARCH') selected @endif>March</option>
                                    <option value="APRIL" @if (old('month') == 'APRIL') selected @endif>April</option>
                                    <option value="MAY" @if (old('month') == 'MAY') selected @endif>May</option>
                                    <option value="JUNE" @if (old('month') == 'JUNE') selected @endif>June</option>
                                    <option value="JULY" @if (old('month') == 'JULY') selected @endif>July</option>
                                    <option value="AUGUST" @if (old('month') == 'AUGUST') selected @endif>August</option>
                                    <option value="SEPTEMBER" @if (old('month') == 'SEPTEMBER') selected @endif>September
                                    </option>
                                    <option value="OCTOBER" @if (old('month') == 'OCTOBER') selected @endif>October
                                    </option>
                                    <option value="NOVEMBER" @if (old('month') == 'NOVEMBER') selected @endif>November
                                    </option>
                                    <option value="DECEMBER" @if (old('month') == 'DECEMBER') selected @endif>December
                                    </option>
                                </select>
                            </div>
                        </div>
                        @if (Auth::user()->is_global == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Select a Division </label>
                                    <select name="div" id="section" class="form-control">
                                        <option value="">Select Division </option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->divisionID }}">{{ $division->division }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="div" id="section" class="form-control">
                                        @foreach ($getauthUser as $user)
                                            <option value="{{ Auth::user()->divisionID }}" selected>{{ $user->division }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select a Year</label>
                                <select name="year" id="section" class="form-control">
                                    <option value="">Select Year</option>
                                    @for ($i = 2025; $i <= 2040; $i++)
                                        <option value="{{ $i }}"
                                            @if (old('year') == $i) selected @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label></label>
                                <div>
                                    <button type="submit" class="btn btn-success pull-right">Display</button>
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
