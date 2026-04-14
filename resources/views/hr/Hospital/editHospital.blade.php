@extends('layouts.layout')

@section('pageTitle')
    Edit Hospital Record
@endsection

<style type="text/css">
    .length {
        width: 80px;
    }

    .remove {
        padding-top: 12px;
        cursor: pointer;
    }
</style>

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">

            <div class="box-header with-border hidden-print">
                <div class="row">
                    <div class="col-xs-6">
                        <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="{{ url('hospital') }}" class="btn btn-danger">
                            Go Back <i class="fa fa-refresh"></i>
                        </a>
                    </div>

                </div>
            </div>
            <div class="box box-success">
                <div class="box-body">
                    <div class="row">

                        @includeIf('Share.message')

                        <div class="col-md-12">
                            <!--2nd col-->

                            <form method="Post" action="{{ url('/hospital-update') }}">
                                @csrf
                                <input type="hidden" class="form-control" name="id" value="{{ $value->id }}"
                                    required>

                                <div class="row">

                                    <div class="col-md-3">
                                        <label for="basic-url" class="form-label">Hospital Category</label>
                                        <select class="form-control" name="hospitalCat" aria-label="gender"
                                            aria-describedby="basic-addon2" required>
                                            <option selected>Select Hospital</option>
                                            @foreach ($hospitalCats as $hospitalCat)
                                                <option value="{{ $hospitalCat->id }}"
                                                    {{ $hospitalCat->id == $value->category_id ? 'selected' : '' }}>
                                                    - {{ $hospitalCat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="name" class="form-label"> Name</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Name of Hospital" aria-label="name" value="{{ $value->name }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="staticEmail2" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" name="phone"
                                            value="{{ $value->phone }}" id="staticEmail2">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="staticEmail2" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $value->email }}" id="staticEmail2">
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <label for="lastname" class="form-label">Code</label>
                                        <input type="text" class="form-control" name="code"
                                            value="{{ $value->code }}" placeholder="Hospital code" aria-label="Last name"
                                            required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" name="address" id="address" cols="1" rows="1">{{ $value->address }}</textarea>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="form-label" style="visibility: hidden">save</label>
                                        <button name="action" class="btn btn-success form-control w-100" type="submit">
                                            Update <i class="fa fa-save"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.col -->
                </div>
            </div>

        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection


<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
