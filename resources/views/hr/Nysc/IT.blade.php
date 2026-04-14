@extends('layouts.layout')
@section('pageTitle')
    IT
@endsection

@section('content')
    <div class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:10px 20px;">
            <div class="row">
                <div align="center">
                    <h3>Register IT Student</h3>
                </div>
                <hr />
                @includeIf('Share.message')

                <form method="post" action="{{ url('/IT-save') }}" class="form-horizontal">
                    @csrf

                    <div class="col-md-6">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstname" placeholder="First name"
                            aria-label="First name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastname" placeholder="Last name"
                            aria-label="Last name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="staticEmail2" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="staticEmail2" required>
                    </div>
                    <div class="col-md-6">
                        <label for="staticEmail2" class="form-label">Phone</label>
                        <input type="tel" class="form-control" name="phone" id="staticEmail2" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword2" class="form-label">Course</label>
                        <input type="text" class="form-control" name="course" placeholder="course"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="start Date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="startDate" aria-label="Server"
                            placeholder="IT start Date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end Date" class="form-label">End Date</label>
                        <input type="date" class="form-control" name="endDate" aria-label="Server"
                            placeholder="IT end Date" class="form-control" required>
                    </div>

                    <div class="col-md-12" style="margin-top: 1rem;">
                        <button type="submit" class="btn btn-primary mb-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col" colspan="2" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    @php $i = 1; @endphp
                    @foreach ($form as $key => $value)
                        <tbody>
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td>{{ $value->firstname }} {{ $value->lastname }}</td>
                                <td>{{ $value->phonenumber }}</td>
                                <td>{{ \Carbon\Carbon::parse($value->start)->isoFormat('D MMMM Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($value->end)->isoFormat('D MMMM Y') }}</td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <a href="javascript:;" data-toggle="modal" class="btn btn-sm btn-warning"
                                        data-backdrop="false" data-target="#editApplication{{ $key }}"
                                        title="Edit this application"><i class="fa fa-edit"></i></a>
                                </td>
                                <td>
                                    <form action="/IT-delete/{{$value->id}}" method="POST">
                                        @csrf @method('DELETE')
                                          <button type="submit" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                                      </form>
                                </td>
                            </tr>
                        </tbody>

                        <form method="post" action="{{ url('IT-edit/' . $value->id) }}" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="recordID" value="{{ $value->id }}" />
                            <!-- Modal -->
                            <div class="modal fade text-left d-print-none" id="editApplication{{ $key }}"
                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel12" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Corper Information</h5>
                                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                {{-- <input type="hidden" name="recordID" value="{{$value->Id}}" /> --}}
                                                <div class="col-md-6" style="margin-bottom: 1em;">
                                                    <label for="disabledTextInput" class="form-label">First Name</label>
                                                    <input type="hidden" name="recordID" class="form-control"
                                                        value="{{ $value->id }}" />
                                                    <input type="text" name="firstname" class="form-control"
                                                        value="{{ $value->firstname }}" required />
                                                </div>
                                                <div class="col-md-6" style="margin-bottom: 1em;">
                                                    <label for="disabledTextInput" class="form-label">Last Name</label>
                                                    <input type="text" name="lastname" class="form-control"
                                                        value="{{ $value->lastname }}" required />
                                                </div>
                                                <div class="col-md-6" style="margin-bottom: 1em;">
                                                    <label for="disabledTextInput" class="form-label">Email</label>
                                                    <input type="text" name="email" class="form-control"
                                                        value="{{ $value->email }}" required />
                                                </div>
                                                <div class="col-md-6" style="margin-bottom: 1em;">
                                                    <label for="disabledTextInput" class="form-label">Phone</label>
                                                    <input type="text" name="phone" class="form-control"
                                                        value="{{ $value->phonenumber }}" required />
                                                </div>

                                                <div class="col-md-6" style="margin-bottom: 1em;">
                                                    <label for="disabledTextInput" class="form-label">Course</label>
                                                    <input type="text" name="course" class="form-control"
                                                        value="{{ $value->course }}" required />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="start Date" class="form-label">Start Date</label>
                                                    <input type="date" class="form-control" name="startDate" aria-label="Server"
                                                        placeholder="IT start Date" value="{{$value->start}}" class="form-control" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="end Date" class="form-label">End Date</label>
                                                    <input type="date" class="form-control" name="endDate" aria-label="Server"
                                                        placeholder="IT end Date" value="{{$value->end}}" class="form-control" required>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-dismiss="modal">{{ __('Close') }}</button>
                                                <button type="submit" class="btn btn-primary">Update changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>

                    @endforeach
                </table>
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
        // function myFunction() {
        //   var txt;
        //   if (confirm("Press a button!")) {
        //     txt = "You pressed OK!";
        //   } else {
        //     txt = "You pressed Cancel!";
        //   }
        //   document.getElementById("demo").innerHTML = txt;
        // }

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
