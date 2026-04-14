@extends('layouts.layout')
@section('pageTitle')
    AIE File Upload
@endsection

@section('content')

    <div class="modal fade" id="exampleModalLabelAddUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add File
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="" name="" role="form" method="post"
                        action="{{ route('display.uploadFile') }}" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    @if ($CourtInfo->courtstatus == 1)
                                        <div class="col-md-6">
                                            <label class="control-label">Court</label>
                                            <select required class="form-control" id="court" name="court">
                                                <option value="">-select Court</option>
                                                @foreach ($courtList as $list)
                                                    <option value="{{ $list->id }}"
                                                        {{ $court == $list->id ? 'selected' : '' }}>
                                                        {{ $list->court_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <input type="hidden" id="court" name="court"
                                            value="{{ $CourtInfo->courtid }}">
                                    @endif

                                    @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                                        <div class="col-md-6">
                                            <label class="control-label">Division</label>

                                            <select required class="form-control" id="division" name="division">

                                                <option value="" selected>select division-</option>
                                                @foreach ($courtDivisions as $list)
                                                    <option value="{{ $list->divisionID }}"
                                                        @if (session('adddivsession') == $list->divisionID) selected @endif>
                                                        {{ $list->division }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <label>Division</label>
                                            <input type="text" class="form-control" id="divisionName" name="divisionName"
                                                value="{{ $curDivision->division }}" readonly>
                                        </div>
                                        <input type="hidden" id="division" name="division"
                                            value="{{ Auth::user()->divisionID }}">

                                    @endif

                                    <div class="col-md-6">
                                        <label> Select a Month </label>
                                        <select name="month" id="section" class="form-control" required>
                                            <option value="">Select Month </option>
                                            <option value="JANUARY" @if (session('addmonth') == 'JANUARY') selected @endif>
                                                January
                                            </option>
                                            <option value="FEBRUARY" @if (session('addmonth') == 'FEBRUARY') selected @endif>
                                                February
                                            </option>
                                            <option value="MARCH" @if (session('addmonth') == 'MARCH') selected @endif>
                                                March
                                            </option>
                                            <option value="APRIL" @if (session('addmonth') == 'APRIL') selected @endif>
                                                April
                                            </option>
                                            <option value="MAY" @if (session('addmonth') == 'MAY') selected @endif>
                                                May</option>
                                            <option value="JUNE" @if (session('addmonth') == 'JUNE') selected @endif>
                                                June
                                            </option>
                                            <option value="JULY" @if (session('addmonth') == 'JULY') selected @endif>
                                                July
                                            </option>
                                            <option value="AUGUST" @if (session('addmonth') == 'AUGUST') selected @endif>
                                                August
                                            </option>
                                            <option value="SEPTEMBER" @if (session('addmonth') == 'SEPTEMBER') selected @endif>
                                                September</option>
                                            <option value="OCTOBER" @if (session('addmonth') == 'OCTOBER') selected @endif>
                                                October
                                            </option>
                                            <option value="NOVEMBER" @if (session('addmonth') == 'NOVEMBER') selected @endif>
                                                November
                                            </option>
                                            <option value="DECEMBER" @if (session('addmonth') == 'DECEMBER') selected @endif>
                                                December
                                            </option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Select a Year</label>
                                        <select name="year" id="section" class="form-control" required>
                                            <option value="">Select Year</option>
                                            @for ($i = 2011; $i <= 2040; $i++)
                                                <option value="{{ $i }}"
                                                    @if (session('addyear') == $i) selected @endif>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="control-label">File</label>
                                        <input require type="file" value="" name="upload" readonly="readonly"
                                            class="form-control" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Select File Type</label>
                                        <select name="aieTypeID" id="aieTypeID" class="form-control" required>
                                            <option value="">Select File Type</option>
                                            @foreach ($fileTypes as $type)
                                                <option value="{{ $type->id }}"
                                                    @if (session('adddescription') == $type->fileType) selected @endif>
                                                    {{ $type->fileType }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label></label>
                                        <div>
                                            <button name="upload_aie" type="submit"
                                                class="btn btn-success btn-sm pull-right">Upload
                                                File</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>

            <div class="col-md-12">
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

                @if ($error_new != '')
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                        <p>{{ $error_new }}</p>
                    </div>
                @endif
                @if ($warning != '')
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Warning!</strong>
                        <p>{{ $warning }}</p>
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

            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div>
                                <button type="button" data-toggle="modal" data-target="#exampleModalLabelAddUpload"
                                    class="btn btn-sm btn-success pull-right">Add File</button>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-md-12">

                        <!--1st col-->
                        {{-- @include('Share.message') --}}

                        <form method="POST" action="{{ route('display.uploadFile') }}">

                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <!--2nd col-->
                                    <!-- /.row -->
                                    <div class="form-group">
                                        @if ($CourtInfo->courtstatus == 1)
                                            <div class="col-md-4">
                                                <label class="control-label">Court</label>
                                                <select required class="form-control" id="court"
                                                    onchange="getDivisions()" name="court">
                                                    <option value="">-select Court</option>
                                                    @foreach ($courtList as $list)
                                                        <option value="{{ $list->id }}"
                                                            {{ $court == $list->id ? 'selected' : '' }}>
                                                            {{ $list->court_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <input type="hidden" id="court" name="court"
                                                value="{{ $CourtInfo->courtid }}">
                                        @endif

                                        @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                                            <div class="col-md-4">
                                                <label class="control-label">Division</label>
                                                <select class="form-control" id="division" name="division">
                                                    <option value="" selected>All division-</option>
                                                    @foreach ($courtDivisions as $list)
                                                        @if ($list->divisionID == old('division'))
                                                            <option value="{{ $list->divisionID }}" selected>
                                                                {{ $list->division }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $list->divisionID }}">{{ $list->division }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <div class="col-md-4">
                                                <label>Division</label>
                                                <input type="text" class="form-control" id="divisionName"
                                                    name="divisionName" value="{{ $curDivision->division }}" readonly>
                                            </div>
                                            <input type="hidden" id="divisionID" name="division"
                                                value="{{ Auth::user()->divisionID }}">
                                        @endif

                                        <div class="col-md-4">
                                            <label> Select a Month </label>
                                            <select name="month" id="section" class="form-control">
                                                <option value="">Select Month </option>
                                                <option value="JANUARY"
                                                    @if (session('month') == 'JANUARY') selected @endif>
                                                    January
                                                </option>
                                                <option value="FEBRUARY"
                                                    @if (session('month') == 'FEBRUARY') selected @endif>
                                                    February
                                                </option>
                                                <option value="MARCH" @if (session('month') == 'MARCH') selected @endif>
                                                    March
                                                </option>
                                                <option value="APRIL" @if (session('month') == 'APRIL') selected @endif>
                                                    April
                                                </option>
                                                <option value="MAY" @if (session('month') == 'MAY') selected @endif>
                                                    May</option>
                                                <option value="JUNE" @if (session('month') == 'JUNE') selected @endif>
                                                    June
                                                </option>
                                                <option value="JULY" @if (session('month') == 'JULY') selected @endif>
                                                    July
                                                </option>
                                                <option value="AUGUST" @if (session('month') == 'AUGUST') selected @endif>
                                                    August
                                                </option>
                                                <option value="SEPTEMBER"
                                                    @if (session('month') == 'SEPTEMBER') selected @endif>
                                                    September</option>
                                                <option value="OCTOBER"
                                                    @if (session('month') == 'OCTOBER') selected @endif>
                                                    October
                                                </option>
                                                <option value="NOVEMBER"
                                                    @if (session('month') == 'NOVEMBER') selected @endif>November
                                                </option>
                                                <option value="DECEMBER"
                                                    @if (session('month') == 'DECEMBER') selected @endif>December
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Select a Year</label>
                                            <select name="year" id="section" class="form-control">
                                                <option value="">Select Year</option>
                                                @for ($i = 2011; $i <= 2040; $i++)
                                                    <option value="{{ $i }}"
                                                        @if (session('year') == $i) selected @endif>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>

                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div>
                                        <button type="submit" name="search"
                                            class="btn btn-warning btn-sm pull-righ">Search File Upload
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <br>
                        <hr>
                        <br>
                        <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                            <table class="table table-bordered table-striped table-highlight" id="data-table">
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                        <th>S/N</th>
                                        <th>Division</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @php $i = 1; @endphp
                                <tbody>
                                    @foreach ($uploads as $list)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $list->division }}</td>
                                            <td>
                                                <a href="{{ asset($list->upload) }}" download="{{ $list->upload }}"
                                                    target="_blank">{{ $list->fileType }}</a>
                                            </td>
                                            <td>
                                                <button type="button" data-toggle="modal"
                                                    data-target="#exampleModalLabel{{ $list->fileID }}"
                                                    class="btn btn-sm btn-danger">Delete</button>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="exampleModalLabel{{ $list->fileID }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog box box-default" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Delete File</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form class="form-horizontal" id="deletevariableModal" role="form"
                                                        method="POST" action="{{ route('display.uploadFile') }}">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <div class="form-group" style="margin: 0 10px;">
                                                                <div class="col-sm-12">
                                                                    <label class="col-sm-9 control-label"><b>Are you
                                                                            sure you want to delete this
                                                                            file?</b></label>
                                                                </div>
                                                                <input type="hidden" id="deleteid" name="id"
                                                                    value="{{ $list->fileID }}">
                                                                <input type="hidden" id="month" name="month"
                                                                    value="{{ $list->month }}">
                                                                <input type="hidden" id="year" name="year"
                                                                    value="{{ $list->year }}">
                                                                <input type="hidden" id="divisionID" name="division"
                                                                    value="{{ $list->divisionID }}">

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button name="delete_upload"
                                                                class="btn btn-danger delete">Delete</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">No</button>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr />
                    </div>

                </div>
            </div>


        @endsection

        @section('styles')
            <style type="text/css">
                .modal-dialog {
                    width: 13cm
                }

                .modal-header {

                    background-color: #006600;

                    color: #FFF;

                }

                #partStatus {
                    width: 2.5cm
                }
            </style>
        @endsection

        @section('scripts')
            <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
            <script>
                function addfunc(x) {

                    $("#exampleModalLabelAddUpload").modal('show')
                }

                function editfunc(x, y, z, a, n, r) {
                    document.getElementById('edit-hidden').value = x;
                    document.getElementById('deleteid').value = null;
                    document.getElementById('courtid1').value = z;
                    document.getElementById('divid1').value = a;
                    document.getElementById('mmt').value = n;
                    document.getElementById('remarks').value = r;

                    $("#editModal").modal('show')
                }

                function deletefunc(x, y, z, a, n, ) {
                    // alert(a);
                    document.getElementById('deleteid').value = x;
                    document.getElementById('month').value = y;
                    document.getElementById('year').value = z;
                    document.getElementById('divisionID').value = a;
                    document.getElementById('old_image').value = n;
                    $("#DeleteModal").modal('show');
                }

                function Reload() {
                    document.forms["mainform"].submit();
                    return;
                }
            </script>
