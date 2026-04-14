@extends('layouts.layout')
@section('pageTitle')
    <strong>Edit NHF No. For {{ $nhfStaff->surname }} {{$nhfStaff->first_name}}</strong>

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

        <form method="post" action="{{url('update-staff-nhf-no/'.$nhfStaff->ID)}}" class="form-horizontal">
            {{ csrf_field() }} @method('PUT')

            <div class="row">

            <div class="col-md-2"></div>
            <div class="box-body col-md-8">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card" style="width: 18rem;">
                            {{-- @php $pic="/passport/" @endphp --}}
                            <img src="{{ $nhfStaff->passport_url }}" class="card-img-top" alt="No passport image..." style="width:150px; height:180px; object-fit:cover; border:1px solid #ddd;">
                            
                          </div>
                    </div>

                </div>
                <div class="row">
                <div class="col-md-12" id="divIDx">
                    <div class="form-group">
                            <div class="col-md-6">
                                <label>File No.</label>
                                <input class="form-control" type="text" value="{{$nhfStaff->fileNo}}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label>Department</label>
                                <input class="form-control" type="text" value="{{$nhfStaff->Dept}}" readonly>
                            </div>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-12" id="divIDx">
                    <div class="form-group">
                            <div class="col-md-6">
                                <label>Phone No.</label>
                                <input class="form-control" type="text" value="{{$nhfStaff->phone}}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label>Email</label>
                                <input class="form-control" type="text" value="{{$nhfStaff->email}}" readonly>
                            </div>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-12" id="divIDx">
                    <div class="form-group">
                            <div class="col-md-12">
                                <label>NHF No.</label>
                                <input class="form-control" name="nhfNo" type="text" value="{{$nhfStaff->nhfNo}}" required>
                            </div>
                    </div>
                </div>
                </div>

                <div class="" style="margin-top:22px;">
                        <a href="{{url('nhf-staff-list')}}"> <button type="button" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Back</button> </a>

                        <button type="submit" class="btn btn-success" name="Save">
                            <i class="fa fa-btn fa-floppy-o"></i> Update Nhf No.
                        </button>
                    
                </div>

            </div>

            <div class="col-md-2"></div>
        </div>
        </form>

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

@endsection