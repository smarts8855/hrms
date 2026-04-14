@extends('layouts.layout')
@section('pageTitle')
    Dependant Entry
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
        <form method="post" id="thisform1" name="thisform1">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Dependant names</label>
                        <input type="text" name="dependant" class="form-control" value="{{ $dependant }}"
                            placeholder="Input dependant name">
                    </div>

                    <div class="col-md-2">
                        <label>Relationship</label>
                        <select name="relationship" id="relationship" class="form-control" required>
                            <option value="" selected>-Select Relationship-</option>
                            @foreach ($RelationList as $b)
                                <option value="{{ $b->id }}" {{ $relationship == $b->id ? 'selected' : '' }}>
                                    {{ $b->relationship }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>D.O.B</label>
                        <input type="text" name="dob" id="dateofBirth" class="form-control"
                            value="{{ $dob }}" required />
                    </div>

                    <div class="col-md-2">
                        <label>Gender</label>

                        <select name="gender" id="gender" class="form-control" required>
                            <option value="" selected>-Select Gender-</option>
                            @foreach ($GenderList as $b)
                                <option value="{{ $b->gender }}" {{ $gender == $b->gender ? 'selected' : '' }}>
                                    {{ $b->gender }}</option>
                            @endforeach
                        </select>

                    </div>


                    <div class="col-md-2">
                        <br>
                        <button type="submit" class="btn btn-success" name="add">
                            <i class="fa fa-btn fa-floppy-o"></i> Add New
                        </button>
                    </div>

                </div>
                <input id="delcode" type="hidden" name="delcode">
                <div class="table-responsive" style="font-size: 12px; padding:10px;">
                    <table class="table table-bordered table-striped table-highlight">
                        <thead>
                            <tr bgcolor="#c7c7c7">
                                <th width="1%">S/N</th>

                                <th>Dependant Name</th>
                                <th>Relationship</th>
                                <th>D.O.B</th>
                                <th>Dependant Gender</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php $serialNum = 1; @endphp

                        @foreach ($DependantList as $b)
                            <tr>
                                <td>{{ $serialNum++ }} </td>

                                <td>{{ $b->dependantName }}</td>
                                <td>{{ $b->dependantRelationships }}</td>
                                <td>{{ $b->dependantDOB }}</td>
                                <td>{{ $b->dependantGender }}</td>

                                <td><a href="javascript: DeletePromo('{{ $b->id }}')">Delete</a>
									<button type="button" class="btn btn-danger-info" data-toggle="modal" data-backdrop="false" data-target="#deleteDepandant{{$b->id }}">Delete</button>
									
								</td>
                            </tr>

                            <!-- Modal to delete -->
                            <form action='{{ url("/staff/dependant-delete/$b->id") }}' method="post">
                                @csrf
                                <div class="modal fade text-left d-print-none" id="deleteDepandant{{ $b->id }}"
                                    tabindex="-1" role="dialog" aria-labelledby="deleteDepandant" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm! </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-success text-center">
                                                    <h4>Are you sure you want to delete dependant {{$b->id}}?
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-info" data-dismiss="modal">
                                                    Cancel </button>
                                                <button type="submit" class="btn btn-success">
                                                    Confirm </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--end Modal-->
                        @endforeach

                    </table>
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
                // document.getElementById('thisform1').submit();
                return;

            }

        }
        $(function() {
            $("#dateofBirth").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#approvedate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#appointmentDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#incrementalDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#firstArrivalDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@endsection
