@extends('layouts.layout')
@section('pageTitle')
Leave Approval
@endsection

@section('content')

<div class="box box-default" style="border: none;">
  <div class="box-body box-profile" style="margin:10px 20px;">
		<div class="row">
      <div align="center"><h3>VOLUME</h3></div>
        <hr />
        @includeIf('Share.message')
        <form method="post" action="{{route('saveVolume')}}">
          @csrf
          <div class="col-md-4 p-2">
            <label for="disabledTextInput" class="form-label">Volume Name</label>
            <input type="text" name="volume" class="form-control" />
          </div>

          {{-- <div class="col-md-4 p-2">
            <label for="disabledTextInput" class="form-label">Department</label>
            <select class="js-example-basic-single" name="dept" required class="form-control" aria-label=".form-select-lg example">
              <option selected>Select Department</option>
              @foreach ($allDepartment as $item)
                <option value="{{$item->id}}">{{$item->department}}</option>
              @endforeach
            </select>
          </div> --}}

          {{-- <div class="col-md-4 p-2">
            <label for="disabledTextInput" class="form-label">Stage</label><br>
            <select class="js-example-basic-single" name="stage" required class="form-control" aria-label=".form-select-lg example">
              <option selected>Select Stage</option>
              @foreach ($allStages as $item)
                <option value="{{$item->stageID}}">{{$item->approval_name}}</option>
              @endforeach
            </select>
          </div> --}}
          <div align="center" class="col-md-4">
                <br />
                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-edit"></i></button>
                {{-- <hr />		  	  --}}
          </div>
        </form>
      </div>
    <br>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col"> NAME</th>
                {{-- <th scope="col">Edit</th>
                <th scope="col">Delete</th>
                <th scope="col">Action</th> --}}
                <th>ACTION</th>
              </tr>
            </thead>
            @php $i = 1; @endphp
            @foreach ($getVolume as  $key => $value)
              <tbody>
                <tr>
                  <th scope="row">{{ $i++}}</th>
                  <td>{{$value->volume_name}}</td>
                  {{-- <td>{{$value->approval_name}}</td>
                  <td>{{$value->department}}</td> --}}
                  <td><!-- Button trigger modal -->
                    <a href="javascript:;" data-toggle="modal" class="btn btn-sm btn-warning" data-backdrop="false" data-target="#editApplication{{$key}}" title="Edit this application">edit <i class="fa fa-edit"></i></a>
                    {{-- <button onclick="myFunction()" class="btn btn-danger">Delete</button> --}}
                    <a href="javascript:;" data-toggle="modal" class="btn btn-sm btn-danger" data-backdrop="false" data-target="#deleteApplication{{$value->ID}}" title="delete this application">delete <i class="fa fa-remove"></i></a>
                  </td>
                </tr>
              </tbody>

              <form method="post" action="{{url('/save-volume')}}" class="form-horizontal">
              @csrf
              <input type="hidden" name="recordID" value="{{$value->ID}}" />
              <!-- Modal -->
              <div class="modal fade text-left d-print-none" id="editApplication{{$key}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel12" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Volume</h5>
                      {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-8" style="margin-bottom: 1em;">
                            <label for="disabledTextInput" class="form-label">Volume Name</label>
                            <input type="hidden" name="recordID" class="form-control" value="{{$value->ID}}"/>{{$value->volume_name}}
                            <input type="text" name="volume" class="form-control" value="{{$value->volume_name}}     "/>
                        </div>
                        {{-- <div class="col-lg-8" style="margin-bottom: 1em;">
                          <label for="disabledTextInput" class="form-label">Department</label><br>
                          <select class="js-example-basic-single wide" name="dept" required class="form-control" style="width: 27em;">
                            <option value="{{$value->id}}" selected>{{$value->department}}</option>
                            <option value="0">Select Department</option>
                            @foreach ($allDepartment as $item)
                              <option value="{{$item->id}}">{{$item->department}}</option>
                            @endforeach
                          </select>
                        </div> --}}
                        {{-- <div class="col-lg-8" style="margin-bottom: 1em;">
                          <label for="disabledTextInput" class="form-label">Stage</label><br>
                          <select class="js-example-basic-single" name="stage" required class="form-control" style="width: 27em;">
                            <option value="{{$value->action_stageID}}" selected>{{$value->approval_name}}</option>
                            <option value="0">Select Stage</option>
                            @foreach ($allStages as $item)
                              <option value="{{$item->stageID}}">{{$item->approval_name}}</option>
                            @endforeach
                          </select>
                        </div> --}}
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                      <button type="submit" class="btn btn-primary">Update changes</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>


              {{-- delete modal --}}
              <div class="modal fade text-left d-print-none" id="deleteApplication{{$value->ID}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel123" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Delete Volume</h5>
                      {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                      <P>Are you sure you want to delete this record?</P>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-danger" data-dismiss="modal">{{ __('Close') }}</button>
                      <a href="{{url('delete-volume/'. $value->ID)}}" class="btn btn-danger ">Yes, delete!!</a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </table>
        </div>
      </div>

  </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script type="text/javascript">
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script></script>
<script>
function myFunction() {
  var txt;
  if (confirm("Press a button!")) {
    txt = "You pressed OK!";
  } else {
    txt = "You pressed Cancel!";
  }
  document.getElementById("demo").innerHTML = txt;
}

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>


@endsection
