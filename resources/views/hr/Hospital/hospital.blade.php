@extends('layouts.layout')
@section('pageTitle')
    NHIS
@endsection

@section('content')
    <div class="box box-default" style="border: none;">

        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span
                    id='processing'><strong><em>Add new Hospital Record</em></strong></span></h3>
        </div>

        <div class="box box-success">
            <div class="box-body box-profile" style="margin:10px 20px;">
                <div class="row">
                    @includeIf('hr.Share.message')
                    <div class="box-body">

                        <form method="post" action="{{ url('/hospital-save') }}" class="form-horizontal">
                            @csrf

                            <div class="row">

                                <div class="col-md-3">
                                    <label for="basic-url" class="form-label">Hospital Category</label>
                                    <select class="form-control" name="hospitalCat" aria-label="gender"
                                        aria-describedby="basic-addon2" required>
                                        <option selected>Select Hospital</option>
                                        @if (isset($hospitalCats) && $hospitalCats)
                                            @foreach ($hospitalCats as $hospitalCat)
                                                <option value="{{ $hospitalCat->id }}"
                                                    {{ $hospitalCat == old('hospitalCats') ? 'selected' : '' }}>
                                                    - {{ $hospitalCat->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="name" class="form-label"> Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name of Hospital"
                                        aria-label="name" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="staticEmail2" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" name="phone" id="staticEmail2">
                                </div>

                                <div class="col-md-3">
                                    <label for="staticEmail2" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="staticEmail2">
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <label for="lastname" class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" placeholder="Hospital code"
                                        aria-label="Last name" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" name="address" id="address" cols="1" rows="1" required></textarea>
                                    {{-- <input type="text" class="form-control" id="address" name="address"
                                        placeholder="address" required> --}}
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="form-label" style="visibility: hidden">save</label>
                                    <button name="action" class="btn btn-success form-control w-100" type="submit">
                                        Save <i class="fa fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border">
                <h4 class="box-title text-uppercase">
                    Hospital List
                </h4>
            </div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive" id="tableID">
                        @include('hr.Hospital.hospitaltable')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <style>
        body {
            font-family: 'Varela Round', sans-serif;
        }


        .modal-confirm {
            color: #636363;
            width: 100px;
            margin: 10px auto;
        }

        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
            text-align: center;
            font-size: 14px;
        }

        .modal-confirm .modal-header {
            border-bottom: none;
            position: relative;
        }

        .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -10px;
        }

        .modal-confirm .close {
            position: absolute;
            top: -5px;
            right: -2px;
        }

        .modal-confirm .modal-body {
            color: #999;
        }

        .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 5px;
            font-size: 13px;
            padding: 10px 15px 25px;
        }

        .modal-confirm .modal-footer a {
            color: #999;
        }

        .modal-confirm .icon-box {
            width: 50px;
            height: 50px;
            margin: 0 auto;
            border-radius: 50%;
            z-index: 9;
            text-align: center;
            border: 3px solid #f15e5e;
        }

        .modal-confirm .icon-box i {
            color: #f15e5e;
            font-size: 24px;
            display: inline-block;
            margin-top: 10px;
        }

        .modal-confirm .btn {
            color: #fff;
            border-radius: 4px;
            background: #60c7c1;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            min-width: 80px;
            border: none;
            min-height: 40px;
            border-radius: 3px;
            margin: 0 5px;
            outline: none !important;
        }

        .modal-confirm .btn-info {
            background: #c1c1c1;
        }

        .modal-confirm .btn-info:hover,
        .modal-confirm .btn-info:focus {
            background: #a8a8a8;
        }

        .modal-confirm .btn-danger {
            background: #f15e5e;
        }

        .modal-confirm .btn-danger:hover,
        .modal-confirm .btn-danger:focus {
            background: #ee3535;
        }

        .trigger-btn {
            display: inline-block;
            margin: 50px auto;
        }
    </style>
@endsection

<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
