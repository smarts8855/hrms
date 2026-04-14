@extends('layouts.layout')
@section('pageTitle')
    Staff Variable List
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Error!</strong>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        @if ($error != '')
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Error!</strong>
                <p>{{ $error }}</p>
            </div>
        @endif

        @if ($success != '')
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Success!</strong> <br />
                {{ $success }}
            </div>
        @endif
        @if (session('err'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Input Error!</strong> <br />
                {{ session('err') }}
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
                                            {{ $division == $b->divisionID ? 'selected' : '' }}>{{ $b->division }}
                                        </option>
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
                            <label class="control-label">Variable Type</label>
                            <select required name="cvtype" class="form-control" id="cvtype" onchange="Reload()">
                                <option value="">-select Description</option>
                                @foreach ($EarningDeductionType as $desc)
                                    <option value="{{ $desc->ID }}" {{ $desc->ID == $cvtype ? 'selected' : '' }}>
                                        {{ $desc->Particular }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <select name="cv" class="form-control" id="cvdesc" onchange="Reload()">
                                <option value="">-select Description</option>
                                @foreach ($cvdesc as $desc)
                                    <option value="{{ $desc->ID }}" {{ $desc->ID == $cv ? 'selected' : '' }}>
                                        {{ $desc->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <br>
                            <button type="submit" class="btn btn-success" name="add">
                                <i class="fa fa-btn fa-floppy-o"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                                <table class="table table-bordered table-striped table-highlight">
                                    <thead>
                                        <tr bgcolor="#c7c7c7">


                                            <th>S/N</th>
                                            <th>Staff No</th>
                                            <th>Staff Name</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @php $i = 1; @endphp
                                    <tbody>

                                        @foreach ($staffCVList as $list)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $list->fn }}</td>
                                                <td>{{ $list->NAMES }}</td>
                                                <td>{{ $list->amount }}</td>
                                                <td>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

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

        function Reload() {
            document.forms["mainform"].submit();
            return;
        }
    </script>
@endsection
