@extends('layouts.layout')
@section('extraLinks')
     {{-- Select2.org Links for select tags--}}
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection


@section('pageTitle')
Assign Heads Of Departments
@endsection

@section('content')
<div id="page-wrapper" class="box box-default">
  <div class="container-fluid">
    <div class="col-md-12 text-success"><!--2nd col-->
      <big><b>@yield('pageTitle')</b></big> </div>
    <br />
    <hr >
    <div class="row">
      <div class="col-md-9"> <br>
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Error!</strong> @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach </div>
        @endif

        @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Success!</strong> {{ session('message') }}</div>
        @endif
        @if(session('error_message'))
        <div class="alert alert-error alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Error!</strong> {{ session('error_message') }}</div>
        @endif
        <form method="post" action="{{ route('Department.Head.Assign') }}" class="form-horizontal">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="staffs" class="col-md-3 control-label" name="staffName">Select Staff</label>
            <div class="col-md-9">
              <select name="staff" class="form-select form-control" id="staffs" required>
                <option selected disabled>Pick A Staff</option>
                @foreach ($staffDetails as $staffDetail)
                    <option value="{{$staffDetail->ID}}">{{$staffDetail->first_name . " " . $staffDetail->surname}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="departments" class="col-md-3 control-label">Select Department</label>
            <div class="col-md-9">
                <select name="department" class="form-select form-control" id="departments" required>
                    <option selected disabled>Pick A Department</option>
                    @foreach ($departments as $department)
                        <option value="{{$department->department}}">{{$department->department}}</option>
                    @endforeach
                </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <button type="submit" class="btn btn-success btn-sm pull-right">Assign Head</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="page-wrapper" class="box box-default">
<div class="box-body">
  <h2 class="text-center">All Department Heads</h2>
  <div class="row"> {{ csrf_field() }}
    <div class="col-md-12">
      <table class="table table-striped table-condensed table-bordered input-sm">
        <thead>
          <tr class="input-sm">
            <th>S/N</th>
            <th>DEPARTMENT</th>
            <th>HEAD</th>
            <th>FILE NO.</th>
            <th>ACTIONS</th>
          </tr>
        </thead>
        <tbody>
            @php
                $int = 0
            @endphp
            @foreach ($extraData as $data)
                <tr>
                    <td>{{++ $int}}</td>
                    <td>{{$data->department}}</td>
                    <td>{{$data->first_name . ' ' . $data->surname}}</td>
                    <td>{{$data->fileNo}}</td>
                    <td>
                        <button title="Edit" class="btn btn-success fa fa-edit edit"  departmentId="{{$data->id}}" departmentName="{{$data->department}}" ></button>
                        <button title="Delete" class="btn btn-danger delete"  departmentId="{{$data->id}}" departmentName="{{$data->department}}" ><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </td>
                </tr>
            @endforeach

        </tbody>
      </table>
      <hr />
     {{--  <div align="right">
          Showing {{($submodules->currentpage()-1)*$submodules->perpage()+1}}
                  to {{$submodules->currentpage()*$submodules->perpage()}}
                  of  {{$submodules->total()}} entries
      </div> --}}
      {{-- <div class="hidden-print">{{ $submodules->links() }}</div> --}}
    </div>
  </div>
  <!-- /.col -->
</div>



    {{-- MODALS FOR UPDATING AND DELETING RECORDS --}}

    {{-- Update Modal --}}
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title" id="exampleModalLabel">Edit Departmental Head For <span class="deptName lead"></span> </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{route('Department.Head.Update')}}" method="post">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <div class="row">

                            <div class="form-group">
                                <label for="staffs" class="col-md-3 control-label">Select Staff</label>
                                <div class="col-md-9">
                                    <select name="staff" class="form-select form-control" id="staffs2" required>
                                    <option selected disabled>Pick A Staff</option>
                                    @foreach ($staffDetails as $staffDetail)
                                        <option value="{{$staffDetail->ID}}">{{$staffDetail->first_name . " " . $staffDetail->surname}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <br>

                            <div class="form-group ">
                                <label for="departments2" class="col-md-3 control-label">Choose a department</label>
                                <div class="col-md-9">
                                    <select name="department" class="form-select form-control" id="departments2" required>
                                        <option selected disabled>Pick A Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{$department->department}}">{{$department->department}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="departmentId" id="departmentId" value="">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" value="Save" class="btn btn-primary">
                </div>
            </form>
          </div>
        </div>
    </div>


    {{-- Delete Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title" id="exampleModalLabel">Delete Record for <span class="deptName lead"></span> !!!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('Department.Head.Delete')}}" method="post">
                @csrf
                @method('delete')

                <div class="modal-body">
                    Are you sure you want to delete this record?
                    <input type="hidden" name="departmentId" id="departmentId2" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" value="Delete" class="btn btn-danger">
                </div>
            </form>
        </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('#staffs').select2();
            $('#departments').select2();
         /*    $('#staffs2').select2();
            $('#departments2').select2(); */

            //Bring up the update/edit modal
            $('.edit').click(function() {
                var departmentId = $(this).attr('departmentId');
                var departmentName = $(this).attr('departmentName');

                $('#departmentId').val(departmentId);
                $('.deptName').text(departmentName);

                $('#updateModal').modal('show');
            })

            //Bring up the delete modal
            $('.delete').click(function() {
                var departmentId = $(this).attr('departmentId');
                var departmentName = $(this).attr('departmentName');

                $('#departmentId2').val(departmentId);
                $('.deptName').text(departmentName);

                $('#deleteModal').modal('show');
            })
        });
    </script>
@endsection

