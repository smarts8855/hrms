@extends('layouts.layout')
@section('pageTitle')
    Staff Salary Computation
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        @if ($warning != '')
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>{{ $warning }}</strong>
            </div>
        @endif
        @if ($success != '')
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>{{ $success }}</strong>
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
        <form method="post" id="thisform1" name="thisform1" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="row">
                    @if ($CourtInfo->courtstatus == 1)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Court</label>
                                <select name="court" id="court" class="form-control" style="font-size: 13px;"
                                    onchange="ReloadForm();">
                                    <option value="">Select Court</option>
                                    @foreach ($CourtList as $b)
                                        <option value="{{ $b->id }}" {{ $court == $b->id ? 'selected' : '' }}>
                                            {{ $b->court_name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    @else
                        <input type="hidden" id="court" name="court" value="{{ $CourtInfo->courtid }}">
                    @endif
                    @if ($CourtInfo->divisionstatus == 1)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Division</label>

                                <select name="division" id="division" class="form-control" style="font-size: 13px;">
                                    <option value="All">All Division</option>
                                    @foreach ($DivisionList as $b)
                                        <option value="{{ $b->divisionID }}"
                                         44   {{ $division == $b->divisionID ? 'selected' : '' }}>{{ $b->division }}-{{ $b->divisionID }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="division" name="division" value="{{ $CourtInfo->divisionid }}">
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="Text" name="year" id="year" class="form-control"
                                value="{{ $PayrollActivePeriod->year }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="month">Month</label>
                            <input type="Text" name="month" id="month" class="form-control"
                                value="{{ $PayrollActivePeriod->month }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="month">Bank(Jacket)</label>
                            <select name="bank" id="bank" class="form-control" style="font-size: 13px;">
                                <option value="All">-All Bank-</option>
                                @foreach ($banklist as $b)
                                    <option value="{{ $b->bankID }}" {{ $bank == $b->bankID ? 'selected' : '' }}>
                                        {{ $b->bank }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for=""></label>

                            <div align="right">
                                <input class="btn btn-success" name="Compute" type="submit" value="Compute" />
                                <input class="btn btn-success" name="Re-Compute" type="submit" value="Re-Compute" />
                            </div>

                        </div>

                    </div>

                </div>


            </div>



        </form>

    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript">
        function ReloadForm() {
            //alert("ururu")	;
            document.getElementById('thisform1').submit();
            return;
        }

        function DeletePromo(id) {
            var cmt = confirm('You are about to delete a record. Click OK to continue?');
            if (cmt == true) {
                document.getElementById('delcode').value = id;
                document.getElementById('thisform1').submit();
                return;

            }

        }
    </script>
@endsection
