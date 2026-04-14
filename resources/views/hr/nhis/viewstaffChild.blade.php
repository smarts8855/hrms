@extends('layouts.layout')
@section('pageTitle')
    NHIS
@endsection

@section('content')

    <div class="row">
        <div class="col-md-5">
            <div class="box box-default" style="margin:10px 20px;">

                <!-- Spouse Information Panel -->
                <div class="panel panel-default" style="border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                    <div class="panel-heading" style="background:#f5f5f5; border-bottom:1px solid #ddd;">
                        <div class="row">
                            <div class="col-xs-6">
                                <h4 class="panel-title text-uppercase" style="font-weight:600;">Spouse Information</h4>
                            </div>
                            <div class="col-xs-6 text-right">
                                <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#editApplication" title="Add new child">
                                    <i class="fa fa-child"></i> &nbsp; Add New Child
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="panel-body text-center">
                        @includeIf('hr.Share.message')

                        <img src="https://www.pngitem.com/pimgs/m/22-223925_female-avatar-female-avatar-no-face-hd-png.png"
                            class="img-circle" alt="Spouse Image"
                            style="width:7rem; height:7rem; object-fit:cover; border:3px solid #eee; margin-bottom:15px;">

                        @if (!empty($spouse) && $spouse->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Wife Name</th>
                                            <th>State of Origin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($spouse as $index => $spouses)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $spouses->wifename }}</td>
                                                <td>{{ $spouses->homeplace }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No spouse information available.</p>
                        @endif


                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editApplication" tabindex="-1" role="dialog" aria-labelledby="myModalLabel12"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius:8px;">
                    <div class="modal-header"
                        style="background:#337ab7; color:#fff; border-top-left-radius:8px; border-top-right-radius:8px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:#fff;">×</button>
                        <h4 class="modal-title" id="exampleModalLabel">
                            <i class="fa fa-child"></i> Add Child
                        </h4>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ url('/staff-nhis-add') }}" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="recordID" value="{{ $staffname->ID }}" />
                            <input type="hidden" name="fileno" value="{{ $staffname->fileNo }}" />

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Full Name</label>
                                    <input type="text" name="fullname" class="form-control" placeholder="Enter full name"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <label class="control-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control" min="2000-01-01" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="control-label">Gender</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer" style="border-top:none;">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Child
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="box box-default" style="border: none;">
                <div class="box-body box-profile" style="margin:10px 20px;">
                    <div class="box-header with-border hidden-print">
                        <div class="row">
                            <div class="col-xs-6">
                                <h3 class="box-title text-uppercase">
                                    {{ $staffname->surname }} {{ $staffname->first_name }}'s Children
                                </h3>
                            </div>
                            <div class="col-xs-6 text-right">
                                <a href="{{ route('staff-nhis') }}" class="btn btn-danger btn-sm">
                                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                                    &nbsp;Back
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary mt-3">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Age</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($staffChild as $key => $value)
                                            @php
                                                $age = \Carbon\Carbon::parse($value->dateofbirth)->diff(
                                                    \Carbon\Carbon::now(),
                                                )->y;
                                            @endphp
                                            
                                            @if ($age <= 17)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $value->fullname }}</td>
                                                    <td>{{ $value->childGender }}</td>
                                                    <td>
                                                        @if ($age == 0)
                                                            Not up to a year old!!
                                                        @else
                                                            {{ $age }} Years
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" data-toggle="modal" data-backdrop="false"
                                                            data-target="#deleteApplication{{ $value->id }}"
                                                            class="btn btn-sm btn-danger" title="Delete this record">
                                                            <i class="fa fa-remove"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>

                                                {{-- Delete Modal --}}
                                                <div class="modal fade text-left d-print-none"
                                                    id="deleteApplication{{ $value->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel{{ $value->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $value->id }}">
                                                                    Delete Record
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this record?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-danger"
                                                                    data-dismiss="modal">Close</button>
                                                                <a href="{{ url('staff-nhis-delete/' . $value->id) }}"
                                                                    class="btn btn-danger">Yes, delete!!</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>

                                @if ($i === 1)
                                    <div class="alert alert-info text-center mt-3">
                                        No children under 17 found for this staff.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script type="text/javascript">
        < script src = "{{ asset('assets/js/jquery-ui.min.js') }}" >
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            //picking the current date to set as a maximum date of birth input
            var today = new Date();

            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;
            $("#birthday").attr("max", today);
        });
    </script>
@endsection
