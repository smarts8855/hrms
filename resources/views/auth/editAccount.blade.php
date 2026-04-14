@extends('layouts.layout')
@section('pageTitle')
    Edit User Account
@endsection

@section('content')
    <form method="post" action="{{ url('/user/editAccount') }}">

        <div class="box box-default">
            <div class="row" style="margin: 5px 10px;">
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

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('warning') }}
                        </div>
                    @endif


                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong>
                            {{ session('msg') }}
                        </div>
                    @endif
                </div>
                {{ csrf_field() }}
                <div class="col-md-12 text-success"><!--2nd col-->
                    <big><b>EDIT ACCOUNT</b></big>
                </div>
                <br />
                <hr>
                <div class="col-md-12"><!--2nd col-->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userName">Full name</label>
                                <input type="Text" name="fullName" class="form-control" value="{{ Auth::user()->name }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userName">User Name</label>
                                <input type="Text" name="userName" class="form-control"
                                    value="{{ Auth::user()->username }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userRole">User Role</label>
                                <input type="Text" name="userRole" class="form-control" value="{{ $userrole ?? '' }}"
                                    readonly>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="division">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-success form-control" type="submit"> Save Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </form>
@endsection
