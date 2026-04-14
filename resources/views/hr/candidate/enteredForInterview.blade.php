@extends('layouts.layout')
@section('pageTitle')
    <strong>CANDIDATES FOR: {{ $interviewDetails->title }}</strong>
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
                    <a href="{{ url('interview') }}">
                        <button type="button" class="btn btn-primary">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                            Go
                            Back</button>
                    </a>
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

        <div class="table-responsive" style="font-size: 12px; padding:10px;">

            <table class="table table-bordered table-striped table-highlight table-responsive">
                <thead>
                    <tr bgcolor="#c7c7c7">
                        <th width="1%">S/N</th>
                        <th>NAME</th>
                        <th>CANDIDACY</th>
                        <th>EMAIL</th> {{-- new --}}
                        <th>SEX</th> {{-- new --}}
                        <th>ADDRESS</th>
                        <th>STATE</th>
                        <th>LGA</th>
                    </tr>
                </thead>
                @php $serialNum = 1; @endphp

                @forelse ($interviewList as $b)
                    <tr>
                        <td>{{ $serialNum++ }} </td>

                        <td>{{ $b->surname . ' ' . $b->first_name . ' ' . $b->othernames }} </td>
                        <td>{{ $b->candidate_source }}</td>
                        <td>{{ $b->email }}</td>
                        <td>{{ $b->sex }}</td>
                        <td>{{ $b->address }}</td>
                        <td> {{ $b->candidateState }} </td>
                        <td>{{ $b->candidateLga }}</td>

                    </tr>
                @empty
                    <h4><em>No Candidate has been entered for Interview</em></h4>
                @endforelse
            </table>
        </div>


    </div>
    </div>
@endsection


@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
@endsection
